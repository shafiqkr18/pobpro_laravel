<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Arr;

use App\Question;
use App\QuestionCategory;

class QuestionController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.hr.question.list');
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create()
	{
		$categories = QuestionCategory::all();

		return view('admin.pages.hr.question.create', compact(
			'categories'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$question = Question::findOrFail($id);

		return view('admin.pages.hr.question.detail', compact(
			'question'
		));
	}

	/**
	 * Update page
	 *
	 * @return View
	 */
	public function update($id)
	{
		$question = Question::findOrFail($id);
		$categories = QuestionCategory::all();

		return view('admin.pages.hr.question.update', compact(
			'question',
			'categories'
		));
	}

	/**
	 * Delete question.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		if ($id) {
			$type = $request->input('type');
			$view = $request->input('view');

			$question = Question::find($id);
			$question->deleted_at = date('Y-m-d H:i:s');
			if ($question->save()) {
				$success = true;
				$msg = 'Question deleted.';
			}

			return response()->json([
				'success' => $success,
				'question_id' => $question->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/questions')
			]);
		}

	}

	/**
	 * Get questions.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function questions_filter(Request $request)
	{
		$questions_data = array();
		$questions = Question::select("*");
		if (!Auth::user()->hasRole('itfpobadmin')) {
			$questions = $questions->where('company_id', Auth::user()->company_id);
		}
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$questions->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		if($is_filter) {
			$total_questions = count($questions->get());
			$questions = $questions->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$questions = Question::all();
				if (!Auth::user()->hasRole('itfpobadmin')) {
					$questions = $questions->where('company_id', Auth::user()->company_id);
				}
				$total_questions = count($questions);
				if (Auth::user()->hasRole('itfpobadmin')) {
					$questions = Question::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
				}
				else {
					$questions = Question::where('company_id', Auth::user()->company_id)->where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
				}
		}

		$count = 0;
		foreach ($questions as $question) {
			$questions_data[$count][] = '';
			$questions_data[$count][] = $question->id;
			$questions_data[$count][] = $question->title;
			$questions_data[$count][] = date('Y-m-d', strtotime($question->created_at));
			$questions_data[$count][] = $question->createdBy->name;
			$questions_data[$count][] = $question->status->status_name;
			$questions_data[$count][] = '';
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_questions,
			'recordsFiltered' => $total_questions,
			'data' 						=> $questions_data
		);
		return json_encode($data);
	}

	/**
	 * Save question.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function save(Request $request)
	{
		$user_id = Auth::user()->id;
		$question_id = 0;
		$message = '';
		$success = false;

		try {
			$validator = Validator::make($request->all(), [
				'title'				=> 'required',
				'category_id'	=> 'required',
				'content'			=> 'required'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors'=>$validator->getMessageBag()->toArray()
				]);
			}

			/*save file*/
			$my_files = '';
			if ($request->hasFile('file')) {
				$files = Arr::wrap($request->file('file'));
				$filesPath = [];
				$path = generatePath('questions');

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
				}

				$my_files = json_encode($filesPath);
			}

			if($request->input('is_update')){
				$question = Question::find($request->input('listing_id'));
			}
			else {
				$question = new Question();
			}

			$question->title = $request->input('title');
			$question->category_id = $request->input('category_id');
			$question->content = $request->input('content');
			$question->status_id = $request->input('status_id');
			$question->company_id = Auth::user()->company_id;
			$question->created_by = $user_id;
			$question->question_type = $request->input('question_type');

			if ($my_files != '') {
				$question->attachments = $my_files;
			}

			if (!$request->input('is_update')){
				$question->created_at = date('Y-m-d H:i:s');
			}
			$question->updated_at = date('Y-m-d H:i:s');

			if ($question->save()) {
				$question_id = $question->id;
				$success = true;
				$message = 'Question ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';
			}

		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}


		return response()->json([
			'success' => $success,
			'question_id' => $question_id,
			'message' => $message
		]);
	}


	public function save_question_answer(Request $request)
	{
		$user_id = Auth::user()->id;
		$answer_id = 0;
		$message = '';
		$success = false;

		try {
			$validator = Validator::make($request->all(), [
				'question_id'				=> 'required',
				//'category_id'	=> 'required',
				'content_answer'			=> 'required'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors'=>$validator->getMessageBag()->toArray()
				]);
			}

			$answer = new Answer();

			$answer->content = $request->input('content_answer');
			$answer->question_id = $request->input('question_id');
			$answer->remarks = $request->input('content_answer');
			$answer->answer_type = $request->input('question_type');
			$answer->created_by = $user_id;

			/*save file*/
			$my_files = '';
			if ($request->hasFile('file')) {
				$files = Arr::wrap($request->file('file'));
				$filesPath = [];
				$path = generatePath('questions');

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
				}

				$my_files = json_encode($filesPath);
			}

			if ($my_files != '') {
				$answer->attachments = $my_files;
			}

			$answer->created_at = date('Y-m-d H:i:s');
			$answer->updated_at = date('Y-m-d H:i:s');

			if ($answer->save()) {
				$answer_id = $answer->id;
				$success = true;
				$message = 'Answer ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';
				
				$question = Question::find($request->input('question_id'));
				$question->question_type = $request->input('question_type');
				$question->updated_at = date('Y-m-d H:i:s');
				$question->save();
			}

		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}


		return response()->json([
			'success' => $success,
			'question_id' => $request->input('question_id'),
			'message' => $message
		]);
	}

}
