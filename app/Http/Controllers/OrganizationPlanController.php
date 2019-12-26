<?php

namespace App\Http\Controllers;

use App\DepartmentManagement;
use App\Division;
use App\OrganizationManagement;
use App\PositionManagement;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrganizationPlanController extends Controller
{
	/**
	* Index/List page
	*
	* @return View
	*/
	public function index()
	{

        $all_users = User::all();
        $user_id = Auth::user()->id;
        $company_id =  Auth::user()->company_id;
        if (!Auth::user()->hasRole('itfpobadmin')) {
            $org_id = 0;
            $organizations = OrganizationManagement::where('company_id',$company_id)->get();

            if (!$organizations->isEmpty()) {
            $org_id = OrganizationManagement::where('company_id',$company_id)->first()->id;
            }

            $divisions = Division::whereNull('deleted_at')->where('org_id',$org_id)->get();
            $single_dept = DepartmentManagement::where('org_id',$org_id)->first();
            $all_depts = DepartmentManagement::whereNull('deleted_at')->where('org_id',$org_id)->get();
            if ($single_dept) {
                $all_positions = PositionManagement::whereNull('deleted_at')->where('department_id', $single_dept->id)->get();
            }else{
                $all_positions = PositionManagement::whereNull('deleted_at')->get();
            }
        }else{
        $divisions = Division::whereNull('deleted_at')->get();
            $organizations = OrganizationManagement::all();
            $single_dept = DepartmentManagement::first();
            $all_depts = DepartmentManagement::all();
            $all_positions = PositionManagement::all();
        }

        $division_code = "D".date('ymdHis');

        $dept_code = "Dept-".date('ymdHis');
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
            'organizations'=>$organizations,
            'dept_code'=>$dept_code,
            'section_code'=>$section_code,
            'position_reference_no'=>$position_reference_no,
            'depts'=>$all_depts,
            'positions'=>$all_positions,


        );
		return view('admin.pages.management.organization-plan')->with('data', $data);
	}

}
