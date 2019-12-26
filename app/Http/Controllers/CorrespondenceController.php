<?php

namespace App\Http\Controllers;

use App\Activities;
use App\DepartmentManagement;
use App\Task;
use App\Topic;
use App\TopicTaskRelationship;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\CorrespondenceMessage;
use App\CorrespondenceAddress;
use App\CorrespondenceCategory;
use App\CorrespondenceTag;

class CorrespondenceController extends Controller
{
  /**
	* Index page
	*
	* @return View
	*/
	public function index(Request $request)
	{
		$company_id =  Auth::user()->company_id;

		$messages = CorrespondenceMessage::select('*');
		$contacts = CorrespondenceAddress::select('*');

		if (Auth::user()->hasRole('itfpobadmin')) {
			$messages_in = CorrespondenceMessage::where('deleted_at', null)
							->where('direction', 'IN')->get();

			$messages_out = CorrespondenceMessage::where('deleted_at', null)
							->where('direction', 'OUT')->get();
		}
		else {
			$messages->where('company_id', $company_id);
			$contacts->where('company_id', $company_id);

			$messages_in = CorrespondenceMessage::where('company_id', $company_id)
							->where('deleted_at', null)->where('direction', 'IN')->get();

			$messages_out = CorrespondenceMessage::where('company_id', $company_id)
							->where('deleted_at', null)->where('direction', 'OUT')->get();
		}

		$contacts = $contacts->get();

		$contacts_users = User::where('company_id', $company_id)->get();

		$tasks = Task::where('company_id', $company_id)->get();
		$topics = Topic::where('company_id', $company_id)->get();

		return view('admin.pages.correspondence.correspondence', compact(
			'messages',
			'contacts',
			'messages_in',
			'messages_out',
			'tasks',
			'topics',
            'contacts_users'
		));
	}

