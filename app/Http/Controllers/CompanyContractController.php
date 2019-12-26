<?php

namespace App\Http\Controllers;

use App\Imports\ImportCandidateCollection;
use App\Imports\ImportContractCollection;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use File;

use App\CompanyContract;
use App\CompanyContractor;
use App\DepartmentManagement;
use App\Exports\CompanyContractsExport;

class CompanyContractController extends Controller
{
  /**
	* Index page
	*
	* @return View
	*/
	public function index()
	{
		$contracts = CompanyContract::where('company_id',Auth::user()->company_id)->where('status',1)->whereNull('deleted_at')->get();
		return view('admin.pages.company_contracts.contracts.index',compact('contracts'));
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create()
	{
		$company_id = Auth::user()->company_id;
		$departments = DepartmentManagement::where('deleted_at', null)
				->whereHas('organization', function (Builder $query) use ($company_id) {
						$query->where('company_id', $company_id);
				})
				->get();
		$contractors = CompanyContractor::where('company_id',$company_id)->whereNull('deleted_at')->get();
		return view('admin.pages.company_contracts.contracts.create',compact('departments','contractors'));
	}

    public function save_contract(Request $request)
    {
        $user_id = Auth::user()->id;
        $contract_id = 0;
        $message = '';
        $success = false;

        try {

            $validator = Validator::make($request->all(), [
                'tender_reference'	=> 'required',
                'tender_title'	=> 'required',
                'contractor_id'	=> 'required',
                'start_date'=> 'required',
                'end_date'=> 'required',
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
								$cContract = CompanyContract::find($request->input('contract_id'));
								$cContract->updated_at = date('Y-m-d H:i:s');
            }else{
								$cContract = new CompanyContract();
								$cContract->created_at = date('Y-m-d H:i:s');
            }

            $cContract->tender_reference = $request->input('tender_reference');
            $cContract->tender_title = $request->input('tender_title');
            $cContract->contractor_id = $request->input('contractor_id');
            $cContract->department_id = $request->input('department_id');
            $cContract->amount = $request->input('amount');
            $cContract->currency = $request->input('currency');
            $cContract->location = $request->input('location');
            $cContract->primary_term = $request->input('primary_term');
            $cContract->notes = $request->input('notes');
            $cContract->start_date = db_date_format($request->input('start_date'));
						$cContract->end_date = db_date_format($request->input('end_date'));
						
						if ($my_files != '') {
							$cContract->attachments = $my_files;
						}
            

            $cContract->created_by = $user_id;
            $cContract->company_id = Auth::user()->company_id;

            if ($cContract->save()) {
                $contract_id = $cContract->id;
                $success = true;
                $message = 'Contract ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';
            }


        }catch (\Exception $e) {
            $message =  $e->getMessage();
        }

        return response()->json([
					'success' => $success,
					'contract_id' => $contract_id,
					'message' => $message,
					'is_update' => $request->input('is_update')
        ]);
	}

	/**
	* Update page
	*
	* @return View
	*/
	public function update($id)
	{
		$contract = CompanyContract::findOrFail($id);
		$company_id = Auth::user()->company_id;
		$departments = DepartmentManagement::where('deleted_at', null)
				->whereHas('organization', function (Builder $query) use ($company_id) {
						$query->where('company_id', $company_id);
				})
				->get();
		$contractors = CompanyContractor::where('company_id',$company_id)->whereNull('deleted_at')->get();

		return view('admin.pages.company_contracts.contracts.update', compact(
			'contract',
			'departments',
			'contractors'
		));
	}

	/**
	* Detail page
	*
	* @return View
	*/
	public function detail($id)
	{
		$contract = CompanyContract::findOrFail($id);
		
		return view('admin.pages.company_contracts.contracts.detail', compact(
			'contract'
		));
	}

	/**
	 * Delete division.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		$contract = CompanyContract::find($id);
		$type = $request->input('type');
		$view = $request->input('view');

		if ($contract) {
			$success = false;
			$msg = 'An error occured.';
			$contract->deleted_at = date('Y-m-d H:i:s');

			if ($contract->save()) {
				$success = true;
				$msg = 'Contract deleted.';
			}

			return response()->json([
				'success' => $success,
				'contract_id' => $contract->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/contracts-mgt/contracts')
			]);
		}
	}

	/**
	* Import page
	*
	* @return View
	*/
	public function import()
	{	
		return view('admin.pages.company_contracts.contracts.import');
	}

    public function import_excel(Request $request)
    {
        $success = false;
        $message = "File not selected";
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                Excel::import(new ImportContractCollection(), request()->file('file'));
                $message = "Contracts Imported!";
                $success = true;
            }else{
                $message = 'File is a '.$extension.' file.!! Please upload a valid xlsx file..!!';
            }
        }


        return response()->json([
            'success' => $success,
            'message' => $message
        ]);
    }

	/**
	* Export to excel
	*
	* @return View
	*/
	public function exportExcel($id = 0)
	{
		return Excel::download(new CompanyContractsExport($id), 'Company Contracts.xlsx');
	}

}
