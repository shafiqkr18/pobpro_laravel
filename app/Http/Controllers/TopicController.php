<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Task;
use App\Topic;
use App\TopicTaskRelationship;
use App\CorrespondenceMessage;

class TopicController extends Controller
{

	/**
	* List page
	*
	* @return View
	*/
	public function list()
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$topics = Topic::where('deleted_at', null);

		if (!Auth::user()->hasRole('itfpobadmin')) {
			$topics->where('company_id', $company_id);
		}

		$topics = $topics->get();

		return view('admin.pages.topics.list_new', compact(
			'topics'
		));
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create()
	{
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$tasks = Task::where('company_id', $company_id)->where('deleted_at', null)->get();

		return view('admin.pages.topics.create', compact(
			'tasks'
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
		$tasks = Task::where('company_id', $company_id)->where('deleted_at', null)->get();
		$topic = Topic::findOrFail($id);

		return view('admin.pages.topics.update', compact(
			'topic',
			'tasks'
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
		$tasks = Task::where('company_id', $company_id)->where('deleted_at', null)->get();
		$topic = Topic::findOrFail($id);

		return view('admin.pages.topics.detail_new', compact(
			'topic',
			'tasks'
		));
	}

  /**
	* Save topic
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
			$validator = Validator::make($request->all(), [
				'title'	=> 'required',
				// 'type'	=> 'required'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors' => $validator->getMessageBag()->toArray()
				]);
			}

			if ($request->input('is_update')) {
				$topic = Topic::findOrFail($request->input('listing_id'));
				$topic->updated_at = date('Y-m-d H:i:s');
			}
			else {
				$topic = new Topic();
				$topic->created_by = $user_id;
				$topic->created_at = date('Y-m-d H:i:s');
			}

			$topic->title = $request->input('title');
			$topic->type = $request->input('type');
			$topic->contents = $request->input('contents');
			$topic->company_id = $company_id;

			if ($topic->save()) {
				$success = true;
				$message = 'Topic ' . ($request->input('is_update') ? 'updated' : 'saved') . '.';

				if ($request->input('tasks')) {

					if ($request->input('is_update')) {
						$topic_tasks_ids = $topic->tasks->pluck('task_id')->all();

						foreach ($topic->tasks as $topic_task_relation) {
							// remove task relationship if not in task_ids input
							if (!in_array($topic_task_relation->task_id, $request->input('tasks'))) {
								$to_be_deleted = TopicTaskRelationship::find($topic_task_relation->id);
								$to_be_deleted->delete();
							}
						}

						foreach ($request->input('tasks') as $task_id) {
							// create new task relation if not found in existing relationship table
							if (!in_array($task_id, $topic_tasks_ids)) {
								$topic_task = new TopicTaskRelationship();
								$topic_task->topic_id = $topic->id;
								$topic_task->task_id = $task_id;
								$topic_task->listing_id = 0;
								// $topic_task->type = $topic->type;
								$topic_task->company_id = $company_id;
								$topic_task->created_by = $user_id;
								$topic_task->created_at = date('Y-m-d H:i:s');
								$topic_task->save();
							}
						}
					}
					else {
						foreach ($request->input('tasks') as $task) {
							$topic_task = new TopicTaskRelationship();
							$topic_task->topic_id = $topic->id;
							$topic_task->task_id = $task;
							$topic_task->listing_id = 0;
							// $topic_task->type = $topic->type;
							$topic_task->company_id = $company_id;
							$topic_task->created_by = $user_id;
							$topic_task->created_at = date('Y-m-d H:i:s');
							$topic_task->save();
						}
					}

				}
				else {
					if ($request->input('is_update')) {
						// remove all task relationships when no task_ids
						if ($topic->tasks) {
							foreach ($topic->tasks as $task) {
								$task->delete();
							}
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
			'topic' => $topic
		]);
	}

	/**
	 * Get topics.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function topics_filter(Request $request)
	{
		$topics_data = array();
		$topics = Topic::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$topics->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		$company_id = Auth::user()->company_id;
		if (!Auth::user()->hasRole('itfpobadmin'))
		{
			$topics->where('company_id', $company_id);
			$is_filter = true;
		}

		if($is_filter) {
			$topics->where('deleted_at', null);
			$total_topics = count($topics->get());
			$topics = $topics->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
			$topics = Topic::all();
			$total_topics = count($topics);
			$topics = Topic::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($topics as $topic) {
			$tasks = [];
			if ($topic->tasks) {
				foreach ($topic->tasks as $task) {
					array_push($tasks, $task->task);
				}
			}

			$topics_data[$count][] = $topic->title;
			$topics_data[$count][] = $tasks;
			$topics_data[$count][] = $topic->id;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_topics,
			'recordsFiltered' => $total_topics,
			'data' 						=> $topics_data
		);
		return json_encode($data);
	}

	/**
	 * Delete topic.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		if($id) {
			$type = $request->input('type');
			$view = $request->input('view');

			$topic = Topic::find($id);
			$topic->deleted_at = date('Y-m-d H:i:s');
			if ($topic->save()) {
				$success = true;
				$msg = 'Topic deleted.';
			}

			return response()->json([
				'success' => $success,
				'topic_id' => $topic->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/topics')
			]);
		}

	}

	/**
	* Assign topic
	*
	* @return View
	*/
	public function assign(Request $request)
	{
		$success = true;
		$message = '';
		$company_id = Auth::user()->company ? Auth::user()->company->id : 0;
		$letter = CorrespondenceMessage::find($request->input('listing_id'));

		try {
			$relationship_topic_ids = $letter->topicRelationships->pluck('topic_id')->all();

			if ($request->input('topic_ids')) {

				foreach ($letter->topicRelationships as $topic_relation) {
					// remove from relationship table if not in topic_ids input
					if (!in_array($topic_relation->topic_id, $request->input('topic_ids'))) {
						$to_be_deleted = TopicTaskRelationship::find($topic_relation->id);
						$to_be_deleted->delete();
					}
				}

				foreach ($request->input('topic_ids') as $topic_id) {
					// create new relation if not found in existing relationship table
					if (!in_array($topic_id, $relationship_topic_ids)) {
						$new_relationship = new TopicTaskRelationship();
						$new_relationship->listing_id = $letter->id;
						$new_relationship->topic_id = $topic_id;
						$new_relationship->type = $request->input('type');
						$new_relationship->company_id = $company_id;
						$new_relationship->created_by = Auth::user()->id;
						$new_relationship->created_at = date('Y-m-d H:i:s');
						$new_relationship->save();
					}
				}

				$message = 'Topics assigned.';
			}
			else {
				// remove all topic relationships when no topic_ids
				if ($letter->topicRelationships) {
					foreach ($letter->topicRelationships as $letter_topic) {
						$letter_topic->delete();
					}

					$message = 'Topics unassigned.';
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

}
