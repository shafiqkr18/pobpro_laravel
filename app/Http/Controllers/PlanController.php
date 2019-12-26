<?php

namespace App\Http\Controllers;

use App\PlanPosition;
use App\Vacancy;
use Illuminate\Http\Request;

use App\Plan;
use App\User;
use App\Budget;
use App\Division;
use App\RotationType;
use App\RecruitmentType;
use App\PlanNationality;
use App\PositionManagement;
use App\DepartmentManagement;
use App\OrganizationManagement;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Session;

class PlanController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
        $pending = Input::get('pending', 0);
        $ur = Input::get('ur', 0);
		return view('admin.pages.hr.plan.list',compact(
            'pending','ur'
        ));
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create()
	{
		$positions = PositionManagement::all();

		return view('admin.pages.hr.plan.create', compact(
			'positions'
		));
	}

	/**
	 * Add positions page
	 *
	 * @return View
	 */
	public function addPosition()
	{
        $user = Auth::user();
        $company_id =  Auth::user()->company_id;
        if (Auth::user()->hasRole('itfpobadmin')) {
            $organizations = OrganizationManagement::all();
            $divisions = Division::whereNull('deleted_at')->get();
            $single_dept = DepartmentManagement::first();
            $all_depts = DepartmentManagement::whereNull('deleted_at')->get();
        }else{

            $organizations = OrganizationManagement::where('company_id', $company_id)->get();
            if(count($organizations)>0)
            {

                $org_id = OrganizationManagement::where('company_id',$company_id)->first()->id;
                $divisions = Division::whereNull('deleted_at')->where('org_id',$org_id)->get();
                $single_dept = DepartmentManagement::where('org_id',$org_id)->first();
                $all_depts = DepartmentManagement::whereNull('deleted_at')->where('org_id',$org_id)->get();
            }else{

                $organizations = collect(new OrganizationManagement);
                $divisions = collect(new Division);
                $single_dept =collect(new DepartmentManagement)->first();
                $all_depts = collect(new DepartmentManagement);
            }

        }
        //exit();
		$all_users = User::all();
		$user_id = Auth::user()->id;

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
			'organizations'=>$organizations,
			'dept_code'=>$dept_code,
			'section_code'=>$section_code,
			'position_reference_no'=>$position_reference_no,
			'depts'=>$all_depts,
			'positions'=>PositionManagement::all(),
		);

		return view('admin.pages.hr.plan.add_position')->with('data', $data);
	}

	/**
	 * Create new plan page (new flow)
	 *
	 * @return View
	 */
	public function new(Request $request)
	{
		// $positions = PositionManagement::all();
		$ids = explode(',', $request->input('ids'));
		$budgets = Budget::where('company_id',Auth::user()->company_id)->get();

		$positions = PositionManagement::whereIn('id', $ids)->get();
		$rotation_types = RotationType::all();
		$recruitment_types = RecruitmentType::all();
		$plan_nationalities = PlanNationality::all();

		return view('admin.pages.hr.plan.new', compact(
			'positions',
			'budgets',
			'rotation_types',
			'recruitment_types',
			'plan_nationalities'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$plan = Plan::findOrFail($id);
		$user = Auth::user();

		return view('admin.pages.hr.plan.detail', compact(
			'plan','user'
		));
	}

	/**
	 * Get plans.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function plans_filter(Request $request)
	{
		$plans_data = array();
		$plans = Plan::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($request->has('pending') && $request->input('pending') > 0){
            $ur_role = $request->input('ur');
            $plans->where('is_approved', 0);
            $is_filter = true;
        }
		if($search) {
			$is_filter = true;
			$plans->where('name','like', '%'.$request->get('search')['value'].'%');
		}

        $company_id = Auth::user()->company_id;
        if (!Auth::user()->hasRole('itfpobadmin'))
        {
            $plans->where('company_id', $company_id);
            $is_filter = true;
        }

		if($is_filter) {
            $plans->where('deleted_at', null);
			$total_plans = count($plans->get());
			$plans = $plans->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$plans = Plan::all();
				$total_plans = count($plans);
				$plans = Plan::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($plans as $plan) {
			$plans_data[$count][] = $plan->id;
			$plans_data[$count][] = $plan->subject;
			$plans_data[$count][] = $plan->budget;
			$plans_data[$count][] = $plan->details;
			$plans_data[$count][] = date('Y-m-d H:i:s', strtotime($plan->start_date));
			$plans_data[$count][] = date('Y-m-d H:i:s', strtotime($plan->end_date));
			$plans_data[$count][] = $plan->is_open;
            $plans_data[$count][] = "";
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_plans,
			'recordsFiltered' => $total_plans,
			'data' 						=> $plans_data
		);
		return json_encode($data);
	}


	/**
	 * Get plans for recruitment dashboard.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function recruitment_plans_filter(Request $request)
	{
		$plans_data = array();
		$plans = Plan::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$plans->where('subject','like', '%'.$request->get('search')['value'].'%');
		}
        $company_id = Auth::user()->company_id;
        if (!Auth::user()->hasRole('itfpobadmin'))
        {
            $plans->where('company_id', $company_id);
            $is_filter = true;
        }

		if($is_filter) {
			$total_plans = count($plans->get());
			$plans = $plans->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$plans = Plan::all();
				$total_plans = count($plans);
				$plans = Plan::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($plans as $plan) {
			$plans_data[$count][] = '';
			$plans_data[$count][] = array('subject' => $plan->subject, 'details' => $plan->details);
			//$plans_data[$count][] = $plan->createdBy->name;
            $plans_data[$count][] = count($plan->positions);
            $plans_data[$count][] = $plan->positions->sum('positions_filled')."/".$plan->positions->sum('head_count');
			$plans_data[$count][] = date('Y-m-d', strtotime($plan->end_date));
			$plans_data[$count][] = '';
			$plans_data[$count][] = $plan->id;
			$plans_data[$count][] = $plan->is_open;
			$plans_data[$count][] = array('start' => date('m/d/Y', strtotime($plan->start_date)), 'end' => date('m/d/Y', strtotime($plan->end_date)));
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_plans,
			'recordsFiltered' => $total_plans,
			'data' 						=> $plans_data
		);
		return json_encode($data);
	}

	public function save_plan(Request $request)
    {

        $user_id = Auth::user()->id;
        $plan_id = 0;
        $message = 'Record Saved.';
        $success = false;
        try {
            $validator = Validator::make($request->all(), [
                'subject'     => 'required',
                'start_date' => 'required',
                'end_date' => 'required',
                'budget' => 'required',
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            /*save file*/
            $my_files = '';
            if ($request->hasFile('file')) {
                $files = Arr::wrap($request->file('file'));
                $filesPath = [];
                $path = generatePath('plans');

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
                $plan = Plan::find($request->input('listing_id'));
            }else{
                $plan = new Plan();
            }
            $company_id = Auth::user()->company_id;
            $plan->subject = $request->input('subject');
            $plan->created_by = $user_id;
            $plan->company_id = $company_id;
            $plan->budget = $request->input('budget');
            $plan->start_date = db_date_format($request->input('start_date'));
            $plan->end_date = db_date_format($request->input('end_date'));
						$plan->details = $request->input('details');
						$plan->is_draft = $request->input('is_draft');
            $plan->attachments = $my_files;
            if(!$request->input('is_update')){
                $plan->created_at = date('Y-m-d H:i:s');

            }
            $plan->updated_at = date('Y-m-d H:i:s');

            if($plan->save())
            {
                $plan_id = $plan->id;
                $message = "Saved Successfully! ";
                $success = true;
                //save positions
                $title = $request->input('plan_position_title');
                $hc = $request->input('plan_position_head_count');
                $due_date = $request->input('plan_position_due_date');
                $bgdt = $request->input('plan_position_budget');
                //$due_date = $due_date ? $due_date[$key] : date('Y-m-d H:i:s');
                    if($request->input('plan_position'))
                    {
                        foreach ($request->input('plan_position') as $key => $result)
                        {
                            if(!empty($result))
                            {
                            $plan_position = new PlanPosition();
                            $plan_position->plan_id = $plan_id;
                            $plan_position->position_id = $result;
                            $plan_position->title = $title ? $title[$key] : '';
                            $plan_position->head_count = $hc ? $hc[$key] : '';
                            $plan_position->due_date = db_date_format($due_date ? $due_date[$key] : date('Y-m-d H:i:s'));
                            $plan_position->budget = $bgdt ? $bgdt[$key] : '';

                            $plan_position->save();
                            }



                        }
                    }

            }else{
                $success = false;
                $message = "Error Occured!";
            }

        } catch (\Exception $e) {

            $message =  $e->getMessage();
            $success = false;

        }

        return response()->json([
            'success' => $success,
            'plan_id' => $plan_id,
						'message' => $message,
						'is_draft' => $request->input('is_draft')
        ]);

		}

	public function save_plan_new(Request $request)
	{

			$user_id = Auth::user()->id;
			$plan_id = 0;
			$message = 'Record Saved.';
			$success = false;
			try {
					$validator = Validator::make($request->all(), [
							'subject'     => 'required',
							'start_date' => 'required',
							'end_date' => 'required',
							'budget' => 'required',
                            'plan_budget' => 'required',
					]);
					if ($validator->fails()) {
							return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
					}

					/*save file*/
					$my_files = '';
					if ($request->hasFile('file')) {
							$files = Arr::wrap($request->file('file'));
							$filesPath = [];
							$path = generatePath('plans');

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
							$plan = Plan::find($request->input('listing_id'));
					}else{
							$plan = new Plan();
					}

					$company_id = Auth::user()->company_id;
                    $plan->company_id = $company_id;
                    $plan->plan_budget = $request->input('plan_budget');
					$plan->subject = $request->input('subject');
					$plan->created_by = $user_id;
					$plan->budget = $request->input('budget');
					$plan->start_date = db_date_format($request->input('start_date'));
					$plan->end_date = db_date_format($request->input('end_date'));
					$plan->details = $request->input('details');
					$plan->is_draft = $request->input('is_draft');
                    $plan->recruitment_type_id = $request->input('recruitment_type_id');
					$plan->attachments = $my_files;
					if(!$request->input('is_update')){
							$plan->created_at = date('Y-m-d H:i:s');

					}
					$plan->updated_at = date('Y-m-d H:i:s');

					if($plan->save())
					{
							$plan_id = $plan->id;
							$message = "Saved Successfully! ";
							$success = true;
                            $my_check = 0;
							//save positions
							$title = $request->input('plan_position_title');
							$local = $request->input('plan_position_local');
							$expat = $request->input('plan_position_expat');
							$hc = $request->input('plan_position_head_count');
							$due_date = $request->input('plan_position_due_date');
							$bgdt = $request->input('plan_position_budget');
                            $rotn = $request->input('plan_position_rotation_type');
                            $nationality = $request->input('plan_position_plan_nationality');
							//$due_date = $due_date ? $due_date[$key] : date('Y-m-d H:i:s');
									if($request->input('plan_position'))
									{

											foreach ($request->input('plan_position') as $key => $result)
											{
													if(!empty($result))
													{
													$plan_position = new PlanPosition();
													$plan_position->plan_id = $plan_id;
													$plan_position->position_id = $result;
													$plan_position->title = $title ? $title[$key] : '';
													$plan_position->expat_positions = $expat ? $expat[$key] : '';
													$plan_position->local_positions = $local ? $local[$key] : '';
													$plan_position->head_count = $hc ? $hc[$key] : '';
													$plan_position->due_date = date('Y-m-d', strtotime($request->input('end_date')));

													//$budget = explode('&', $bgdt[$key]);
													$plan_position->budget_id = 0;
													$plan_position->budget = $bgdt ? $bgdt[$key] : 0;
													$plan_position->rotation_type_id = $rotn ? $rotn[$key] : 0;
                                                    $plan_position->nationality_id = $nationality ? $nationality[$key] : 0;
													$plan_position->save();
													//check if this position has JD or no
                                                        $jd = Vacancy::where('position_id',$result)->first();
                                                        if ($jd === null) {
                                                            //JD not exist
                                                            $my_check = 1;
                                                        }
													}



											}
									}
                        if($my_check == 1)
                        {
                            Session::flash('alert-message', 'One or more JD not updated! Please update JD for position');
                            Session::flash('alert-type', 'warning');
                        }


					}else{
							$success = false;
							$message = "Error Occured!";
					}

			} catch (\Exception $e) {

					$message =  $e->getMessage();
					$success = false;

			}

			return response()->json([
					'success' => $success,
					'plan_id' => $plan_id,
					'message' => $message,
					'is_draft' => $request->input('is_draft')
			]);

	}

	/**
	 * Delete plan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
		if($id) {
			$type = $request->input('type');
			$view = $request->input('view');

			$plan = Plan::find($id);
			$plan->deleted_at = date('Y-m-d H:i:s');
			if ($plan->save()) {
				$success = true;
				$msg = 'Plan deleted.';
			}

			return response()->json([
				'success' => $success,
				'plan_id' => $plan->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/hr-plan')
			]);
		}

	}

	/**
	 * Approve/reject plan.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function approval($id, $status, Request $request)
	{
		$plan = Plan::findOrFail($id);
		$type = $request->input('type');
		$view = $request->input('view');

		if ($plan) {
			$success = false;
			$msg = 'An error occured.';

			if ($status == 3) {
				$plan->is_draft = 0;
			}
			else {
				$plan->is_approved = $status;
			}

			if ($plan->save()) {
				$success = true;
				$msg = 'Plan ' . ($status == 3 ? 'published.' : ($status == 1 ? 'approved' : 'rejected')) . '.';

				//send email to creator if plan approved
				if($status == 1)
				{
						$created_by = $plan->created_by;
						$user = User::where('id',$created_by) -> first();
						if(!empty($user->email))
						{
								$email = $user->email;
								$template_data = '<p>Hi,</p><p>Your Plan has been approved.</p>
																<p>&nbsp;Thank You.</p><p><br></p><br>
										<p>Regards
										</p>';
								Mail::send([], [],
										function ($message) use ($email,$template_data) {
												$message->to($email)
														->from('muhammad.shafiq@itforce-tech.com')
														->subject('Plan Approved')
														->setBody($template_data, 'text/html');
										});
						}

                    // now approve all jobs related to this plan
                    $plan_positions = PlanPosition::where('plan_id',$id)->get();
                    foreach ($plan_positions as $plan_position)
                    {
                         Vacancy::where('position_id', $plan_position->position_id)
                            ->update([
                                'is_approved'=> 1,
                                'updated_at' => date('Y-m-d H:i:s')
                            ]);
                    }
					}

			}

			return response()->json([
				'success' => $success,
				'plan_id' => $plan->id,
				'msg' => $msg,
				'type' => $type,
				'view' => $view,
				'return_url' => url('admin/hr-plan/detail/' . $plan->id)
			]);
		}

	}

}