	/**
	* Move to trash
	*
	* @return \Illuminate\Http\Response
	*/
	public function moveToTrash(Request $request)
	{
		$success = true;
		$message = '';
		$ids = $request->input('ids');

		if ($ids) {
			try {
				foreach ($ids as $id) {
					$message = CorrespondenceMessage::findOrFail($id);
					$message->deleted_at = date('Y-m-d H:i:s');

					if ($message->save()) {
						$message = 'Letters moved to trash.';
					}
					else {
						$success = false;
					}
				}

			}
			catch (\Exception $e) {
				$message =  $e->getMessage();
			}
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'ids' => $ids
		]);
	}

	/**
	* Messages filter
	*
	* @return \Illuminate\Http\Response
	*/
	public function messages_filter(Request $request)
	{
		$messages_data = array();
		$messages = CorrespondenceMessage::select("*")->where('deleted_at', null)->where('company_id', Auth::user()->company_id);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$messages->where('name', 'like', '%' . $request->get('search')['value'] . '%');
		}

		if($request->input('directions'))
        {
            $is_filter = true;
            $messages->where('direction',$request->input('directions'));
        }

        if($request->input('contacts'))
        {
            $is_filter = true;
            if($request->input('directions') == 'IN')
            {
                $messages->where('msg_from_id',$request->input('contacts'));
            }else if($request->input('directions') == 'OUT')
            {
                $messages->where('msg_to_id',$request->input('contacts'));
            }

        }

        if($request->input('msg_from'))
        {
            $is_filter = true;
            $messages->where('msg_from_id',$request->input('msg_from'));
        }

        if($request->input('msg_to'))
        {
            $is_filter = true;
            $messages->where('msg_to_id',$request->input('msg_to'));
        }

        if($request->input('msg_start_date'))
        {
            $is_filter = true;
            $messages->where('msg_date' , '>=', date('Y-m-d H:i:s',strtotime($request->input('msg_start_date'))));
        }

        if($request->input('msg_end_date'))
        {
            $is_filter = true;
            $messages->where('msg_date' , '<=', date('Y-m-d H:i:s',strtotime($request->input('msg_end_date'))));
        }

        if($request->input('topics'))
        {
            $is_filter = true;
            //get letter ids first
            $letter_ids = TopicTaskRelationship::where('type',0)->where('listing_id' , '>' , 0)
                ->where('company_id',Auth::user()->company_id)
                ->whereIn('topic_id',explode(',',$request->input('topics')))->pluck('listing_id')->all();
            $messages->whereIn('id', $letter_ids);
        }

		// if (!Auth::user()->hasRole('itfpobadmin')) {
		// 	$messages->where('company_id', Auth::user()->company_id);
		// 	$is_filter = true;
		// }

		if($is_filter) {
			$total_messages = count($messages->get());
			$messages = $messages->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
			$messages = CorrespondenceMessage::all();
			$total_messages = count($messages);

			if (Auth::user()->hasRole('itfpobadmin')) {
				$messages = CorrespondenceMessage::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
			}
			else {
				$messages = CorrespondenceMessage::where('deleted_at', null)->where('company_id', Auth::user()->company_id)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
			}
		}

		$count = 0;
		foreach ($messages as $message) {
			// get topics
			$topics = '';

			if ($message->topicRelationships) {
				foreach ($message->topicRelationships as $topic_relation) {
					$topics .= '#' . $topic_relation->topic->title . '<br>';
				}
			}

			$messages_data[$count][] = $message->id;
			$messages_data[$count][] = $message->reference_no ? $message->reference_no : '';
			$messages_data[$count][] = $message->to ? $message->to->getName() : '';
			$messages_data[$count][] = $message->from ? $message->from->getName() : '';
			$messages_data[$count][] = $message->subject;
			$messages_data[$count][] = $message->pob_status;
			$messages_data[$count][] = $topics;
			$messages_data[$count][] = '';//$message->attachment_files;
			$messages_data[$count][] = $message->msg_date ? date('Y-m-d H:i A', strtotime($message->msg_date)) : '';
			$messages_data[$count][] = $message->topicRelationships;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_messages,
			'recordsFiltered' => $total_messages,
			'data' 						=> $messages_data
		);
		return json_encode($data);
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create()
	{
        $company_id = Auth::user()->company_id;
        $contacts_from = User::where('company_id', $company_id)->get();
        $contacts_to = CorrespondenceAddress::where('company_id', $company_id)->get();
        $depts = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->get();
		return view('admin.pages.correspondence.create',
        compact('contacts_from','contacts_to','depts')
        );
	}

    public function create_for_received()
    {
        $company_id = Auth::user()->company_id;
        $contacts_from = User::where('company_id', $company_id)->get();
        $contacts_to = CorrespondenceAddress::where('company_id', $company_id)->get();
        $depts = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->get();
        return view('admin.pages.correspondence.create_for_received',
            compact('contacts_from','contacts_to','depts'));
	}

	/**
	* Detail page
	*
     * @param int $id
	* @return View
	*/
	public function detail($id = 0)
	{
		//$letter = CorrespondenceMessage::findOrFail($id);
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$letter = CorrespondenceMessage::findOrFail($id);
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();
		$tasks = Task::where('company_id', $company_id)->where('deleted_at', null)->get();
		$letter_topics_ids = $letter->topicRelationships->pluck('topic_id')->all();
//		$letter_tasks_ids = $letter->taskRelationships->pluck('task_id')->all();
        $letter_tasks_idss = $letter->taskRelationships->unique('task_id');
		$users = User::where('company_id', $company_id)->get();
        //print_r($letter_tasks_idss);exit();
		$activities = Activities::where('company_id', $company_id)->where('type','letters')->where('listing_id',$id)->get();
		$related_ids = TopicTaskRelationship::where('listing_id', '!=', $letter->id)->where('company_id', $company_id)->whereIn('topic_id', $letter_topics_ids)->pluck('listing_id')->all();
		$related = CorrespondenceMessage::where('deleted_at', null)
																		->whereIn('id', $related_ids)
																		->get();

		return view('admin.pages.correspondence.detail', compact(
			'letter',
			'topics',
			'tasks',
			'activities',
			'letter_topics_ids',
			'letter_tasks_idss',
			'users',
			'related'
		));
	}

	public function save_new_letter(Request $request)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
        $listing_id = 0;
        $message = '';
        $success = false;
        try {

            $validator = Validator::make($request->all(), [
                'msg_to_id'	=> 'required',
                'msg_from_id'	=> 'required',
                'reference_no'	=> 'required',
                //'assign_dept_id'	=> 'required',
                'subject'	=> 'required',
                //'reference_no'	=> 'required',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'success' => false,
                    'errors'=>$validator->getMessageBag()->toArray()
                ]);
            }


            /*save file*/
            $attachment_files = '';
            $attachment_files_name = '';
            if ($request->hasFile('attachment_files')) {
                $files = Arr::wrap($request->file('attachment_files'));
                $filesPath = [];
                $path = generatePath('correspondence');

                foreach ($files as $file) {
                    $filename = generateFileName($file, $path);
                    $file->storeAs(
                        $path,
                        $filename.'.'.$file->getClientOriginalExtension(),
                        config('app.storage.disk', 'public')

                    );

                    array_push($filesPath, [
                        'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
                        'original_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);

                    $attachment_files_name = $file->getClientOriginalName();
                }
                $attachment_files = json_encode($filesPath);
            }

            $original_files = '';
            $original_files_name = '';
            if ($request->hasFile('original_files')) {
                $files = Arr::wrap($request->file('original_files'));
                $filesPath = [];
                $path = generatePath('correspondence');

                foreach ($files as $file) {
                    $filename = generateFileName($file, $path);
                    $file->storeAs(
                        $path,
                        $filename.'.'.$file->getClientOriginalExtension(),
                        config('app.storage.disk', 'public')

                    );

                    array_push($filesPath, [
                        'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
                        'original_name' => $file->getClientOriginalName(),
                        'file_size' => $file->getSize(),
                    ]);

                    $original_files_name = $file->getClientOriginalName();
                }
                $original_files = json_encode($filesPath);
            }

            if($request->input('is_update')){
                $CorrespondenceMsg = CorrespondenceMessage::find($request->input('listing_id'));
            }else{
                $CorrespondenceMsg = new CorrespondenceMessage();
                $CorrespondenceMsg->created_at = date('Y-m-d H:i:s');
            }


            $CorrespondenceMsg->updated_at = date('Y-m-d H:i:s');
            //$CorrespondenceMsg->wfg_id = $request->input('wfg_id');
            $CorrespondenceMsg->msg_code = $request->input('msg_code')?$request->input('msg_code') : rand(11111,99999);
            $CorrespondenceMsg->reference_no = $request->input('reference_no');
            $CorrespondenceMsg->subject = $request->input('subject');
            $CorrespondenceMsg->ar_subject = $request->input('ar_subject');
            $CorrespondenceMsg->ar_reference_no = $request->input('ar_reference_no');
            $CorrespondenceMsg->direction = $request->input('direction');
            $CorrespondenceMsg->msg_date = $request->input('msg_date') ? date('Y-m-d',strtotime($request->input('msg_date'))) : date('Y-m-d H:i:s');
            $CorrespondenceMsg->details_date = $request->input('details_date');
            $CorrespondenceMsg->contents = $request->input('contents');
            $CorrespondenceMsg->ar_contents = $request->input('ar_contents');
            $CorrespondenceMsg->assign_dept_id = $request->input('assign_dept_id');
            $CorrespondenceMsg->attachment_file_name = $attachment_files_name;
            $CorrespondenceMsg->attachment_files = $attachment_files;
            $CorrespondenceMsg->orignal_file_name = $original_files_name;
            $CorrespondenceMsg->orignal_files = $original_files;
            $CorrespondenceMsg->msg_from_id = $request->input('msg_from_id');
            $CorrespondenceMsg->msg_to_id = $request->input('msg_to_id');
            $CorrespondenceMsg->created_by = Auth::user()->id;
            $CorrespondenceMsg->company_id = Auth::user()->company_id;
            $CorrespondenceMsg->status = $request->input('status')?$request->input('status'):0;
            $CorrespondenceMsg->pob_status = $request->input('pob_status')?$request->input('pob_status'):0;

            if($request->input('msg_parent_id'))
            {
                $CorrespondenceMsg->msg_parent_id = $request->input('msg_parent_id');
            }

            if ($CorrespondenceMsg->save()) {
                $listing_id = $CorrespondenceMsg->id;
                $success = true;
                $message = 'Address ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';

                //save history
                if($request->input('msg_parent_id')) // save parent id
                {
                    $listing_id = $request->input('msg_parent_id');
                }
                $activity = new Activities();
                $activity->listing_id = $listing_id;
                $activity->type = "letters";
                $activity->activity_title = $request->input('subject') ? $request->input('subject') : 'Letter Created';
                $activity->activity_details = $request->input('contents') ? $request->input('contents') : "Letter Created By - ".Auth::user()->name;
                $activity->action_type = 3;
                $activity->created_by = Auth::user()->id;
                $activity->company_id = Auth::user()->company_id;
                $activity->created_at = date('Y-m-d H:i:s');
                $activity->save();
            }



        }catch (\Exception $e) {
            $message =  $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'listing_id' => $listing_id,
            'message' => $message
        ]);
		}


	/**
	* Reply page
	*
	* @return View
	*/
    public function reply(Request $request)
	{
        $id = $request->input('id');
        $letter = CorrespondenceMessage::find($id);
        return view('admin.pages.correspondence.reply',compact('letter'));
	}

	/**
	* Receive page
	*
	* @return View
	*/
    public function receive(Request $request)
	{
        $id = $request->input('id');
        $letter = CorrespondenceMessage::find($id);
        return view('admin.pages.correspondence.receive',compact('letter'));
	}

}
