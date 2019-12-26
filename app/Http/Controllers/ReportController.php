<?php

namespace App\Http\Controllers;

use App\DepartmentManagement;
use App\Remark;
use App\Report;
use App\Task;
use App\TaskHistory;
use App\TaskUser;
use App\TopicTaskRelationship;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use App\Topic;
use App\User;

class ReportController extends Controller
{
  /**
	* Index page
	*
	* @return View
	*/
	public function index(Request $request)
	{
        $company_id = Auth::user()->company_id;
        $department = Auth::user()->department ? Auth::user()->department : null;
        $departments = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
            $query->where('company_id', $company_id);
        })->skip(0)->take(8)->get();

        $type = $request->input('type');
        $type = empty($type) ? 0 : $type;

        $report_date = $request->input('rd');
        if($report_date)
        {
            $report_date = date('Y-m-d',strtotime($report_date));
            $reports = Report::where('company_id',Auth::user()->company_id)->where('report_type',$type)
                ->whereDate('created_at','=',$report_date)
                ->whereNull('deleted_at')->orderBy('created_at','DESC')->get();
        }else{
            //$report_date = date('Y-m-d');
            $reports = Report::where('company_id',Auth::user()->company_id)->where('report_type',$type)
                //->whereDate('created_at','=',$report_date)
                ->whereNull('deleted_at')->orderBy('created_at','DESC')->get();
        }
        $department_id = $department ? $department->id : 0;

	    $report_exists = false;

	    if(Report::where('dept_id',$department_id)->whereDate('created_at','=',date('Y-m-d'))->exists())
        {
            $report_exists = true;
        }

        $pending_tasks = $this->getPendingTasks();



		return view('admin.pages.report.index',
        compact(
            'reports','departments','report_exists','pending_tasks','type'
        ));
	}

	/**
	* Detail page
	*
     * @param int $id
	* @return View
	*/
	public function detail($id = 0)
	{
		$company_id = Auth::user()->company_id;
		$report = Report::findOrFail($id);

		$relationships = TopicTaskRelationship::where('type', 2)->where('listing_id', $report->id)->get();
		$arr_rshp = array();
		foreach ($relationships as $relationship) {
			if($relationship->task_id > 0) {
				array_push($arr_rshp, $relationship->task_id);
			}
		}

		$pending_tasks = Task::where('company_id', $company_id)
												->whereDate('created_at', '<', date('Y-m-d', strtotime($report->report_date)))
												->whereIn('id', $arr_rshp)
												->where('status',0)
												->get();

		return view('admin.pages.report.detail', compact(
			'report',
			'pending_tasks'
		));
	}


	public function getPendingTasks()
    {
        $company_id = Auth::user()->company_id;
        $department = Auth::user()->department ? Auth::user()->department : null;
        $department_id = $department ? $department->id : 0;

        $all_reports = Report::where('company_id',$company_id)->where('dept_id',$department_id)->get();

        $arr_rpt = array();
        foreach ($all_reports as $rpt)
        {
            array_push($arr_rpt,$rpt->id);
        }


        $relationships = TopicTaskRelationship::where('type',2)->whereIn('listing_id',$arr_rpt)->get();

        $arr_rshp = array();
        foreach ($relationships as $relationship)
        {
            if($relationship->task_id > 0)
            {
                array_push($arr_rshp,$relationship->task_id);
            }
        }


        return Task::where('company_id',$company_id)->whereDate('created_at','<',date('Y-m-d'))->whereIn('id',$arr_rshp)
            ->where('status',0)->get();
    }

	/**
	* Create page
	*
	* @return View
	*/
	public function create(Request $request)
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$department = Auth::user()->department ? Auth::user()->department : null;
		$users = Auth::user()->company ? Auth::user()->company->company_users : null;
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();

		//get all pending tasks
        $department_id = $department ? $department->id : 0;
        $all_reports = Report::where('company_id',$company_id)->where('dept_id',$department_id)->get();

        $arr_rpt = array();
        foreach ($all_reports as $rpt)
        {
            array_push($arr_rpt,$rpt->id);
        }


        $relationships = TopicTaskRelationship::where('type',2)->whereIn('listing_id',$arr_rpt)->get();

        $arr_rshp = array();
        foreach ($relationships as $relationship)
        {
            if($relationship->task_id > 0)
            {
                array_push($arr_rshp,$relationship->task_id);
            }
        }


         $pending_tasks = Task::where('company_id',$company_id)->whereDate('created_at','<',date('Y-m-d'))->whereIn('id',$arr_rshp)
            ->where('status',0)->get();


		return view('admin.pages.report.create', compact(
			'users',
			'topics',
			'department',
            'pending_tasks'
		));
	}

	/**
	* Add next task
	*
	* @return \Illuminate\Http\Response
	*/
	public function addNextTask(Request $request)
	{
		$task = [];
		$task['title'] = $request->input('title') ? $request->input('title') : '';
		$task['due_date'] = $request->input('due_date') ? $request->input('due_date') : '';
		$task['status'] = $request->input('status') ? $request->input('status') : '';
		$task['users'] = [];
		$task['contents'] = $request->input('contents') ? $request->input('contents') : '';

		if ($request->input('users')) {
			foreach ($request->input('users') as $user_id) {
				$user = User::findOrFail($user_id);
				$task['users'][] = $user;
			}
		}

		return response()->json([
			'request' => $request->all(),
			'view' => view('admin.pages.report._next_task', [
									'task' => $task
								])->render()
		]);
	}

	/**
	* Add remark
	*
	* @return \Illuminate\Http\Response
	*/
	public function addRemark(Request $request)
	{
		$remark = [];
		$remark['comments'] = $request->input('comments') ? $request->input('comments') : '';
		$remark['user'] = Auth::user();

		return response()->json([
			'request' => $request->all(),
			'view' => view('admin.pages.report._remark', [
									'remark' => $remark
								])->render()
		]);
	}


	public function save_report(Request $request)
    {


        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $listing_id = 0;
        $message = "Error Occurred!";
        $statusFinal = false;
        try {
            $validator = Validator::make($request->all(), [
                'title'	=> 'required',
               // 'title' 				=> 'required',
               // 'summary' 			=> 'required',
            ]);

            if ($validator->fails()) {
                return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
            }


            if ($request->input('is_update')) {
                $report = Report::find($request->input('listing_id'));
            }
            else {
                $report = new Report();
            }

            //
            //echo $request->input('type')."==".$request->input('next_actions');

            $report->title = $request->input('title');
            $report->report_type = $request->input('type');
            $report->dept_id = $request->input('dept_id');
            $report->contents = $request->input('report_details');
            $report->next_actions  = $request->input('next_actions');
            $report->report_date = date('Y-m-d H:i:s');
            $report->created_by = $user_id;
            $report->company_id = Auth::user()->company_id;

            if (!$request->input('is_update')){
                $report->created_at = date('Y-m-d H:i:s');
            }
            $report->updated_at = date('Y-m-d H:i:s');



            if ($report->save()) {
                $listing_id = $report->id;
                $message = 'Report ' . $request->input('is_update') ? 'updated.' : 'created.';
                $statusFinal = true;

                //update tasks
                $status = $request->input('status');
                $task_updates = $request->input('task_updates');
                if($request->input('p_task_id'))
                {
                    foreach ($request->input('p_task_id') as $key => $result) {
                        if (!empty($result)) {

                            if($status[$key] > 0)
                            {
                                Task::where('id', $result)->update(['status' => $status[$key]]);
                            }

                            if(!empty($task_updates[$key]))
                            {
                                $th = new TaskHistory();
                                $th->listing_id = $result;
                                $th->title = "Task Updated on Report";
                                $th->contents =  $task_updates[$key];
                                $th->type = 0;
                                $th->created_at = date('Y-m-d H:i:s');
                                $th->created_by = $user_id;
                                $th->company_id = Auth::user()->company_id;
                                $th->save();
                            }
                        }
                    }
                }


                //save remarks
//                $remark = new Remark();
//                $remark->listing_id = $listing_id;
//                $remark->title = "Remarks on Report";
//                $remark->comments =  $request->input('comments');
//                $remark->type = 2;
//                $remark->created_at = date('Y-m-d H:i:s');
//                $remark->created_by = $user_id;
//                $remark->company_id = Auth::user()->company_id;
//                $remark->save();

                //assign topics
                if ($request->input('topics')) {
                    foreach ($request->input('topics') as $topic) {
                        $task_topic = new TopicTaskRelationship();
                        //$task_topic->task_id = $task->id;
                        $task_topic->topic_id = $topic;
                        $task_topic->listing_id = $listing_id;
                        $task_topic->type = 2;
                        $task_topic->company_id = $company_id;
                        $task_topic->created_by = $user_id;
                        $task_topic->created_at = date('Y-m-d H:i:s');
                        $task_topic->save();
                    }
                }

                //save tasks

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
                            $task->type = 2;
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
                                $task_topic->type = 2;
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


            }
            else {
                $message = 'An error occurred.';
                $statusFinal = false;
            }




        }catch (\Exception $e) {
            $statusFinal = false;
            $message =  $e->getMessage();
        }

        return response()->json([
            'success' => $statusFinal,
            'contract_id' => $listing_id,
            'message' => $message,
            'is_update' => $request->input('is_update')
        ]);
    }

}
