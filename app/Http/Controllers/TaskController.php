<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Task;
use App\TaskUser;
use App\TopicTaskRelationship;
use App\CorrespondenceMessage;
use App\Topic;

class TaskController extends Controller
{

	/**
	* List page
	*
	* @return View
	*/
	public function list(Request $request)
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$tasks = Task::where('deleted_at', null);

		if (!Auth::user()->hasRole('itfpobadmin')) {
			$tasks->where('company_id', $company_id);
		}

		if ($request) {
			if ($request->input('search')) {
				$tasks->where('title', 'like', '%' . $request->input('search') . '%');
			}
		}

		$tasks = $tasks->get();

		if ($request->ajax()) {
			$list_view = '';
			foreach ($tasks as $task) {
				$list_view .= view('admin.pages.tasks._list', [
									'task' => $task
								])->render();
			}

			return response()->json([
				'tasks' => $tasks,
				'list_view' => $list_view
			]);
		}
		else {
			return view('admin.pages.tasks.list_new', compact(
				'tasks'
			));
		}

	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create()
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$users = Auth::user()->company ? Auth::user()->company->company_users : null;
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();

		return view('admin.pages.tasks.create', compact(
			'users',
			'topics'
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
		$task = Task::findOrFail($id);
		$users = Auth::user()->company ? Auth::user()->company->company_users : null;
		$task_users = $task->users->pluck('user_id')->all();
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();

		return view('admin.pages.tasks.update', compact(
			'task',
			'users',
			'task_users',
			'topics'
		));
	}

	/**
	* Detail page
	*
	* @return View
	*/
	public function detail($id)
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$task = Task::findOrFail($id);
		$topics = Topic::where('company_id', $company_id)->where('deleted_at', null)->get();

		return view('admin.pages.tasks.detail', compact(
			'task',
			'topics'
		));
	}

