<?php

namespace App\Http\Controllers;

use App\DepartmentManagement;
use App\Division;
use App\OrganizationManagement;
use App\Section;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentManagementController extends Controller
{
    //
    /**
     *index page
     * return view
     */
    public function index()
    {
        return view('admin.pages.planning.department.list');
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
        $dept_code = "Dept-".date('YmdHis');
        $organizations = OrganizationManagement::all();
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'dept_code'=>$dept_code,
            'organizations'=>$organizations

        );
        return view('admin.pages.planning.department.create')->with('data', $data);
    }

		/**
		 * Detail page
		 *
		 * @return View
		 */
		public function detail($id)
		{
			$department = DepartmentManagement::findOrFail($id);
			$organizations = OrganizationManagement::all();

			return view('admin.pages.planning.department.detail', compact(
				'department',
				'organizations'
			));
		}

		/**
		 * Update page
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update($id)
		{
			$department = DepartmentManagement::findOrFail($id);
			$organizations = OrganizationManagement::all();
			$divisions = Division::all();
			$is_update = true;

			return view('admin.pages.planning.department.update', compact(
				'is_update',
				'department',
				'organizations',
				'divisions'
			));
		}
		
		/**
		 * Delete department.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function delete($id, Request $request)
		{
				$department = DepartmentManagement::find($id);
				$type = $request->input('type');
				$view = $request->input('view');

				if ($department) {
						$success = false;
						$msg = 'An error occured.';
						$department->deleted_at = date('Y-m-d H:i:s');

						if ($department->save()) {
								$success = true;
								$msg = 'Department deleted.';
						}

						return response()->json([
								'success' => $success,
								'department_id' => $department->id,
								'msg' => $msg,
								'type' => $type,
								'view' => $view,
								'return_url' => url('admin/department-management')
						]);
				}
		}


    public function save_department(Request $request)
    {
        $user_id = Auth::user()->id;
        $listing_id = 0;
        try {

            $validator = Validator::make($request->all(), [
                'org_id'     => 'required',
                'short_name' => 'required',
                'dept_code' => 'required',
                'div_id'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $department = DepartmentManagement::find($request->input('listing_id'));
            }else{
                $department = new DepartmentManagement();
            }


            $department->org_id = $request->input('org_id');
            $department->dept_code = $request->input('dept_code');
            $department->div_id = $request->input('div_id');
            $department->department_short_name = $request->input('short_name');
            $department->department_name = $request->input('full_name');
            $department->is_active = 1;
            $department->created_by = $user_id;

            if(!$request->input('is_update')){
                $department->created_at = date('Y-m-d H:i:s');

            }
            $department->updated_at = date('Y-m-d H:i:s');

            if($department->save())
            {
                $listing_id = $department->id;
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
						'redirect' => $request->input('is_settings') || $request->input('is_update') ? url('admin/department-management/detail/' . $listing_id) : null
        ]);
    }


    public function department_filter(Request $request)
    {
        $dept_data = array();
        $departments = DepartmentManagement::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $departments->where('dept_code','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_depts = count($departments->get());
            $departments = $departments->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $departments = DepartmentManagement::all();
            $total_depts = count($departments);
            $departments = DepartmentManagement::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($departments as $department) {
            $dept_data[$count][] = $department->id;
            $dept_data[$count][] = $department->dept_code;
            $dept_data[$count][] = $department->department_short_name;
            $dept_data[$count][] = $department->department_name;
            $dept_data[$count][] = $department->division->short_name;
            $dept_data[$count][] = $department->division->organization->org_title;
            $dept_data[$count][] = $department->createdBy->name;
            $dept_data[$count][] = date("d M Y", strtotime($department->created_at));

            $dept_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_depts,
            'recordsFiltered' => $total_depts,
            'data' => $dept_data
        );
        return json_encode($data);
    }


    public function department_section(Request $request)
    {
        $dept_id = $request->input('dept_id');
        $sec = Section::where('dept_id',$dept_id)->get();
        if($sec)
        {
            $sec = $sec;
        }else{
            $sec = null;
        }
        return  response()->json($sec);
    }

    public  function  getServiceData(Request $request)
    {
        //$request->session()->forget(['frmValues2', 'frmValues','frmValuesSingle']);

        if ($request->isMethod('post') && $request->ajax()) {
            $id = $request->input('dept_id');
            $type = $request->input('type') ? $request->input('type') : 0;
						$new_plan = $request->input('new_plan');
            if($type == 1)//this is division
            {
                $departments = DepartmentManagement::where('div_id',$id)->get();
            }else{
                $departments = DepartmentManagement::where('id',$id)->get();
            }
            //$sections = Section::where('dept_id', $id)->get();
            //$department = DepartmentManagement::where('id',$id)->first();


            //$returnHTML_list = view('admin.partials.services_list')->with(compact('sections', $sections,
                //'department',$department, 'new_plan'))->render();

            $returnHTML_list = view('admin.partials.services_list')->with(compact(
                'departments',$departments, 'new_plan'))->render();


            return response()->json(array('success' => true, 'list_data' => $returnHTML_list));
        }
		}
		
	/**
	 * Department reports page
	 *
	 * @return View
	 */
	public function reports()
	{
		return view('admin.pages.planning.department.reports');
	}

	/**
	 * Department reports new page
	 *
	 * @return View
	 */
	public function reportsNew()
	{
		return view('admin.pages.planning.department.reports-new');
	}

	/**
	 * Department reports Compose page
	 *
	 * @return View
	 */
	public function reportsCompose()
	{
		return view('admin.pages.planning.department.reports-compose');
	}

}
