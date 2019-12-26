<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\DepartmentManagement;
use App\OrganizationManagement;
use App\Section;
use App\User;
use App\Division;

class SectionController extends Controller
{
    //
    /**
     *index page
     * return view
     */
    public function index()
    {
        return view('admin.pages.planning.section.list');
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
        $section_code = "S".date('ymdHis');
        $organizations = OrganizationManagement::all();
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'section_code'=>$section_code,
            'organizations'=>$organizations

        );
        return view('admin.pages.planning.section.create')->with('data', $data);
		}

		/**
		 * Detail page
		 *
		 * @return View
		 */
		public function detail($id)
		{
			$section = Section::findOrFail($id);

			return view('admin.pages.planning.section.detail', compact(
				'section'
			));
		}

		/**
		 * Update page
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function update($id)
		{
			$section = Section::findOrFail($id);
			$organizations = OrganizationManagement::all();
			$is_update = true;

			return view('admin.pages.planning.section.update', compact(
				'is_update',
				'section',
				'organizations'
			));
		}
		
		/**
		 * Delete section.
		 *
		 * @return \Illuminate\Http\Response
		 */
		public function delete($id, Request $request)
		{
			$section = Section::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($section) {
				$success = false;
				$msg = 'An error occured.';
				$section->deleted_at = date('Y-m-d H:i:s');

				if ($section->save()) {
						$success = true;
						$msg = 'Section deleted.';
				}

				return response()->json([
						'success' => $success,
						'section_id' => $section->id,
						'msg' => $msg,
						'type' => $type,
						'view' => $view,
						'return_url' => $request->input('view') == 'department_request' ? url('admin/department-requests') : url('admin/section-management')
				]);
			}
		}


    public function save_section(Request $request)
    {
        $user_id = Auth::user()->id;
        $listing_id = 0;
        try {

            $validator = Validator::make($request->all(), [
                'org_id'     => 'required',
                'short_name' => 'required',
                'section_code' => 'required',
                'dept_id' => 'required',
                'div_id'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $section = Section::find($request->input('listing_id'));
            }else{
                $section = new Section();
            }


            $section->org_id = $request->input('org_id');
            $section->div_id = $request->input('div_id');
            $section->dept_id = $request->input('dept_id');
            $section->section_code = $request->input('section_code');
            $section->short_name = $request->input('short_name');
            $section->full_name = $request->input('full_name');
            $section->is_active = 1;
            $section->created_by = $user_id;

            if(!$request->input('is_update')){
                $section->created_at = date('Y-m-d H:i:s');

            }
            $section->updated_at = date('Y-m-d H:i:s');

            if($section->save())
            {
                $listing_id = $section->id;
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
						'department_id' => $request->input('dept_id'),
						'message' => $message,
						'is_update' => $request->input('is_update'),
						'redirect' => $request->input('is_settings') || $request->input('is_update') ? url('admin/section-management/detail/' . $listing_id) : null
        ]);
    }


    public function section_filter(Request $request)
    {
        $sec_data = array();
        $sections = Section::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $sections->where('dept_code','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_sec = count($sections->get());
            $sections = $sections->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $sections = Section::all();
            $total_sec = count($sections);
            $sections = Section::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($sections as $section) {
            $sec_data[$count][] = $section->id;
            $sec_data[$count][] = $section->section_code;
            $sec_data[$count][] = $section->short_name;
            $sec_data[$count][] = $section->full_name;
            $sec_data[$count][] = $section->department->department_short_name;
            $sec_data[$count][] = $section->department->division->short_name;
            $sec_data[$count][] = $section->department->division->organization->org_title;
            $sec_data[$count][] = $section->createdBy ? $section->createdBy->getName() : '';
            $sec_data[$count][] = date("d M Y", strtotime($section->created_at));

            $sec_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_sec,
            'recordsFiltered' => $total_sec,
            'data' => $sec_data
        );
        return json_encode($data);
    }
}
