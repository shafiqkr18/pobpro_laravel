<?php

namespace App\Http\Controllers;

use App\Company;
use App\DepartmentManagement;
use App\Division;
use App\OrganizationTemplate;
use App\PositionManagement;
use App\ContractManagement;
use App\OrganizationManagement;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class OrganizationManagementController extends Controller
{
  /**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{

		return view('admin.pages.planning.organization-management.list');
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
        $org_no = "ORG".rand(1111,9999);
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'org_no'=>$org_no,

        );
		return view('admin.pages.planning.organization-management.new')->with('data', $data);
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$organization = OrganizationManagement::findOrFail($id);

		return view('admin.pages.planning.organization-management.detail', compact(
			'organization'
		));
	}

	/**
	 * My Organization page
	 *
	 * @return View
	 */
	public function myOrganization()
	{
		$user = Auth::user();
		$organization = $user->organization;

		$all_users = User::all();
		$user_id = Auth::user()->id;
		$company_id =  Auth::user()->company_id;

		$data = [];
		$divisions = null;

		if ($organization) {
			// $organizations = OrganizationManagement::where('company_id', $company_id)->get();
			$org_id = /*OrganizationManagement::where('company_id',$company_id)->first()->id*/$organization->id;
			$divisions = Division::whereNull('deleted_at')->where('org_id',$org_id)->get();
			$single_dept = DepartmentManagement::where('org_id',$org_id)->first();
			$all_depts = DepartmentManagement::whereNull('deleted_at')->where('org_id',$org_id)->get();
			// if ($single_dept) {
			// 	$all_positions = PositionManagement::whereNull('deleted_at')->where('department_id',$single_dept->id)->get();
			// }

			$division_code = "D".date('ymdHis');

			$dept_code = "Dept-".date('YmdHis');
			$section_code = "S".date('ymdHis');
			$max_id = PositionManagement::max('id');
			$max_id = $max_id + 1;
			$position_reference_no = "P".str_pad($max_id, 3, "0", STR_PAD_LEFT);
			$data = array(
				'all_users' => $all_users,
				'user_id' =>$user_id,
				'divisions'=>$divisions,
				'department'=>$single_dept,
				'division_code'=>$division_code,
				'organization' => $organization,
				'dept_code'=>$dept_code,
				'section_code'=>$section_code,
				'position_reference_no'=>$position_reference_no,
				'depts'=>$all_depts,
				// 'positions'=>$all_positions,
			);
		}
		// else {
		// 	$divisions = Division::whereNull('deleted_at')->get();
		// 	$organizations = OrganizationManagement::all();
		// 	$single_dept = DepartmentManagement::first();
		// 	$all_depts = DepartmentManagement::all();
		// 	$all_positions = PositionManagement::all();
		// }

		return view('admin.pages.planning.organization-management.my_organization', compact(
			'organization',
			'data',
			'company_id'
		));
	}

	/**
	 * Delete organization.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
			$organization = OrganizationManagement::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($organization) {
					$success = false;
					$msg = 'An error occured.';
					$organization->deleted_at = date('Y-m-d H:i:s');

					if ($organization->save()) {
							$success = true;
							$msg = 'Organization deleted.';
					}

					return response()->json([
							'success' => $success,
							'organization_id' => $organization->id,
							'msg' => $msg,
							'type' => $type,
							'view' => $view,
							'return_url' => url('admin/organization-management')
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
		$all_users = User::all();
		if ($id) {
				$organization = OrganizationManagement::find($id);
				$data = array(
						'is_update' => true,
						'organization' => $organization,
						'all_users' => $all_users
						);
		} else {
				abort(404);
		}

		return view('admin.pages.planning.organization-management.update')->with('data', $data);
	}

	public function save_organization(Request $request)
    {
        $user_id = Auth::user()->id;
        $org_id = 0;
        try {

            $validator = Validator::make($request->all(), [
                'org_refno'     => 'required',
                'org_title' => 'required',
               // 'org_parent' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $org = OrganizationManagement::find($request->input('listing_id'));
            }else{
                $org = new OrganizationManagement();
            }


            $org->org_refno = $request->input('org_refno');
            $org->created_by = $user_id;
            $org->company_id = Auth::user()->company_id;
            $org->org_title = $request->input('org_title');
            $org->org_parent = $request->input('org_parent');
            $org->notes = $request->input('notes');

            if(!$request->input('is_update')){
                $org->created_at = date('Y-m-d H:i:s');

            }
            $org->updated_at = date('Y-m-d H:i:s');

            if($org->save())
            {
                $org_id = $org->id;
								$message = "Saved Successfully! ";

								$user = Auth::user();
								$user->org_id = $org_id;
								$user->save();

                return response()->json([
                    'success' => true,
                    'contract_id' => $org_id,
                    'message' =>$message
                ]);
            }else{
                $message = "Error Occured!";
                return response()->json([
                    'success' => false,
                    'contract_id' => $org_id,
                    'message' =>$message
                ]);
            }

        } catch (\Exception $e) {

            $message =  $e->getMessage();
            return response()->json([
                'success' => false,
                'contract_id' => $org_id,
                'message' =>$message
            ]);
        }
    }


    public function organization_filter(Request $request)
    {
        $org_data = array();
        $organizations = OrganizationManagement::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $organizations->where('org_refno','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_organizations = count($organizations->get());
            $organizations = $organizations->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $organizations = OrganizationManagement::all();
            $total_organizations = count($organizations);
            $organizations = OrganizationManagement::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($organizations as $organization) {
            $org_data[$count][] = $organization->id;
            $org_data[$count][] = $organization->org_refno;
            $org_data[$count][] = $organization->org_title;
            $org_data[$count][] = $organization->org_parent;
            $org_data[$count][] = $organization->createdBy->name;
            $org_data[$count][] = $organization->created_at;
            $org_data[$count][] = $organization->notes;
            $org_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_organizations,
            'recordsFiltered' => $total_organizations,
            'data' => $org_data
        );
        return json_encode($data);
    }


    public function get_divisions(Request $request)
    {
        $org_id = $request->input('org_id');
        $divisions = OrganizationManagement::find($org_id)->divisions;
        return  response()->json($divisions);
		}

	/**
	 * Register organization page
	 *
	 * @return View
	 */
	public function register()
	{
		return view('admin.pages.planning.organization-management.register');
	}

	public function use_template(Request $request)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;

        $company_details = Company::where('id',$company_id)->first();
        if($company_details !== null)
        {
            $company_name = $company_details->company_name;
            try{
                //save organization
                $org = new OrganizationManagement();
                $org->org_refno = "ORG".rand(1111,9999);
                $org->created_by = $user_id;
                $org->company_id = $company_id;
                $org->org_title = $company_name;
                $org->org_parent = $company_name;
                $org->created_at = date('Y-m-d H:i:s');
                if($org->save())
                {
                    $org_id = $org->id;
                    //update user back
                    $user = User::find($user_id);
                    $user->org_id = $org_id;
                    $user->save();
                    //save division from template
                    $divisions = OrganizationTemplate::where('type','division')->where('parent_id',0)->get();
                    Log::info('get division query starts here');
                    Log::info(OrganizationTemplate::where('type','division')->where('parent_id',0)->toSql());
                    foreach ($divisions as $d)
                    {
                        $division = new Division();
                        $division->org_id = $org_id;
                        $division->division_code = "D".date('ymdHis');
                        $division->short_name = $d->short_name;
                        $division->full_name = $d->full_name;
                        $division->is_active = 1;
                        $division->created_by = $user_id;
                        $division->created_at = date('Y-m-d H:i:s');
                        if($division->save())
                        {
                            $division_id = $division->id;
                            // save department
                            Log::info('get department query starts here for div id ='.$d->id);
                            Log::info(OrganizationTemplate::where('type','department')->where('parent_id',$d->id)->toSql());
                            $departments = OrganizationTemplate::where('type','department')->where('parent_id',$d->id)->get();
                            foreach ($departments as $dept)
                            {
                                $department = new DepartmentManagement();
                                $department->org_id = $org_id;
                                $department->dept_code = "Dept-".date('ymdHis');
                                $department->div_id = $division_id;
                                $department->department_short_name = $dept->short_name;
                                $department->department_name = $dept->full_name;
                                $department->is_active = 1;
                                $department->created_by = $user_id;
                                $department->created_at = date('Y-m-d H:i:s');
                                if($department->save())
                                {
                                    $department_id = $department->id;
                                    //save section
                                    Log::info('get section query starts here for department_id = '.$dept->id);
                                    Log::info(OrganizationTemplate::where('type','section')->where('parent_id',$dept->id)->toSql());
                                    $sections = OrganizationTemplate::where('type','section')->where('parent_id',$dept->id)->get();
                                    foreach ($sections as $sec)
                                    {

                                        $section = new Section();
                                        $section->org_id = $org_id;
                                        $section->div_id = $division_id;
                                        $section->dept_id = $department_id;
                                        $section->section_code = "S".date('ymdHis');
                                        $section->short_name =  $sec->short_name;
                                        $section->full_name =  $sec->short_name;
                                        $section->is_active = 1;
                                        $section->created_by = $user_id;
                                        $section->created_at = date('Y-m-d H:i:s');
                                        if($section->save())
                                        {
                                            $section_id = $section->id;
                                        }else{
                                            Log::info('error while saving section');
                                        }
                                    }

                                }else{
                                    Log::info('error while saving department');
                                }
                            }
                        }
                    }

                    return redirect()
                        ->route("myorganization")
                        ->with([
                            'alert-message'    => "Organization template imported successfully!",
                            'alert-type' => 'success',
                        ]);

                }else{
                    return redirect()
                        ->route("myorganization")
                        ->with([
                            'alert-message'    => "Error! Try again later!",
                            'alert-type' => 'warning',
                        ]);
                }



            }catch (\Exception $e) {

                 return redirect()
                    ->route("myorganization")
                    ->with([
                        'alert-message'    => "Error! ".$e->getMessage(),
                        'alert-type' => 'warning',
                    ]);

            }

        }

    }
}
