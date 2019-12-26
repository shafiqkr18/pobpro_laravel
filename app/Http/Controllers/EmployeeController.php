<?php

namespace App\Http\Controllers;

use App\EducationLevel;
use App\PassportManagement;
use App\User;
use App\WorkType;
use Illuminate\Http\Request;

use App\Employee;
use App\PositionManagement;
use App\DepartmentManagement;
use App\Division;
use App\OrganizationManagement;
use App\Section;
use App\Candidate;

use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class EmployeeController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.hr.employee.list');
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create()
	{
		$positions = PositionManagement::all();
		$organizations = OrganizationManagement::all();
		$divisions = Division::all();
		$sections = Section::all();

		return view('admin.pages.hr.employee.create', compact(
			'positions',
			'organizations',
			'divisions',
			'sections'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$employee = Employee::findOrFail($id);

		return view('admin.pages.hr.employee.detail', compact(
			'employee'
		));
	}

	/**
	 * Get employees.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function employees_filter(Request $request)
	{
		$employees_data = array();
		$employees = Employee::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$employees->where('employee_name','like', '%'.$request->get('search')['value'].'%');
		}

        if (!Auth::user()->hasRole('itfpobadmin')) {
            $employees->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }

		if($is_filter) {
			$total_employees = count($employees->get());
			$employees = $employees->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$employees = Employee::all();
				$total_employees = count($employees);
				$employees = Employee::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($employees as $employee) {
			$employees_data[$count][] = $employee->id;
			$employees_data[$count][] = $employee->reference_no;
			$employees_data[$count][] = $employee->employee_name;
            $employees_data[$count][] = $employee->email;
            $employees_data[$count][] = $employee->mobile_number;
			$employees_data[$count][] = $employee->organization ? $employee->organization->org_title : '';
			$employees_data[$count][] = $employee->department ? $employee->department->department_short_name: '';
			$employees_data[$count][] = $employee->position ? $employee->position->title : '';
			$employees_data[$count][] = $employee->work_type;
            $employees_data[$count][] = date('Y-m-d', strtotime($employee->joining_date));
			$employees_data[$count][] = $employee->gender;
			$employees_data[$count][] = $employee->nationality;
			$employees_data[$count][] = $employee->passport_no;
            $employees_data[$count][] = '';
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_employees,
			'recordsFiltered' => $total_employees,
			'data' 						=> $employees_data
		);
		return json_encode($data);
	}

	/**
	 * Enrollment page
	 *
	 * @return View
	 */
	public function enrollment($candidate_id=0)
	{
        $candidate = Candidate::findOrFail($candidate_id);
		if(!($candidate))
        {
            abort(404);
        }

		if($candidate->is_enrolled == 1)
        {
            return redirect()
                ->route("offerlist")
                ->with([
                    'alert-message'    => "Candidate already enrolled!",
                    'alert-type' => 'warning',
                ]);
        }
        $user_full_name = $candidate->name;
		if(empty($user_full_name))
        {
            return redirect()
                ->route("offerlist")
                ->with([
                    'alert-message'    => "Candidate name is null",
                    'alert-type' => 'warning',
                ]);
        }

        $initial_user_name = employeeUserName($user_full_name,$candidate_id);
        if (User::where('user_name', '=', $initial_user_name)->where('company_id',Auth::user()->company_id)->exists()) {
            $initial_user_name = $initial_user_name.rand(1111,9999);
        }
        $company_email = Auth::user()->company->company_email;
        if (strpos($company_email, '@') !== false) {
            $company_email = explode('@', $company_email);
            $company_email_part = $company_email[1];
        }else{
            $company_email_part = 'example.com';
        }



        $initial_user_email = $initial_user_name."@".$company_email_part;


        $user_uuid = $candidate->user_uuid;
        if($user_uuid)
        {
            $user_uuid = $candidate->user_uuid;

        }else {
            $user_uuid = (string) Str::uuid();
        }






		return view('admin.pages.hr.employee.enrollment', compact(
			'candidate','user_uuid','initial_user_name','initial_user_email'

		));
	}

	public function getEnrollmentHtml(Request $request)
    {
        $candidate = $employee = '';
        if ($request->isMethod('post') && $request->ajax()) {
            $positions = PositionManagement::where('company_id',Auth::user()->company_id)->get();
            $organizations = OrganizationManagement::where('company_id',Auth::user()->company_id)->get();
            $candidate_id = $request->input('candidate_id');
            $type = $request->input('type');
            $type = $type ? $type : 1;
            $education_levels = EducationLevel::all();
            $work_types = WorkType::all();

            $candidate = Candidate::find($candidate_id);
            $returnHTML_list = '';
            if(!($candidate))
            {
                return response()->json(array('success' => false, 'list_data' => $returnHTML_list));
            }

            //if already exist in employee
            $user_uuid = $candidate->user_uuid;
            //$user  = User::where('user_uuid',$user_uuid)->first();

            //$candidate = Candidate::where('user_uuid', '=', $user_uuid)->first();
            $user_full_name = $candidate->name ? $candidate->name : 'POBPro';
                $is_employee = 0;


            $initial_user_name = employeeUserName($user_full_name,$candidate_id);
            $initial_user_email = $initial_user_name."@itforce-tech.com";
            $employee = '';


            if($type == 2)
            {
                $view = 'admin.partials.enrollment.hr';

            }elseif($type == 3)
            {
                $view = 'admin.partials.enrollment.it';
            }elseif($type == 4)
            {
                $view = 'admin.partials.enrollment.finish';
            }else{
                $view = 'admin.partials.enrollment.profile';
            }

            $returnHTML_list = view($view)->with(compact(
                'employee','education_levels','work_types',
                'user','candidate','is_employee','positions','organizations','initial_user_name','initial_user_email'
            ))->render();



            return response()->json(array('success' => true, 'list_data' => $returnHTML_list));
        }
    }

	public function save_employee(Request $request)
    {
        $user_id = Auth::user()->id;
        $employee_id = 0;
        $message = 'Record Saved.';
        $success = false;

        $max_id = Employee::max('id');
        $max_id = $max_id + 1;
        try {
            $validator = Validator::make($request->all(), [
                'employee_name'     => 'required',
                'email' => 'required',
                'mobile_number' => 'required',
                'position_id' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            /*save file*/
            $my_files = '';
            if ($request->hasFile('file')) {
                $files = Arr::wrap($request->file('file'));
                $filesPath = [];
                $path = generatePath('employees');

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
                $employee = Employee::find($request->input('listing_id'));
                $user_uuid = $employee->user_uuid;
                if(empty($user_uuid))
                {
                    $user_uuid = (string) Str::uuid();
                }
            }else{
                $employee = new Employee();
                $user_uuid = (string) Str::uuid();
                $employee->reference_no = 'E'.str_pad($max_id, 5, "0", STR_PAD_LEFT);
            }


            $employee->employee_name = $request->input('employee_name');
            $employee->created_by = $user_id;
            $employee->company_id = Auth::user()->company_id;
            $employee->email = $request->input('email');
            $employee->gender = $request->input('gender');
            $employee->age = $request->input('age');
            $employee->mobile_number = $request->input('mobile_number');
            $employee->phone_number = $request->input('phone_number');
            $employee->nationality = $request->input('nationality');
            $employee->passport_no = $request->input('passport_no');
            $employee->position_id = $request->input('position_id');
            $employee->org_id = $request->input('org_id');
            $employee->div_id = $request->input('div_id');
            $employee->sec_id = $request->input('sec_id');
            $employee->work_type = $request->input('work_type');
            $employee->education_level = $request->input('education_level');
            $employee->termination_date = db_date_format($request->input('termination_date'));
            $employee->agreement_start_date = db_date_format($request->input('agreement_start_date'));
            $employee->agreement_end_date = db_date_format($request->input('agreement_end_date'));
            $employee->joining_date = db_date_format($request->input('joining_date'));
            $employee->notes = $request->input('notes');
            $employee->avatar = $my_files;
            $employee->user_uuid = $user_uuid;

            if(!$request->input('is_update')){
                $employee->created_at = date('Y-m-d H:i:s');

            }
            $employee->updated_at = date('Y-m-d H:i:s');

            $email = $request->input('email');
            if($employee->save())
            {
                $employee_id = $employee->id;
                $message = "Saved Successfully! ";
                $success = true;
                //save user also
                if(!empty($email))
                {


                    if (User::where('email', '=', $email)->exists()) {
                        // user found
                        $user = User::where('email', '=', $email)->first();
                    }else{
                        $user = new User();
                    }

                    $user->name = $employee->employee_name;
                    $user->email = $employee->email;
                    $user->password = Hash::make('123456789');
                    $user->user_type = 3;//for employee
                    $user->user_uuid = $user_uuid;
                    $user->mobile_number = $employee->mobile_number;
                    $user->phone_number = $employee->phone_number;
                    $user->avatar = $employee->avatar;
                    $user->org_id = $employee->org_id;
                    $user->div_id = $employee->div_id;
                    $user->dept_id = $employee->dept_id;
                    $user->sec_id = $employee->sec_id;
                    $user->employee_id = $employee_id;
                    $user->save();
                }

            }else{
                $success = false;
                $message = "Error Occured!";
            }

        }catch (\Exception $e) {

            $message =  $e->getMessage();
            $success = false;

        }

        return response()->json([
            'success' => $success,
            'plan_id' => $employee_id,
            'message' =>$message
        ]);
    }

    public function save_enrollment(Request $request)
    {
        $user_id = Auth::user()->id;
        $employee_id = 0;
        $message = 'Record Saved.';
        $success = false;

        $max_id = Employee::max('id');
        $max_id = $max_id + 1;

        try {
//
            $validator = Validator::make($request->all(), [
                'user_uuid'     => 'required',
                'user_name' => 'required',
                'password' => 'required',
                'email' => 'required',
                'candidate_id' =>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }


            $user_uuid = $request->input('user_uuid');
            if($user_uuid)
            {
                $user_uuid = $request->input('user_uuid');

            }else{
                return response()->json([
                    'success' => $success,
                    'employee' => 0,
                    'message' =>"UUID does not exist!"
                ]);

            }

            //check if email already exists
            $email = $request->input('email');
            $user_name = $request->input('user_name');
            $candidate_id = $request->input('candidate_id');
            $candidate = Candidate::where('id', '=', $candidate_id)->first();


            if (Employee::where('user_uuid', '=', $user_uuid)->exists()) {
                $employee = Employee::where('user_uuid', '=', $user_uuid)->first();
                $employee = Employee::find($employee->id);

            }else{
                $employee = new Employee();
                $employee->reference_no = 'E'.str_pad($max_id, 5, "0", STR_PAD_LEFT);
                $employee->created_at = date('Y-m-d H:i:s');
            }



            $employee->created_by = $user_id;
            $employee->company_id = Auth::user()->company_id;
            $employee->employee_name = $candidate->name;
            $employee->employee_last_name = $candidate->last_name;
                $employee->email = $request->input('email');
                $employee->candidate_id = $request->input('candidate_id');
            $employee->plan_id =  $candidate->plan_id;
            $employee->gender = $candidate->gender;
            $employee->age = $candidate->age;
            $employee->mobile_number = $candidate->phone;
            $employee->nationality = $candidate->nationality;
            $employee->position_id  =   $candidate->position_id;
            $employee->org_id = Auth::user()->organization->id;
            $employee->div_id = $candidate->div_id;
            $employee->dept_id = $candidate->dept_id;
            $employee->sec_id = $candidate->section_id;
            $employee->badge_id = $candidate->badge_id;
            $employee->level = $candidate->level;
            $employee->user_uuid = $user_uuid;
            $employee->updated_at = date('Y-m-d H:i:s');



            //save employee
            if($employee->save())
            {
                $employee_id = $employee->id;
                $employee_email = $employee->email;
                    if(!empty($employee_email))
                    {


                        if (User::where('email', '=', $employee_email)->exists()) {
                            // user found
                            $userEx = User::where('email', '=', $employee_email)->first();
                            $user = User::find($userEx->id);
                            if($userEx->company_id < 1)
                            {
                                $user->company_id = Auth::user()->company_id;
                            }
                        $user_update = 1;
                        }else{
                            $user = new User();
                            $user->company_id = Auth::user()->company_id;
                        $user_update = 0;
                        }

                        $user->employee_id = $employee_id;

                        if($employee->employee_name)
                            $user->name = $employee->employee_name;

                        if($employee->employee_last_name)
                            $user->last_name = $employee->employee_last_name;

                        if($user_name)
                            $user->user_name = $user_name;

                        if($employee_email)
                            $user->email = $employee_email;

                        if($request->input('password'))
                        {
                            $user->password = Hash::make($request->input('password'));
                        }

                        $user->user_type = 3;//for employee

                        if($employee->user_uuid)
                            $user->user_uuid = $employee->user_uuid;

                        if($employee->mobile_number)
                            $user->mobile_number = $employee->mobile_number;

                        if($employee->phone_number)
                            $user->phone_number = $employee->phone_number;

                        if($employee->avatar)
                            $user->avatar = $employee->avatar;

                        if($employee->org_id)
                            $user->org_id = $employee->org_id;

                        if($employee->div_id)
                            $user->div_id = $employee->div_id;

                        if($employee->dept_id)
                            $user->dept_id = $employee->dept_id;

                        if($employee->sec_id)
                            $user->sec_id = $employee->sec_id;


                        $user->created_by = Auth::user()->id;
                    $user->created_at = date('Y-m-d H:i:s');
                    $user->updated_at = date('Y-m-d H:i:s');

                        if($user->save())
                        {
                        $new_user_id = $user->id;
                        //assign role to user
                        $user->assignRole('Employee');
                            //update candidate
                        if (Candidate::where('id', '=', $candidate_id)->exists()) {
                            $cand = Candidate::find($candidate_id);
                                $cand->is_enrolled = 1;
                                $cand->save();
                            }

                        //make entry in his passport
                        if($user_update == 0 )
                        {
                            $pp = new PassportManagement();
                            $pp->user_id = $new_user_id;
                            $pp->is_primary = 1;
                            $pp->created_by = Auth::user()->id;
                            $pp->created_at = date('Y-m-d H:i:s');
                            $pp->company_id = Auth::user()->company_id;
                            $pp->save();

                        }


                        //
                        }
                    }


                $message = "Saved Successfully! ";
                $success = true;


            }else{
                $success = false;
                $message = "Error Occurred!";
            }





        }catch (\Exception $e) {

            $message =  $e->getMessage();
            $success = false;

        }

        return response()->json([
            'success' => $success,
            'employee_id' => $employee_id,
            'message' =>$message
        ]);
    }
}
