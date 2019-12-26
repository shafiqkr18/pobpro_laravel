<?php

namespace App\Http\Controllers;

use App\Company;
use App\ExDepartment;
use App\ExPosition;
use File;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

use App\Candidate;
use App\ContractManagement;
use App\PositionManagement;
use App\User;
use App\JobStatusDetail;
use App\Interview;
use App\Plan;
use App\PlanPosition;
use App\WorkType;
use App\CandidateAge;
use App\EducationLevel;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\ImportCandidateCollection;
use DB;


class CandidateController extends Controller
{
    public function __construct()
    {
        //to stop direct access
       // $this->middleware(['role_or_permission:itfpobadmin|HR|HRM']);
    }
	/**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{
		return view('admin.pages.hr.candidate.list');
	}

	public function applicants()
    {
        return view('admin.pages.hr.candidate.applicants_list');
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
		$cn_no = "C".date('ymdHis');
        $positions = PositionManagement::where('company_id',Auth::user()->company_id)->get();
		$ages = CandidateAge::all();
		$work_types = WorkType::all();
		$education_levels = EducationLevel::all();

		$data = array(
			'all_users' => $all_users,
			'user_id' =>$user_id,
			'cn_no'=>$cn_no,
			'positions'=>$positions,
			'all_companies' => Company::where('deleted_at',null)->get(),
			'ages' => $ages,
			'work_types' => $work_types,
			'education_levels' => $education_levels,
		);
		return view('admin.pages.hr.candidate.create')->with('data', $data);
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id, $modal = 0)
	{
		$candidate = Candidate::findOrFail($id);
		$modal_size = 'modal-lg';
		$hide_header = 0;

		return view('admin.pages.hr.candidate.detail', compact(
			'candidate',
			'modal',
			'modal_size',
			'hide_header'
		));
	}

	/**
	 * Delete candidate.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
			$candidate = Candidate::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($candidate) {
					$success = false;
					$msg = 'An error occured.';
					$candidate->deleted_at = date('Y-m-d H:i:s');

					if ($candidate->save()) {
							$success = true;
							$msg = 'Candidate deleted.';
					}

					return response()->json([
							'success' => $success,
							'candidate_id' => $candidate->id,
							'msg' => $msg,
							'type' => $type,
							'view' => $view,
							'return_url' => url('admin/candidates')
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
		$candidate = Candidate::findOrFail($id);
		$positions = PositionManagement::all();
		$all_companies = Company::where('deleted_at', null)->get();
		$ages = CandidateAge::all();
		$work_types = WorkType::all();
		$education_levels = EducationLevel::all();
		$is_update = true;

		return view('admin.pages.hr.candidate.update', compact(
			'is_update',
			'candidate',
			'positions',
			'all_companies',
			'ages',
			'work_types',
			'education_levels'
		));
	}


	public function save_candidate(Request $request)
	{
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
		$candidate_id = 0;

		try {

				$validator = Validator::make($request->all(), [
						'name'     => 'required',
						'email' =>  ['required', 'string', 'email', 'max:255'],
						'phone' => 'required',
						'position_id' => 'required',
						'badge_id' => 'required',
						//'age' => 'required'
				]);
				if ($validator->fails()) {
						return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
				}

				$user_id = Auth::user()->id;
				if($request->input('is_update')){
						$candidate = Candidate::find($request->input('listing_id'));
                $user_uuid = $candidate->user_uuid;
                if($candidate->company_id < 1)
                {
                    $candidate->company_id = $request->input('company_id') ? $request->input('company_id') : Auth::user()->company_id;
                }
				}else{
						$candidate = new Candidate();
                $user_uuid = (string) Str::uuid();
                $candidate->company_id = $request->input('company_id') ? $request->input('company_id') : Auth::user()->company_id;
                $candidate->old_position_id = $request->input('position_id');
				}
				/*save file*/
				$my_files = '';
				if ($request->hasFile('file')) {
						$files = Arr::wrap($request->file('file'));
						$filesPath = [];
						$path = generatePath('candidates');

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

				$candidate->reference_no = $request->input('reference_no');
				$candidate->user_uuid = $user_uuid;
				$candidate->created_by = $user_id;
				$candidate->name = $request->input('name');
				$candidate->last_name = $request->input('last_name');
				$candidate->age = $request->input('age');
				$candidate->gender = $request->input('gender');
				$candidate->badge_id = $request->input('badge_id');
				$candidate->resume = $my_files;

				$candidate->phone = $request->input('phone');
				$candidate->skype = $request->input('skype');
				$candidate->other_contact = $request->input('other_contact');
				$candidate->email = $request->input('email');
				$candidate->position_id = $request->input('position_id');

				$candidate->nationality = $request->input('nationality');
				$candidate->location = $request->input('location');
				$candidate->other_benefits = $request->input('other_benefits');
            $candidate->fixed_salary = $request->input('fixed_salary');
            if($request->input('fixed_salary'))
            {
                $candidate->expected_salary = salaryToId($request->input('fixed_salary'));
            }


				$candidate->work_type = $request->input('work_type');
				$candidate->education_level = $request->input('education_level');
				$candidate->notes = $request->input('notes');
				$candidate->level = $request->input('level');



				if(!$request->input('is_update')){
						$candidate->created_at = date('Y-m-d H:i:s');

				}
				$candidate->updated_at = date('Y-m-d H:i:s');

            //save ex position & department


            //ex department
            $exdept = trim($request->input('ex_department'));
            $ex_dept_id = 0;
            if(!empty($exdept))
            {
                if(ExDepartment::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($exdept). '%')->where('company_id',$company_id)->exists())
                {
                    $exdept =  $expos = ExDepartment::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($exdept). '%')->where('company_id',$company_id)->first();
                    $ex_dept_id = $exdept->id;
                }else{
                    $newEx = new ExDepartment();
                    $newEx->title = $exdept;
                    $newEx->created_by = $user_id;
                    $newEx->company_id = $company_id;
                    $newEx->created_at = date('Y-m-d H:i:s');
                    if($newEx->save())
                    {
                        $ex_dept_id = $newEx->id;
                    }
                }
            }

            $old_position_id = 0;
            $position = PositionManagement::where('id', $request->input('position_id'))->where('company_id',$company_id)->first();
            if($position)
            {
                $p = $position->title;

                if(ExPosition::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($p). '%')->where('company_id',$company_id)->exists())
                {
                    $expos = ExPosition::where(DB::raw('LOWER(title)'), 'LIKE', '%' .strtolower($p). '%')->where('company_id',$company_id)->first();
                    $old_position_id = $expos->id;
                }else{
                    $expos = new ExPosition();
                    $expos->title = $p;
                    $expos->created_by = $user_id;
                    $expos->company_id = $company_id;
                    $expos->dept_id = $ex_dept_id;
                    $expos->created_at = date('Y-m-d H:i:s');
                    if($expos->save())
                    {
                        $old_position_id = $expos->id;
                    }

                }
            }
            $candidate->old_position_id = $old_position_id;



            $candidate->ex_dept_id =$ex_dept_id;


				if($candidate->save())
				{
						$candidate_id = $candidate->id;
						$message = "Saved Successfully! ";
						$status = true;
                //save into user table
                if (User::where('email', '=', $request->input('email'))->exists()) {
                    // user found
                    $userEx = User::where('email', '=', $request->input('email'))->first();
                    $user = User::find($userEx->id);
                    if($userEx->company_id < 1)
                    {
                        $user->company_id = Auth::user()->company_id;
                    }
                    if(empty($userEx->user_uuid))
                    {
                        $user->user_uuid = $user_uuid;
                    }

                }else{
                    $user = new User();
                    $user->company_id = Auth::user()->company_id;
                    $user->user_uuid = $user_uuid;
                    $user->password = Hash::make('123456789');
                }

                $user->name = $candidate->name;
                $user->last_name = $candidate->name;
                $user->email = $candidate->last_name;
                $user->user_type = 2;

                if($user->save())
                {
                    $user->assignRole('Candidate');
                }
				}else{
						$message = "Error Occured!";
						$status = false;
				}

		} catch (\Exception $e) {

				$message =  $e->getMessage();
				$status = false;

		}

		return response()->json([
				'success' => $status,
				'candidate_id' => $candidate_id,
				'message' => $message,
				'is_update' => $request->input('is_update')
		]);



	}


    public function applicant_filter(Request $request)
    {
        $candidates_data = array();
        $candidates = Candidate::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $candidates->where('name','like', '%'.$request->get('search')['value'].'%');
        }

        $is_filter = true;
        $candidates->where('is_online',1);
        if($is_filter){
            $total_candidates = count($candidates->get());
            $candidates = $candidates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $candidates = Candidate::all();
            $total_candidates = count($candidates);
            $candidates = Candidate::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($candidates as $candidate) {
            $candidates_data[$count][] = $candidate->id;
            $candidates_data[$count][] = $candidate->reference_no;
            $candidates_data[$count][] = $candidate->name;
            $candidates_data[$count][] = $candidate->email;
            $candidates_data[$count][] = $candidate->phone;
            $candidates_data[$count][] = $candidate->nationality;
            $candidates_data[$count][] = $candidate->location;
            $candidates_data[$count][] = $candidate->gender;
            $candidates_data[$count][] = $candidate->educationLevel?$candidate->educationLevel->title:'';
            if($candidate->position)
            {
            $candidates_data[$count][] = $candidate->position->title;
            }else{
                $candidates_data[$count][] = '';
            }

            $candidates_data[$count][] = strtoupper($candidate->status);
            $candidates_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_candidates,
            'recordsFiltered' => $total_candidates,
            'data' => $candidates_data
        );
        return json_encode($data);
    }
    public function candidate_filter(Request $request)
    {
        $candidates_data = array();
        $candidates = Candidate::select("*")->where('deleted_at', null);
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $candidates->where('name','like', '%'.$request->get('search')['value'].'%');
        }
        if (!Auth::user()->hasRole('itfpobadmin')) {
            $candidates->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }
        if($is_filter){
            $total_candidates = count($candidates->get());
            $candidates = $candidates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $candidates = Candidate::all();
            $total_candidates = count($candidates);
            $candidates = Candidate::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($candidates as $candidate) {
            $candidates_data[$count][] = $candidate->id;
            $candidates_data[$count][] = $candidate->reference_no;
						$candidates_data[$count][] = $candidate->badge_id;
            $candidates_data[$count][] = $candidate->name." ".$candidate->last_name;
            $candidates_data[$count][] = $candidate->nationality;
            $candidates_data[$count][] = $candidate->location;
						$candidates_data[$count][] = $candidate->gender;
						$candidates_data[$count][] = $candidate->fixed_salary;
						$candidates_data[$count][] = $candidate->level;
            $candidates_data[$count][] = $candidate->educationLevel?$candidate->educationLevel->title:'';
            $candidates_data[$count][] = $candidate->position?$candidate->position->title:'';
            $candidates_data[$count][] = strtoupper($candidate->status);
            $candidates_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_candidates,
            'recordsFiltered' => $total_candidates,
            'data' => $candidates_data
        );
        return json_encode($data);
		}

	/**
	 * Add candidate to short list
	 *
	 * @return View
	 */
	public function short_list(Request $request, $id)
	{
		$candidate = Candidate::findOrFail($id);
		$success = false;
		$msg = '';

		if ($candidate) {

			try {
				$candidate->is_shortlisted = 1;
				$candidate->status = 'shortlisted';

				if ($candidate->save()) {
					$job_status_detail = new JobStatusDetail();
					$job_status_detail->type = 'candidate';
					$job_status_detail->candidate_id = $candidate->id;
					$job_status_detail->status = 'shortlisted';
					$job_status_detail->status_details = 'Candidate has been shortlisted.';
					$job_status_detail->status_datetime = date('Y-m-d H:i:s');
					$job_status_detail->created_by = Auth::user()->id;
					$job_status_detail->created_at = date('Y-m-d H:i:s');
					$job_status_detail->updated_at = date('Y-m-d H:i:s');

					if ($job_status_detail->save()) {
						$success = true;
						$msg = 'Candidate shortlisted.';
					}
				}
			}
			catch (\Exception $e) {
				$msg =  $e->getMessage();
			}


			return response()->json([
				'success' => $success,
				'msg' => $msg,
				'candidate' => $candidate
			]);
		}

		return view('admin.pages.hr.vacancy.list');
	}

	/**
	 * Shortlisted candidates page
	 *
	 * @return View
	 */
	public function shortlisted()
	{
		return view('admin.pages.hr.candidate.short-listed');
	}

    public function shortlisted_by_position($id = 0,$planid=0,Request $request)
    {
        $interviews_this_week = [];
			$plan = Plan::findOrFail($planid);
			$plan_position = PlanPosition::where('position_id', $id)->where('plan_id', $planid)->first();

            $company_id =  Auth::user()->company_id ? Auth::user()->company_id : 0;
        $day_of_week = date('N');
        $end_of_week = date('Y-m-d', strtotime('next Sunday'));

        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        if (Auth::user()->hasRole('itfpobadmin')) {
            $candidates = Candidate::where('deleted_at',null)->get();
            $interviews = Interview::where('position_id', $id)->where('is_qualified', 0)->orderBy('interview_date', 'ASC')->get();

            $interviews_today = Interview::where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', date('Y-m-d'))
																	->orderBy('interview_date', 'ASC')
																	->get();


            $interviews_tomorrow = Interview::where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', $tomorrow)
																->orderBy('interview_date', 'ASC')
																->get();

			if ($day_of_week != 6) {
                $interviews_this_week = Interview::where('position_id', $id)->where('is_qualified', 0)->whereBetween('interview_date', [$tomorrow, $end_of_week])
																				->orderBy('interview_date', 'ASC')
																				->get();
			}

			// $later_sunday = date('Y-m-d', strtotime('+1 week Sunday'));
            $interviews_later = Interview::where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', '>=', $end_of_week)
																			->orderBy('interview_date', 'ASC')
																			->limit(5)
																			->get();
        }else{
            $candidates = Candidate::where('deleted_at',null)->where('company_id', $company_id)->get();
            $interviews = Interview::where('company_id', $company_id)->where('position_id', $id)->where('is_qualified', 0)->orderBy('interview_date', 'ASC')->get();
            $interviews_today = Interview::where('company_id', $company_id)->where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', date('Y-m-d'))
                ->orderBy('interview_date', 'ASC')
                ->get();
            $interviews_tomorrow = Interview::where('company_id', $company_id)->where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', $tomorrow)
                ->orderBy('interview_date', 'ASC')
                ->get();

            if ($day_of_week != 6) {
                $interviews_this_week = Interview::where('company_id', $company_id)->where('position_id', $id)->where('is_qualified', 0)->whereBetween('interview_date', [$tomorrow, $end_of_week])
                    ->orderBy('interview_date', 'ASC')
                    ->get();
            }

            $interviews_later = Interview::where('company_id', $company_id)->where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', '>=', $end_of_week)
                ->orderBy('interview_date', 'ASC')
                ->limit(5)
                ->get();
        }

        if($id>0){
            $position = PositionManagement::where('id', $id)->first();
            //$candidates = Candidate::where('is_shortlisted','!=', 1)->where('status','!=', 'shortlisted')->get();

            $data = array(
                'position_id' => $id,
                'plan_id' =>$planid,
                'position'=>$position,
                'candidates'=>$candidates

            );
        }else{
            abort(404);
        }
        return view('admin.pages.hr.candidate.short-listed-position', compact(
					'data',
					'interviews',
					'interviews_today',
					'interviews_tomorrow',
					'interviews_this_week',
					'interviews_later',
					'plan',
					'plan_position'
				));
    }

    public function shortlisted_filter_by_position(Request $request)
    {

        $candidates_data = array();
        $candidates = Candidate::select("*");
       // $candidates->where('is_shortlisted', 1)->where('status', 'shortlisted');
        $candidates->where('is_shortlisted', 1);
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $candidates->where('name','like', '%'.$request->get('search')['value'].'%');
        }
        if (!Auth::user()->hasRole('itfpobadmin')) {
            $candidates->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }
        if($request->has('position_id') && $request->input('position_id') > 0){
            $candidates->where('position_id', $request->input('position_id'));
            $is_filter = true;
        }
        if($request->has('plan_id') && $request->input('plan_id') > 0){
            $candidates->where('plan_id', $request->input('plan_id'));
            $is_filter = true;
        }
        if($is_filter){
            $total_candidates = count($candidates->get());
            $candidates = $candidates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $candidates = Candidate::all();
            $total_candidates = count($candidates);
            $candidates = Candidate::where('deleted_at', null)
                ->where('is_shortlisted', 1)
                ->offset($start)
                ->limit($length)
                ->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($candidates as $candidate) {
            $candidates_data[$count][] = $candidate->id;
            $candidates_data[$count][] = $candidate->reference_no;
            $candidates_data[$count][] = $candidate->is_interviewed;
            $candidates_data[$count][] = $candidate->name." ".$candidate->last_name;
            $candidates_data[$count][] = $candidate->nationality;
            $candidates_data[$count][] = $candidate->gender;
             $candidates_data[$count][] = $candidate->age;
            $candidates_data[$count][] = $candidate->educationLevel?$candidate->educationLevel->title:'';
             $candidates_data[$count][] = $candidate->location;

            $candidates_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_candidates,
            'recordsFiltered' => $total_candidates,
            'data' => $candidates_data
        );
        return json_encode($data);
    }
	public function shortlisted_filter(Request $request)
    {
        $candidates_data = array();
				$candidates = Candidate::select("*");
				$candidates->where('is_shortlisted', 1)->where('status', 'shortlisted');
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $candidates->where('name','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_candidates = count($candidates->get());
            $candidates = $candidates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $candidates = Candidate::where('is_shortlisted', 1)->where('status', 'shortlisted')->get();
            $total_candidates = count($candidates);
						$candidates = Candidate::where('is_shortlisted', 1)
																		->where('status', 'shortlisted')
																		->where('deleted_at', null)
																		->offset($start)
																		->limit($length)
																		->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($candidates as $candidate) {
            $candidates_data[$count][] = $candidate->id;
            $candidates_data[$count][] = $candidate->reference_no;
            $candidates_data[$count][] = $candidate->name;
            $candidates_data[$count][] = $candidate->email;
            $candidates_data[$count][] = $candidate->phone;
            // $candidates_data[$count][] = $candidate->nationality;
            $candidates_data[$count][] = $candidate->location;
            $candidates_data[$count][] = $candidate->position->title;
            $candidates_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_candidates,
            'recordsFiltered' => $total_candidates,
            'data' => $candidates_data
        );
        return json_encode($data);
		}


		public function assignPersonTOList(Request $request)
        {
            $ids = $request->input('candidate_ids');
            $position_id = $request->input('po_id');
            $plan_id = $request->input('plan_id');
            $ids=explode(',',$ids);
            $success = false;
            $msg = '';
            foreach($ids as $id){
                $candidate = Candidate::findOrFail($id);
                if ($candidate)
                {
                    $candidate->is_shortlisted = 1;
                    $candidate->position_id = $position_id;
                    $candidate->plan_id = $plan_id;
                    $candidate->status = 'shortlisted';
                    if ($candidate->save()) {

                    }
                }

            }
            return [
                'success' => true,
                'msg' => __('done')
            ];
        }

    public function assignToQualified(Request $request)
    {
        $position_id = $request->input('position_id');
        $plan_id = $request->input('plan_id');
        $ids = $request->input('candidate_ids');
        $ids=explode(',',$ids);
        $success = false;
        $msg = '';
        foreach($ids as $id){
            $candidate = Candidate::findOrFail($id);
            if ($candidate)
            {
                $candidate->is_qualified = 1;
                $candidate->plan_id = $plan_id;
                $candidate->position_id = $position_id;
                $candidate->status = 'qualified';
                if ($candidate->save()) {

                }
            }

        }
        return [
            'success' => true,
            'msg' => __('done')
        ];
    }


    public function removePersonTOList(Request $request)
    {
        $ids = $request->input('ids');
        $ids=explode(',',$ids);
        foreach($ids as $id){
        $candidate = Candidate::findOrFail($id);
        if ($candidate)
        {
            $candidate->is_shortlisted = 0;
            $candidate->status = 'open';
            if ($candidate->save()) {

            }
        }

        }

        return [
            'success' => true,
            'msg' => __('done')
        ];
    }

	/**
	 * Import page
	 *
	 * @return View
	 */
	public function import()
	{
		return view('admin.pages.hr.candidate.import');
	}

	/*
	 * import contacts
	 *
	 * */
	public function import_candidate_xls(Request $request)
    {
        $success = false;
        $message = "File not selected";
        if($request->hasFile('file')){
            $extension = File::extension($request->file->getClientOriginalName());
            if ($extension == "xlsx" || $extension == "xls" || $extension == "csv") {
                Excel::import(new ImportCandidateCollection, request()->file('file'));
                $message = "Candidates Imported!";
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
	 * Onboarding list
	 *
	 * @return View
	 */
	public function onboarding()
	{
		if (Auth::user()->hasRole('itfpobadmin')) {
			$candidates = Candidate::where('offer_accepted', 1)
														->where('deleted_at', null)
														->get();
		}
		else {
			$candidates = Candidate::where('offer_accepted', 1)
														->where('company_id', Auth::user()->company_id)
														->where('deleted_at', null)
														->get();
		}

		return view('admin.pages.hr.onboarding.list', compact(
			'candidates'
		));
	}

}
