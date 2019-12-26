<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Budget;
use App\Company;

class BudgetController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.hr.budget.list');
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create()
	{
		$companies = Auth::user()->hasRole('itfpobadmin') 
								? Company::where('deleted_at', null)->get() 
								: Company::where('id', Auth::user()->company_id)->where('deleted_at', null)->get();

		return view('admin.pages.hr.budget.create', compact(
			'companies'
		));
	}

	/**
	 * Get budget list.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function budget_filter(Request $request)
	{
		$budgets_data = array();
		$budgets = Budget::select("*");
		if (!Auth::user()->hasRole('itfpobadmin')) {
			$budgets = $budgets->where('company_id', Auth::user()->company_id);
		}
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($request->has('pending') && $request->input('pending') > 0){
            $ur_role = $request->input('ur');
            $budgets->where('is_approved', 0);
            $is_filter = true;
        }
		if($search) {
			$is_filter = true;
			$budgets->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		if($is_filter) {
            $budgets->where('deleted_at', null);
			$total_budgets = count($budgets->get());
			$budgets = $budgets->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$budgets = Budget::all();
				if (!Auth::user()->hasRole('itfpobadmin')) {
					$budgets = $budgets->where('company_id', Auth::user()->company_id);
				}
				$total_budgets = count($budgets);
				if (Auth::user()->hasRole('itfpobadmin')) {
					$budgets = Budget::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
				}
				else {
					$budgets = Budget::where('company_id', Auth::user()->company_id)->where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
				}
		}

		$count = 0;
		foreach ($budgets as $budget) {
			$budgets_data[$count][] = $budget->id;
			$budgets_data[$count][] = $budget->title;
			$budgets_data[$count][] = '$ ' . $budget->budget_amount;
			$budgets_data[$count][] = $budget->createdBy ? $budget->createdBy->name : '';
			$budgets_data[$count][] = date('Y-m-d', strtotime($budget->created_at));
			$budgets_data[$count][] = '';
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_budgets,
			'recordsFiltered' => $total_budgets,
			'data' 						=> $budgets_data
		);
		return json_encode($data);
	}
	
	/**
	 * Save budget.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function save(Request $request)
	{
		$user_id = Auth::user()->id;
		$budget_id = 0;
		$message = '';
		$success = false;

		try {
			$validator = Validator::make($request->all(), [
				'title'					=> 'required',
				'budget_amount'	=> 'required'
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
				$budget = Budget::find($request->input('listing_id'));
			}
			else {
				$budget = new Budget();
			}

			$budget->title = $request->input('title');
			$budget->budget_amount = $request->input('budget_amount');
			$budget->remarks = $request->input('remarks');
			$budget->company_id = Auth::user()->hasRole('itfpobadmin') ? $request->input('company_id') : Auth::user()->company_id;
			$budget->created_by = $user_id;

			if ($my_files != '') {
				$budget->attachments = $my_files;
			}

			if (!$request->input('is_update')){
				$budget->created_at = date('Y-m-d H:i:s');
			}
			$budget->updated_at = date('Y-m-d H:i:s');

			if ($budget->save()) {
				$budget_id = $budget->id;
				$success = true;
				$message = 'Budget ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';
			}

		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}


		return response()->json([
			'success' => $success,
			'budget_id' => $budget_id,
			'message' => $message
		]);
	}

}
