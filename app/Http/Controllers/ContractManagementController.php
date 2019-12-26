<?php

namespace App\Http\Controllers;

use App\ContractManagement;
use App\StatusDetail;
use App\User;
use App\Offer;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class ContractManagementController extends Controller
{
    /**
	 * Index/List page
     *
     * @return View
     */
    public function index()
    {
        return view('admin.pages.planning.contract-management.list');
    }

    /**
	 * Create page
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $all_users = User::all();
        $user_id = Auth::user()->id;
        $cn_no = "CN-".date('YmdHis');
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'cn_no'=>$cn_no,

        );
        return view('admin.pages.planning.contract-management.create')->with('data', $data);
    }

    /**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$contract = Offer::findOrFail($id);
		$offer = Offer::findOrFail($id);
		$user = Auth::user();

		if (Auth::user()->hasRole('itfpobadmin')) {
            $my_role = 'itfpobadmin';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }elseif ((Auth::user()->hasRole('DM')) && ($contract->dm_approved != 1))
        {
            $my_role = 'DM';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }elseif ((Auth::user()->hasRole('HRM')) && ($contract->dm_approved == 1) && ($contract->hrm_approved != 1))
        {
            $my_role = 'HRM';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }elseif ((Auth::user()->hasRole('GM')) && ($contract->dm_approved == 1) && ($contract->hrm_approved == 1) && ($contract->gm_approved != 1))
        {
            $my_role = 'GM';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }else{
            $returnHTML = '';
        }

		return view('admin.pages.planning.contract-management.detail', compact(
			'contract',
			'user',
			'returnHTML'
		));
	}

    /**
     * Update page.
     *
     * @return \Illuminate\Http\Response
     */
    public function update($id = false, Request $request)
    {
        $all_users = User::all();
        if ($id) {
            $contract = ContractManagement::find($id);
            $data = array(
                'is_update' => true,
                'contract' => $contract,
                'all_users' => $all_users,
                );
        } else {
            abort(404);
        }

        return view('admin.pages.planning.contract-management.update')->with('data', $data);
    }

    /**
     * Delete contract.
     *
     * @return \Illuminate\Http\Response
     */
    public function delete($id, Request $request)
    {
				$contract = ContractManagement::find($id);
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
								'return_url' => url('admin/contract-management')
            ]);
        }
    }

    public function save_contract(Request $request)
    {

        try {

            $validator = Validator::make($request->all(), [
                'contract_date' => 'required',
                'contract_title' => 'required',
                'contract_refno' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }
            $contract_id = 0;
            if($request->input('is_update')){
                $contract = ContractManagement::find($request->input('listing_id'));
            }else{
                $contract = new ContractManagement();
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

            $contract->contract_refno = $request->input('contract_refno');
            $contract->created_by = $request->input('created_by');
            $contract->contract_title = $request->input('contract_title');
            $contract->contract_date = db_date_format($request->input('contract_date'));
            $contract->notes = $request->input('notes');
            $contract->attachment_file = $my_files;
            if(!$request->input('is_update')){
                $contract->created_at = date('Y-m-d H:i:s');

            }
            $contract->updated_at = date('Y-m-d H:i:s');

            if($contract->save())
            {
                $contract_id = $contract->id;
                $message = "Saved Successfully! ";
                return response()->json([
                    'success' => true,
                    'contract_id' => $contract_id,
                    'message' =>$message
                ]);
            }else{
                $message = "Error Occured!";
                return response()->json([
                    'success' => true,
                    'contract_id' => $contract_id,
                    'message' =>$message
                ]);
            }

        } catch (\Exception $e) {

            $message = $e->getMessage();
            return response()->json([
                'success' => false,
                'contract_id' => $contract_id,
                'message' =>$message
            ]);
        }



    }


    public function contracts_filter(Request $request)
    {
        $contract_data = array();
        $contracts = ContractManagement::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $contracts->where('contract_refno','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_contracts = count($contracts->get());
            $contracts = $contracts->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $contracts = ContractManagement::all();
            $total_contracts = count($contracts);
            $contracts = ContractManagement::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($contracts as $contract) {
            $contract_data[$count][] = $contract->id;
            $contract_data[$count][] = $contract->contract_refno;
            $contract_data[$count][] = $contract->contract_title;
            $contract_data[$count][] = $contract->createdBy->name;
            $contract_data[$count][] = $contract->contract_date;
            $contract_data[$count][] = $contract->notes;
            $contract_data[$count][] = '';
            ++$count;
        }

        $data = array(
            'draw' => $draw,
            'recordsTotal' => $total_contracts,
            'recordsFiltered' => $total_contracts,
            'data' => $contract_data,
        );

        return json_encode($data);
		}

	/**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		$pending = Input::get('pending', 0);
		$ur = Input::get('ur', 0);

		return view('admin.pages.planning.contract-management.list', compact(
			'pending',
			'ur'
		));
	}

    public function list_pending()
    {
        $pending = Input::get('pending', 0);
        $ur = Input::get('ur', 0);

        return view('admin.pages.planning.contract-management.list_pending', compact(
            'pending',
            'ur'
        ));
    }

	/**
	 * Get contracts.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function contract_list_filter(Request $request)
	{
		$contracts_data = array();
		$contracts = Offer::select("*");
		$contracts->where('type', 1);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;

        if($request->has('pending') && $request->input('pending') > 0){
            $ur_role = $request->input('ur');
            if($ur_role == 'DM')
            {
                $contracts->where('dm_approved', 0);
            }elseif ($ur_role == 'GM')
            {
                $contracts->where('gm_approved', 0);
            }else{
                $contracts->where('hrm_approved', 0);
            }

            $is_filter = true;
        }


		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$contracts->where('name','like', '%'.$request->get('search')['value'].'%');
		}

        if (!Auth::user()->hasRole('itfpobadmin')) {
            $contracts->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }

		if($is_filter) {
			$total_contracts = count($contracts->get());
			$contracts = $contracts->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$contracts = Offer::where('type', 1)->get();
				$total_contracts = count($contracts);
				$contracts = Offer::where('type', 1)->where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($contracts as $contract) {
			// get status
			$status = '';
			if ($contract->dm_approved == 1) {
				if ($contract->hrm_approved == 1) {
					if ($contract->gm_approved == 1) {
						$status = 'Approved';
					}elseif ($contract->gm_approved == 2)
                    {
                        $status = 'Rejected by GM';
					}
					else {
						$status = 'Pending for GM';
					}
				}elseif ($contract->hrm_approved == 2)
                {
                    $status = 'Rejected by HRM';
				}
				else {
					$status = 'Pending for HRM';
				}
			}elseif ($contract->dm_approved == 2)
            {
                $status = 'Rejected by DM';
			}
			else {
				$status = 'Pending for DM';
			}

			$contracts_data[$count][] = $contract->id;
			$contracts_data[$count][] = $status;
			$contracts_data[$count][] = $contract->sending_status;
			$contracts_data[$count][] = $contract->accepted;
			$contracts_data[$count][] = $contract->candidate ? $contract->candidate : '';
			$contracts_data[$count][] = $contract->candidate && $contract->candidate->position ? $contract->candidate->position->title : '';
			$contracts_data[$count][] = $contract->position ? $contract->position->title : '';
			$contracts_data[$count][] = $contract->offer_amount;
			$contracts_data[$count][] = $contract->candidate ? $contract->candidate->level : '';
			$contracts_data[$count][] = '';
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_contracts,
			'recordsFiltered' => $total_contracts,
			'data' 						=> $contracts_data
		);
		return json_encode($data);
	}

    public function contract_list_filter_pending(Request $request)
    {
        $contracts_data = array();
        $contracts = Offer::select("*");
        $contracts->where('type', 1)->where('deleted_at', null);
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;

        if($request->has('pending') && $request->input('pending') > 0){
            $ur_role = $request->input('ur');
            if($ur_role == 'DM')
            {
                $contracts->where('dm_approved', 0);
            }elseif ($ur_role == 'GM')
            {
                $contracts->where('gm_approved', 0);
            }elseif($ur_role == 'HRM'){
                $contracts->where('hrm_approved', 0);
						}
						else {
							$contracts->where(function ($query) {
								$query->where('gm_approved', 0)
											->orWhere('hrm_approved', 0)
											->orWhere('gm_approved', 0);
							});
						}

            $is_filter = true;
        }


        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

        if($search) {
            $is_filter = true;
            $contracts->where('name','like', '%'.$request->get('search')['value'].'%');
        }

        if (!Auth::user()->hasRole('itfpobadmin')) {
            $contracts->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }

        if($is_filter) {
            $total_contracts = count($contracts->get());
            $contracts = $contracts->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }
        else {
            $contracts = Offer::where('type', 1)->get();
            $total_contracts = count($contracts);
            $contracts = Offer::where('type', 1)->where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($contracts as $contract) {
          // get status
					$status = '';
					$dm = $hrm = $gm = 0;
					if ($contract->dm_approved == 1) {
                $dm = 1;
						if ($contract->hrm_approved == 1) {
                    $hrm = 1;
							if ($contract->gm_approved == 1) {
                        $gm = 1;
								$status = 'Approved';
                    }elseif ($contract->gm_approved == 2)
                    {
                        $status = 'Rejected by GM';
							}
							else {
								$status = 'Pending for GM';
							}
                }elseif ($contract->hrm_approved == 2)
                {
                    $status = 'Rejected by HRM';
						}
						else {
							$status = 'Pending for HRM';
						}
            }elseif ($contract->dm_approved == 2)
            {
                $status = 'Rejected by DM';
					}
					else {
						$status = 'Pending for DM';
					}

					$contracts_data[$count][] = $contract->id;
					$contracts_data[$count][] = $status;
					$contracts_data[$count][] = $contract->sending_status;
					$contracts_data[$count][] = $contract->accepted;
					$contracts_data[$count][] = $contract->candidate ? $contract->candidate : '';
					$contracts_data[$count][] = $contract->candidate && $contract->candidate->position ? $contract->candidate->position->title : '';
					$contracts_data[$count][] = $contract->position ? $contract->position->title : '';
					$contracts_data[$count][] = $contract->offer_amount;
					$contracts_data[$count][] = $contract->candidate ? $contract->candidate->level : '';
					$contracts_data[$count][] = '';
            $contracts_data[$count][] = $dm;
            $contracts_data[$count][] = $hrm;
            $contracts_data[$count][] = $gm;
					$count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_contracts,
            'recordsFiltered' => $total_contracts,
            'data' 						=> $contracts_data
        );
        return json_encode($data);
    }
	/**
	 * Save contract status.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function saveStatus(Request $request)
	{
		$user = Auth::user();
		$roles = $user->roles->pluck('name')->all();

		$message = '';
		$success = false;
		$contract_id = $request->input('contract_id');

		if(!empty($contract_id)) {
			$contract = Offer::find($contract_id);

			if (in_array('GM', $roles)) {
				$contract->gm_approved = $request->input('rdbtn');
                $approve_by_role = 'GM';
			}

			if (in_array('HRM', $roles)) {
				$contract->hrm_approved = $request->input('rdbtn');
                $approve_by_role = 'HRM';
			}

			if (in_array('DM', $roles)) {
				$contract->dm_approved = $request->input('rdbtn');
                $approve_by_role = 'DM';
			}

			if ($contract->save()) {
				$success = true;
				$message = 'Contract ' . ($request->input('rdbtn') == 1 ? 'approved' : 'rejected') . '.';

                //save in status table
                $status_detail = new StatusDetail();
                $m = $request->input('rdbtn') == 1 ? 'approved' : 'rejected';
                $status_detail->listing_id = $contract_id;
                $status_detail->type = 4; // for offer/contract status
                $status_detail->status_title = 'Contract(S) status changed';
                $status_detail->action_type = $request->input('rdbtn');
                $status_detail->status_details = $user->name." (".$approve_by_role.") ".$m." contract";
                $status_detail->created_by = $user->id;
                $status_detail->status_datetime = date('Y-m-d H:i:s');
                $status_detail->created_at = date('Y-m-d H:i:s');
                $status_detail->save();
			}
			else {
				$message = 'An error occurred.';
				$success = false;
			}
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'contract_ id' => $contract_id
		]);

	}

    public function saveXpleStatus(Request $request)
    {
        $user_id = Auth::user()->id;
        $message = 'Contract.';
        $success = false;
        $my_role = $request->input('my_role');
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',', $ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $id) {

                $offer = Offer::find($id);
                if ($offer->first()) {
                    if($my_role == 'DM')
                    {
                        $offer->dm_approved = 1;
                        $approve_by_role = 'DM';
                    }elseif($my_role == 'GM')
                    {
                        $offer->gm_approved = 1;
                        $approve_by_role = 'GM';
                    }else{
                        $offer->hrm_approved = 1;
                        $approve_by_role = 'HRM';
                    }
                    $offer->updated_at = date('Y-m-d H:i:s');
                    $offer->save();

                    //save in status table
                    $status_detail = new StatusDetail();
                    $status_detail->listing_id = $id;
                    $status_detail->type = 4; // for offer status
                    $status_detail->status_title = 'Contract(S) status changed';
                    $status_detail->action_type = 1;// as this is only approved function
                    $status_detail->status_details = Auth::user()->name." (".$approve_by_role.") approved contracts";
                    $status_detail->created_by = Auth::user()->id;
                    $status_detail->status_datetime = date('Y-m-d H:i:s');
                    $status_detail->created_at = date('Y-m-d H:i:s');
                    $status_detail->save();

                }
            }

            return redirect()
                ->route("employee_contracts_pending_list",['pending'=>1, 'ur'=>$my_role])
                ->with([
                    'alert-message'    => "Contract(s) Approved Successfully",
                    'alert-type' => 'success',
                ]);



        }
    }

}
