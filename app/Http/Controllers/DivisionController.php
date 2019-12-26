<?php

namespace App\Http\Controllers;

use App\Division;
use App\OrganizationManagement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

/**
 * Class DivisionController
 * @package App\Http\Controllers
 */
class DivisionController extends Controller
{
    //
    /**
     *index page
     * return view
     */
    public function index()
    {
        return view('admin.pages.planning.division.list');
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
        $division_code = "D".date('ymdHis');
        $organizations = OrganizationManagement::all();
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'division_code'=>$division_code,
            'organizations'=>$organizations

        );
        return view('admin.pages.planning.division.create')->with('data', $data);
    }

		/**
		 * Detail page
		 *
		 * @return View
		 */
		public function detail($id)
		{
			$division = Division::findOrFail($id);

			return view('admin.pages.planning.division.detail', compact(
				'division'
			));
		}

		/**
		 * Delete division.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function delete($id, Request $request)
		{
				$division = Division::find($id);
				$type = $request->input('type');
				$view = $request->input('view');

				if ($division) {
						$success = false;
						$msg = 'An error occured.';
						$division->deleted_at = date('Y-m-d H:i:s');

						if ($division->save()) {
								$success = true;
								$msg = 'Division deleted.';
						}

						return response()->json([
								'success' => $success,
								'division_id' => $division->id,
								'msg' => $msg,
								'type' => $type,
								'view' => $view,
								'return_url' => ($view == 'settings' ? url('admin/division-management') : url('admin/organization-plan'))
						]);
				}
		}

		/**
		 * Update page
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update($id)
		{
			$division = Division::findOrFail($id);
			$organizations = OrganizationManagement::all();
			$is_update = true;

			return view('admin.pages.planning.division.update', compact(
				'is_update',
				'division',
				'organizations'
			));
		}


    public function save_division(Request $request)
    {
        $user_id = Auth::user()->id;
        $listing_id = 0;
        try {

            $validator = Validator::make($request->all(), [
                'org_id'     => 'required',
                'short_name' => 'required',
                'division_code' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $division = Division::find($request->input('listing_id'));
            }else{
                $division = new Division();
            }


            $division->org_id = $request->input('org_id');
            $division->division_code = $request->input('division_code');
            $division->short_name = $request->input('short_name');
            $division->full_name = $request->input('full_name');
            $division->is_active = 1;
            $division->created_by = $user_id;

            if(!$request->input('is_update')){
                $division->created_at = date('Y-m-d H:i:s');

            }
            $division->updated_at = date('Y-m-d H:i:s');

            if($division->save())
            {
                $listing_id = $division->id;
                $message = "Saved Successfully! ";
                $status = true;

            }else{
                $message = "Error Occured!";
                $status = false;

            }

        } catch (\Exception $e) {
            $status = false;
            $message =  $e->getMessage();

        }

        return response()->json([
            'success' => $status,
            'contract_id' => $listing_id,
						'message' => $message,
						'is_update' => $request->input('is_update'),
						'redirect' => $request->input('is_settings') || $request->input('is_update') ? url('admin/division-management/detail/' . $listing_id) : null
        ]);
    }


    public function division_filter(Request $request)
    {
        $div_data = array();
        $divisions = Division::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $divisions->where('division_code','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_divisions = count($divisions->get());
            $divisions = $divisions->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $divisions = Division::all();
            $total_divisions = count($divisions);
            $divisions = Division::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($divisions as $division) {
            $div_data[$count][] = $division->id;
            $div_data[$count][] = $division->division_code;
            $div_data[$count][] = $division->short_name;
            $div_data[$count][] = $division->full_name;
            $div_data[$count][] = $division->organization->org_title;
            $div_data[$count][] = $division->createdBy ? $division->createdBy->getName() : '';
            $div_data[$count][] = date("d M Y", strtotime($division->created_at));

            $div_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_divisions,
            'recordsFiltered' => $total_divisions,
            'data' => $div_data
        );
        return json_encode($data);
    }



    public function division_department(Request $request)
    {
        $div_id = $request->input('div_id');
        $depts = Division::find($div_id);
        if($depts)
        {
        $depts = Division::find($div_id)->departments;
        return  response()->json($depts);
    }
        return '';

    }
}
