<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;

use App\CompanyContractor;
use App\ContractorEmployee;

class ContractorEmployeeController extends Controller
{
  /**
	* List page
	*
	* @return View
	*/
	public function list($id = 0)
	{
		$contractor = $id ? CompanyContractor::findOrFail($id) : null;
		$employees = $id 
									? $contractor->employees 
									: ContractorEmployee::where('company_id',Auth::user()->company_id)->whereNull('deleted_at')->get();

		return view('admin.pages.company_contracts.contractor_employees.list', compact(
			'contractor',
			'employees'
		));
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create($id = 0)
	{
		$ref_no = 'CNTR_EMP' . rand(00000, 99999);
		$contractor = $id ? CompanyContractor::findOrFail($id) : null; 
		$contractors = CompanyContractor::where('company_id', Auth::user()->company_id)->whereNull('deleted_at')->get();

		return view('admin.pages.company_contracts.contractor_employees.create', compact(
			'ref_no',
			'contractor',
			'contractors'
		));
	}

	/**
	* Update page
	*
	* @return View
	*/
	public function update($id)
	{
		$employee = ContractorEmployee::findOrFail($id);
		$contractor = $employee->contractor ? $employee->contractor : null; 
		$contractors = CompanyContractor::where('company_id', Auth::user()->company_id)->whereNull('deleted_at')->get();

		return view('admin.pages.company_contracts.contractor_employees.update', compact(
			'employee',
			'contractor',
			'contractors'
		));
	}

	/**
	* Save employee
	*
	* @return \Illuminate\Http\Response
	*/
	public function save(Request $request)
	{
		$user_id = Auth::user()->id;
		$employee_id = 0;
		$message = '';
		$success = false;
		$contractor_id = 0;

		try {

			$validator = Validator::make($request->all(), [
				'first_name'	=> 'required',
				'last_name'	=> 'required',
				'email' =>  ['required', 'string', 'email', 'max:255'],
				'phone' => 'required',
				'contractor_id'	=> 'required',
				'position' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors' => $validator->getMessageBag()->toArray()
				]);
			}

			/*save file*/
			$my_files = '';
			if ($request->hasFile('file')) {
				$files = Arr::wrap($request->file('file'));
				$filesPath = [];
				$path = generatePath('contracts');

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
				$employee = ContractorEmployee::find($request->input('employee_id'));
				$employee->updated_at = date('Y-m-d H:i:s');
			}else{
				$employee = new ContractorEmployee();
				$employee->created_at = date('Y-m-d H:i:s');
			}

			$employee->employee_ref = $request->input('employee_ref');
			$employee->first_name = $request->input('first_name');
			$employee->last_name = $request->input('last_name');
			$employee->email = $request->input('email');
			$employee->phone = $request->input('phone');
			$employee->contractor_id = $request->input('contractor_id');
			$employee->position = $request->input('position');

			if ($my_files != '') {
				$employee->avatar = $my_files;
			}

			$employee->created_by = $user_id;
			$employee->company_id = Auth::user()->company_id;

			if ($employee->save()) {
				$employee_id = $employee->id;
				$contractor_id = $employee->contractor_id;
				$success = true;
				$message = 'Employee ' . ($request->input('is_update') ? 'updated' : 'saved') . '.';
			}
		} 
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'employee_id' => $employee_id,
			'contractor_id' => $contractor_id,
			'message' => $message,
			'is_update' => $request->input('is_update')
		]);
	}

	/**
	 * Delete employee.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		$employee = ContractorEmployee::find($id);
		$type = $request->input('type');
		$view = $request->input('view');

		if ($employee) {
			$success = false;
			$msg = 'An error occured.';
			$employee->deleted_at = date('Y-m-d H:i:s');

			if ($employee->save()) {
				$success = true;
				$msg = 'Employee deleted.';
			}

			return response()->json([
				'success' => $success,
				'contractor_employee_id' => $employee->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/contracts-mgt/contractor/employees/' . ($employee->contractor_id ? $employee->contractor_id : ''))
			]);
		}
	}

}