	/**
	* Save task
	*
	* @return View
	*/
	public function save(Request $request)
	{
		$user_id = Auth::user()->id;
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$success = false;
		$message = '';

		try {
			if (!$request->input('skip')) {
				$validator = Validator::make($request->all(), [
					'title'	=> 'required',
					// 'type'	=> 'required',
					// 'start_date'	=> 'required',
					'due_date'	=> 'required',
					'status'	=> 'required'
				]);

				if ($validator->fails()) {
					return response()->json([
						'success' => false,
						'errors' => $validator->getMessageBag()->toArray()
					]);
				}
			}

			if ($request->input('is_update')) {
				$task = Task::findOrFail($request->input('listing_id'));
				$task->updated_at = date('Y-m-d H:i:s');
			}
			else {
				$task = new Task();
				$task->created_by = $user_id;
				$task->created_at = date('Y-m-d H:i:s');
			}

			$task->title = $request->input('title');
			$task->type = $request->input('type');
			$task->status = $request->input('status');

			if ($request->input('start_date'))
				$task->start_date = date('Y-m-d', strtotime($request->input('start_date')));

			if ($request->input('due_date'))
				$task->due_date = date('Y-m-d', strtotime($request->input('due_date')));

			if ($request->input('contents'))
				$task->contents = $request->input('contents');

			$task->company_id = $company_id;

			if ($task->save()) {
				$success = true;
				$message = 'Task ' . ($request->input('is_update') ? 'updated' : 'saved') . '.';

				if ($request->input('is_update')) {
					// assign users
					if ($request->input('users')) {
						$task_user_ids = $task->users->pluck('user_id')->all();

						foreach ($task->users as $tu) {
							// remove task user if not in users input
							if (!in_array($tu->user_id, $request->input('users'))) {
								$to_be_deleted = TaskUser::find($tu->id);
								$to_be_deleted->delete();
							}
						}

						foreach ($request->input('users') as $user) {
							// add task user if not in existing task users table
							if (!in_array($user, $task_user_ids)) {
								$to_add = new TaskUser();
								$to_add->task_id = $task->id;
								$to_add->user_id = $user;
								$to_add->save();
							}
						}
					}
					else {
						// delete all task users when user input is empty
						foreach ($task->users as $tu) {
							$to_be_deleted = TaskUser::find($tu->id);
							$to_be_deleted->delete();
						}
					}

					// assign topics
					if ($request->input('topics')) {
						$task_topic_ids = $task->topics->pluck('topic_id')->all();

						foreach ($task->topics as $topic_task_relation) {
							// remove topic relationship if not in topic_ids input
							if (!in_array($topic_task_relation->topic_id, $request->input('topics'))) {
								$to_be_deleted = TopicTaskRelationship::find($topic_task_relation->id);
								$to_be_deleted->delete();
							}
						}

						foreach ($request->input('topics') as $topic_id) {
							// create new task relation if not found in existing relationship table
							if (!in_array($topic_id, $task_topic_ids)) {
								$task_topic = new TopicTaskRelationship();
								$task_topic->topic_id = $topic_id;
								$task_topic->task_id = $task->id;
								$task_topic->listing_id = 0;
								$task_topic->type = $task->type;
								$task_topic->company_id = $company_id;
								$task_topic->created_by = $user_id;
								$task_topic->created_at = date('Y-m-d H:i:s');
								$task_topic->save();
							}
						}
					}
					else {
						// remove all topic relationships when no topic_ids
						if ($task->topics) {
							foreach ($task->topics as $topic) {
								$topic->delete();
							}
						}
					}

				}
				else {
					if ($request->input('users')) {
						foreach ($request->input('users') as $user) {
							$task_user = new TaskUser();
							$task_user->task_id = $task->id;
							$task_user->user_id = $user;
							$task_user->save();
						}
					}

					if ($request->input('topics')) {
						foreach ($request->input('topics') as $topic) {
							$task_topic = new TopicTaskRelationship();
							$task_topic->task_id = $task->id;
							$task_topic->topic_id = $topic;
							$task_topic->listing_id = 0;
							$task_topic->type = $task->type;
							$task_topic->company_id = $company_id;
							$task_topic->created_by = $user_id;
							$task_topic->created_at = date('Y-m-d H:i:s');
							$task_topic->save();
						}
					}
				}


			}

		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'task' => $task
		]);
	}

	/**
	 * Get tasks.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function tasks_filter(Request $request)
	{
		$tasks_data = array();
		$tasks = Task::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$tasks->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		$company_id = Auth::user()->company_id;
		if (!Auth::user()->hasRole('itfpobadmin'))
		{
			$tasks->where('company_id', $company_id);
			$is_filter = true;
		}

		if($is_filter) {
			$tasks->where('deleted_at', null);
			$total_tasks = count($tasks->get());
			$tasks = $tasks->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
			$tasks = Task::all();
			$total_tasks = count($tasks);
			$tasks = Task::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($tasks as $task) {
			$tasks_data[$count][] = $task->title;
			// $tasks_data[$count][] = $task->contents;
			// $tasks_data[$count][] = $task->getType();
			$tasks_data[$count][] = $task->getStatus();
			// $tasks_data[$count][] = date('Y-m-d', strtotime($task->start_date));
			$tasks_data[$count][] = date('Y-m-d', strtotime($task->due_date));
			// $tasks_data[$count][] = $task->company ? $task->company->company_name : '';
			$tasks_data[$count][] = $task->id;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_tasks,
			'recordsFiltered' => $total_tasks,
			'data' 						=> $tasks_data
		);
		return json_encode($data);
	}

	/**
	 * Delete task.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		if($id) {
			$type = $request->input('type');
			$view = $request->input('view');

			$task = Task::find($id);
			$task->deleted_at = date('Y-m-d H:i:s');
			if ($task->save()) {
				$success = true;
				$msg = 'Task deleted.';

				if ($task->users) {
					foreach ($task->users as $task_user) {
						$to_be_deleted = TaskUser::find($task_user->id);
						$to_be_deleted->delete();
					}
				}
			}

			return response()->json([
				'success' => $success,
				'task_id' => $task->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/tasks')
			]);
		}

	}

	/**
	* Assign task
	*
	* @return View
	*/
	public function assign(Request $request)
	{
		$success = true;
		$message = '';
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
        $user_id = Auth::user()->id;
		$letter = CorrespondenceMessage::find($request->input('listing_id'));

		try {
		    //save task
            $task = new Task();
            $task->created_by = $user_id;
            $task->created_at = date('Y-m-d H:i:s');
            $task->title = $request->input('title');
            $task->type = $request->input('type');

            $task->status = $request->input('status');

            //if ($request->input('start_date'))
                $task->start_date = date('Y-m-d');

            if ($request->input('due_date'))
                $task->due_date = date('Y-m-d', strtotime($request->input('due_date')));

            if ($request->input('contents'))
                $task->contents = $request->input('contents');

            $task->company_id = $company_id;

            if ($task->save()) {
                $success = true;
                $message = 'Task ' . ($request->input('is_update') ? 'updated' : 'saved') . '.';


                if ($request->input('topics')) {
                    foreach ($request->input('topics') as $topic) {
                        $task_topic = new TopicTaskRelationship();
                        $task_topic->task_id = $task->id;
                        $task_topic->topic_id = $topic;
                        $task_topic->listing_id = $request->input('listing_id')? $request->input('listing_id'): 0;
                        $task_topic->type = $request->input('type');
                        $task_topic->company_id = $company_id;
                        $task_topic->created_by = $user_id;
                        $task_topic->created_at = date('Y-m-d H:i:s');
                        $task_topic->save();
					}
				}

                if ($request->input('users')) {
                    $users = explode(',',$request->input('users'));
                    foreach ($users as $user) {
                        $task_user = new TaskUser();
                        $task_user->task_id = $task->id;
                        $task_user->user_id = $user;
                        $task_user->save();
			}
					}

			}
		}
		catch (\Exception $e) {
			$success = false;
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message
		]);

	}

	/**
	 * Get task history.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function history(Request $request)
	{
		$task = Task::findOrFail($request->input('id'));
		$task_history = $task->history;

		return response()->json([
			'task' => $task,
			'view' => view('admin.pages.tasks._history', [
									'task_history' => $task_history
								])->render()
		]);
	}

}
