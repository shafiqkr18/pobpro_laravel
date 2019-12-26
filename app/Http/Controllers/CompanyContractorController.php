<?php

namespace App\Http\Controllers;

use App\CompanyContract;
use App\CompanyContractor;
use App\Imports\ImportContractorCollection;
use Illuminate\Http\Request;
use Auth;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;

use App\Exports\CompanyContractorsExport;
use File;

class CompanyContractorController extends Controller
{
  /**
	* Index page
	*
	* @return View
	*/
	public function index()
	{
		$contractors = CompanyContractor::where('company_id',Auth::user()->company_id)->whereNull('deleted_at')->get();
		return view('admin.pages.company_contracts.contractors.index',compact('contractors'));
	}

	/**
	* Create page
	*
	* @return View
	*/
	public function create()
	{
	    $ref_no = 'CNTR'.rand(00000,99999);
		return view('admin.pages.company_contracts.contractors.create',compact('ref_no'));
	}

	public function save_contractor(Request $request)
    {
        $user_id = Auth::user()->id;
        $contractor_id = 0;
        $message = '';
        $success = false;

        try {

            $validator = Validator::make($request->all(), [
                'reference_number'	=> 'required',
                'title'	=> 'required',
                'contact_person'	=> 'required',
                'email'=> 'email',

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
								$cContractor = CompanyContractor::find($request->input('contractor_id'));
								$cContractor->updated_at = date('Y-m-d H:i:s');
            }else{
								$cContractor = new CompanyContractor();
								$cContractor->created_at = date('Y-m-d H:i:s');
            }

            $cContractor->reference_number = $request->input('reference_number');
            $cContractor->title = $request->input('title');
            $cContractor->contact_person = $request->input('contact_person');
            $cContractor->email = $request->input('email');
            $cContractor->phone = $request->input('phone');
            $cContractor->fax = $request->input('fax');
            $cContractor->website = $request->input('website');
            $cContractor->city = $request->input('city');
            $cContractor->country = $request->input('country');
            $cContractor->address = $request->input('address');

            if ($my_files != '') {
							$cContractor->logo = $my_files;
            }

            $cContractor->created_by = $user_id;
            $cContractor->company_id = Auth::user()->company_id;

            if ($cContractor->save()) {
                $contractor_id = $cContractor->id;
                $success = true;
                $message = 'Contractor ' . ($request->input('is_update') ? 'updated' : 'submitted') . '.';
            }


        }catch (\Exception $e) {
            $message =  $e->getMessage();
        }

        return response()->json([
            'success' => $success,
            'contractor_id' => $contractor_id,
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
		$contractor = CompanyContractor::findOrFail($id);

		return view('admin.pages.company_contracts.contractors.update', compact(
			'contractor'
		));
	}

	/**
	* Detail page
	*
	* @return View
	*/
	public function detail($id)
	{
		$contractor = CompanyContractor::findOrFail($id);
		
		return view('admin.pages.company_contracts.contractors.detail', compact(
			'contractor'
		));
	}

	/**
	 * Delete contractor.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		$contractor = CompanyContractor::find($id);
		$type = $request->input('type');
		$view = $request->input('view');

		if ($contractor) {
			$success = false;
			$msg = 'An error occured.';
			$contractor->deleted_at = date('Y-m-d H:i:s');

			if ($contractor->save()) {
				$success = true;
				$msg = 'Contractor deleted.';
			}

			return response()->json([
				'success' => $success,
				'contractor_id' => $contractor->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/contracts-mgt/contractors')
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
		return view('admin.pages.company_contracts.contractors.import');
	}

	/**
	* Export to excel
	*
	* @return View
	*/
	public function exportExcel($id = 0)
	{
		return Excel::download(new CompanyContractorsExport($id), 'Company Contractors.xlsx');
	}
	
	public function import_excel(Request $request)
    {
        $success = false;
        $message = "File not selected";
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                Excel::import(new ImportContractorCollection(), request()->file('file'));
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

}
