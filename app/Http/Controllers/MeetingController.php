<?php

namespace App\Http\Controllers;

use App\MeetingAttendant;
use App\TaskUser;
use App\TopicTaskRelationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Meeting;
use App\User;
use App\DepartmentManagement;
use App\Task;
use App\Topic;

class MeetingController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.management.meeting.list');
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create($modal = 0)
	{
		$ref_no = 'Mtng-' . date('YmdHis');
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$users = User::where('company_id', $company_id)->get();
		$user_id = Auth::user()->id;
		$departments = DepartmentManagement::all();
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();
		$tasks = Task::where('company_id', $company_id)->where('deleted_at', null)->get();
		$modal_size = '';
		$hide_header = 0;

		return view('admin.pages.management.meeting.create', compact(
			'ref_no',
			'users',
			'user_id',
			'departments',
			'topics',
			'tasks',
			'modal',
			'modal_size',
			'hide_header'
		));
	}

	/**
	 * Update page
	 *
	 * @return View
	 */
	public function update($id)
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$users = User::where('company_id', $company_id)->get();
		$user_id = Auth::user()->id;
		$departments = DepartmentManagement::all();
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();
		$tasks = Task::where('company_id', $company_id)->where('deleted_at', null)->get();

		$mom = Meeting::findOrFail($id);
        $mom_tasks_idss = $mom->taskRelationships->unique('task_id');

		$meeting_attendants = MeetingAttendant::where('meeting_id',$id)->pluck('attendant_id')->all();

		return view('admin.pages.management.meeting.update', compact(
			'users',
			'user_id',
			'departments',
			'topics',
			'tasks',
            'mom',
            'meeting_attendants',
            'mom_tasks_idss'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id = 0)
	{
        $company_id = Auth::user()->company_id;
        $mom = Meeting::findOrFail($id);
		$users = Auth::user()->company ? Auth::user()->company->company_users : null;
        $topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();
        if($id == 0)
        {
            abort(404);
        }

        $relationships = TopicTaskRelationship::where('type', 1)->where('listing_id', $mom->id)->where('task_id' , '!=' , 0)->get();

        $arr_rshp = array();
        foreach ($relationships as $relationship) {
            array_push($arr_rshp, $relationship->task_id);
        }

        $all_tasks = Task::where('company_id', $company_id)
            //->whereDate('created_at', '<', date('Y-m-d', strtotime($mom->created_at)))
            ->whereIn('id', $arr_rshp)
            //->where('status',0)
						->get();

		$mom_topics = $mom->topicRelationships ? $mom->topicRelationships->pluck('topic_id')->all() : [];

		$users = Auth::user()->company ? Auth::user()->company->company_users : null;

		return view('admin.pages.management.meeting.detail', compact(
			'mom',
			'all_tasks',
			'users',
			'topics',
			'mom_topics'
		));
	}

	/**
	 * Task page
	 *
	 * @return View
	 */
	public function task($id)
	{
		return view('admin.pages.management.meeting.task_detail');
	}

	/**
	 * Get meetings.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function meeting_filter(Request $request)
	{
		$meetings_data = array();
		$meetings = Meeting::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$meetings->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		if($is_filter) {
			$total_meetings = count($meetings->get());
			$meetings = $meetings->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$meetings = Meeting::all();
				$total_meetings = count($meetings);
				$meetings = Meeting::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($meetings as $meeting) {
			$meetings_data[$count][] = $meeting->id;
			$meetings_data[$count][] = $meeting->reference_no;
			$meetings_data[$count][] = $meeting->subject;
			$meetings_data[$count][] = $meeting->department ? $meeting->department->department_short_name : '';
			$meetings_data[$count][] = $meeting->host->name;
			$meetings_data[$count][] = $meeting->location;
			$meetings_data[$count][] = date('Y-m-d H:i:s', strtotime($meeting->date)) . ' ' . $meeting->time;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_meetings,
			'recordsFiltered' => $total_meetings,
			'data' 						=> $meetings_data
		);
		return json_encode($data);
	}

	/**
	 * Get meetings.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function mom_filter(Request $request)
	{
		$meetings_data = array();
		$meetings = Meeting::select("*")->where('deleted_at', null)->where('company_id',Auth::user()->company_id);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$meetings->where('name','like', '%'.$request->get('search')['value'].'%');
		}

        if($request->input('topics'))
        {
             $is_filter = true;
            //get letter ids first
            $letter_ids = TopicTaskRelationship::where('type',1)->where('listing_id' , '>' , 0)
                ->where('company_id',Auth::user()->company_id)
                ->whereIn('topic_id',explode(',',$request->input('topics')))->pluck('listing_id')->all();

            $meetings->whereIn('id', $letter_ids);
        }

		if($is_filter) {
			$total_meetings = count($meetings->get());
			$meetings = $meetings->offset($start)->limit($length)->orderBy('meeting_date', 'desc')->get();

		}
		else {
				$meetings = Meeting::all();
				$total_meetings = count($meetings);
				$meetings = Meeting::where('deleted_at', null)->where('company_id',Auth::user()->company_id)->offset($start)->limit($length)->orderBy('meeting_date', 'desc')->get();
		}

		$count = 0;
		foreach ($meetings as $meeting) {
            $meetings_data[$count][] = date('Y-m-d', strtotime($meeting->meeting_date));
			$meetings_data[$count][] = $meeting->subject;
			$meetings_data[$count][] = $meeting->department ? $meeting->department->department_short_name : '';
			$meetings_data[$count][] = $meeting->host ? $meeting->host->getName() : '';
			$meetings_data[$count][] = $meeting->id;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_meetings,
			'recordsFiltered' => $total_meetings,
			'data' 						=> $meetings_data
		);
		return json_encode($data);
	}


    /**
     * Save Meeting
     *
     * @param Request $request
     * @return void
     */

    public function save_meeting(Request $request)
    {
        $meeting_id = 0;
        $message = "Error Occurred!";
        $status = false;
        try{
            $validator = Validator::make($request->all(), [
                'subject'     => 'required',
                'meeting_date' => 'required',
                'meeting_time' => 'required',
                'location'     => 'required',
                'dept_id' => 'required',
                'host_id' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }
           if($request->input('is_update')){
                $meeting = Meeting::find($request->input('listing_id'));
            }else{
               $meeting = new Meeting();
            }

            if(!$request->input('is_update')){
                $meeting->created_at = date('Y-m-d H:i:s');
            }
            $meeting->updated_at = date('Y-m-d H:i:s');

            $meeting->reference_no = 'M'.date('ymdHis');
            $meeting->subject = $request->input('subject');
            $meeting->location = $request->input('location');
            $meeting->dept_id = $request->input('dept_id');
            $meeting->host_id = $request->input('host_id');
            $meeting->summary = $request->input('summary');
            $meeting->meeting_date = db_date_format($request->input('meeting_date'));
            $meeting->meeting_time = $request->input('meeting_time');
            $meeting->created_by = Auth::user()->id;
            $meeting->company_id = Auth::user()->company_id;
            $attendants_array = $request->input('attendants');
            if($meeting->save())
            {
                $meeting_id = $meeting->id;
                if(isset($meeting_id) && !empty($meeting_id))
                {
                    if (!empty($attendants_array)) {
                        //if update then delete the existing records
                        if($request->input('is_update')){
                            $a = MeetingAttendant::where('meeting_id',$meeting_id)->delete();
                        }
                        foreach ($attendants_array as $attendant)
                        {
                            if(isset($attendant) && !empty($attendant))
                            {
                                $meeting_attendant = new MeetingAttendant();
                                $meeting_attendant->meeting_id = $meeting_id;
                                $meeting_attendant->attendant_id = $attendant;
                                $meeting_attendant->save();
                            }
                        }

                    }
                    $message = "Saved Successfully! ";
                    $status = true;
                }else{
                    $meeting_id = 0;
                    $message = "Error Occurred!";
                    $status = false;
                }


            }else{
                $message = "Error Occurred!";
                $status = false;
            }


        }catch (\Exception $e) {
            $message =  $e->getMessage();
            $status = false;
        }

        return response()->json([
            'success' => $status,
            'meeting_id' => $meeting_id,
						'message' =>$message,
						'is_modal' => $request->input('is_modal')
        ]);
    }

    /*
     * save mom for a meeting
     */
    public function save_meeting_mom(Request $request)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $listing_id = 0;
        $message = "Error Occurred!";
        $statusFinal = false;
        try {
            $validator = Validator::make($request->all(), [
                'meeting_id'	=> 'required',
                 'mom_contents' 			=> 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
            }

//            if ($request->input('is_update')) {
//                $mom = Meeting::find($request->input('listing_id'));
//            }else{
//                $mom = new Meeting();
//            }

            $meeting_id  = $request->input('meeting_id');
            $mom = Meeting::find($meeting_id);
            $mom->updated_at = date('Y-m-d H:i:s');
            $mom->mom_contents = $request->input('mom_contents');
            if ($mom->save()) {
                $listing_id = $mom->id;
                $message = 'MOM ' . $request->input('is_update') ? 'updated.' : 'created.';
                $statusFinal = true;

                //assign topics
                if ($request->input('topics')) {
                    foreach ($request->input('topics') as $topic) {

                        //if record already exists, first delete it
                        TopicTaskRelationship::where('company_id',$company_id)->where('listing_id',$listing_id)
                            ->where('type',1)->where('topic_id',$topic)->delete();

                        //save new record Now
                        $task_topic = new TopicTaskRelationship();
                        //$task_topic->task_id = $task->id;
                        $task_topic->topic_id = $topic;
                        $task_topic->listing_id = $listing_id;
                        $task_topic->type = 1;
                        $task_topic->company_id = $company_id;
                        $task_topic->created_by = $user_id;
                        $task_topic->created_at = date('Y-m-d H:i:s');
                        $task_topic->save();
                    }
                }

                $task_status = $request->input('task_status');
                $task_due_date = $request->input('task_due_date');
                $task_users = $request->input('task_users');
                $task_users = json_decode($task_users,true);

                $task_contents = $request->input('task_contents');

                if($request->input('task_title'))
                {
                    foreach ($request->input('task_title') as $key => $result)
                    {
                        if(!empty($result))
                        {
                            $task = new Task();
                            $task->created_by = $user_id;
                            $task->company_id = $company_id;
                            $task->created_at = date('Y-m-d H:i:s');
                            $task->title = $result;
                            $task->type = 1;
                            $task->status = $task_status ? $task_status[$key] : 0;

                            $task->start_date = date('Y-m-d H:i:s');
                            $task->due_date = date('Y-m-d H:i:s');
                            $task->contents = $task_contents ? $task_contents[$key]  : '';
                            if ($task->save()) {
                                $task_id = $task->id;
                                $task_topic = new TopicTaskRelationship();
                                $task_topic->topic_id = 0;
                                $task_topic->task_id = $task->id;
                                $task_topic->listing_id = $listing_id;
                                $task_topic->type = 1;
                                $task_topic->company_id = $company_id;
                                $task_topic->created_by = $user_id;
                                $task_topic->created_at = date('Y-m-d H:i:s');
                                $task_topic->save();

                                //save users


                                foreach ($task_users as $user) {
                                    $to_add = new TaskUser();
                                    $to_add->task_id = $task->id;
                                    $to_add->user_id = $user['id'];
                                    $to_add->save();


                                }
                            }
                        }
                    }
                }



            }else{
                $statusFinal = false;
                $message = "error occurred";
            }


        }catch (\Exception $e) {
            $statusFinal = false;
            $message =  $e->getMessage();
        }

        return response()->json([
            'success' => $statusFinal,
            'listing_id' => $listing_id,
            'message' => $message,
            'is_update' => $request->input('is_update')
        ]);
    }


    public  function  getMeetingHTMLData(Request $request)
    {

        if ($request->isMethod('post') && $request->ajax()) {
            $id = $request->input('pkgId');

            $mom = Meeting::where('id', $id)->first();

            $returnHTML_list = view('admin.partials.mom_popup')->with(compact('mom', $mom))->render();


            return response()->json(array('success' => true, 'list_data' => $returnHTML_list));
        }
    }

}
