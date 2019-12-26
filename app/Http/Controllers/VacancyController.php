<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Candidate;
use App\Interview;
use App\InterviewAttendee;
use App\JobStatusDetail;
use App\Mail\InterviewEmail;
use App\Offer;
use App\OrganizationManagement;
use App\PositionManagement;
use App\PositionRelationship;
use App\Vacancy;
use App\Plan;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Str;


class VacancyController extends Controller
{
    //
    /**
     * Index/List page
     *
     * @return View
     */
    public function index()
    {
        return view('admin.pages.hr.vacancy.list');
    }

    /**
     * post_job page
     *
     * @return \Illuminate\Http\Response
     */
    public function post_job($id = false, Request $request)
    {
        $all_users = User::all();
        $job_no = "JOB-".date('YmdHis');
        if($id){

            $data = array(
                'position_id' => $id,
                'all_users' => $all_users,
                'job_no'=>$job_no
            );
        }else{
            abort(404);
        }
        return view('admin.pages.hr.vacancy.post_job')->with('data', $data);
    }


    public function vacancy_filter(Request $request)
    {
        $position_data = array();
        $positions = PositionManagement::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $positions->where('reference_no','like', '%'.$request->get('search')['value'].'%');
        }
        if($is_filter){
            $total_positions = count($positions->get());
            $positions = $positions->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $positions = PositionManagement::all();
            $total_positions = count($positions);
            $positions = PositionManagement::offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($positions as $position) {
            $position_data[$count][] = $position->id;
            $position_data[$count][] = $position->reference_no;
            $position_data[$count][] = $position->department->department_name;
            $position_data[$count][] = $position->title;
            $position_data[$count][] = $position->total_positions;
            $position_data[$count][] = $position->positions_filled;

            $position_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_positions,
            'recordsFiltered' => $total_positions,
            'data' => $position_data
        );
        return json_encode($data);
    }

    public function save_interview(Request $request)
    {
        $user_id = Auth::user()->id;
				$interview_id = 0;
				$message = 'Interview scheduled.';
				$success = true;
        $plan_id = $request->input('plan_id');
        $position_id = $request->input('position_id');
        $max_id = Interview::max('id');
        $max_id = $max_id + 1;

        $batch_no = "Batch".str_pad($max_id, 5, "0", STR_PAD_LEFT);
        if($request->input('ids')) {
            $ids = $request->input('ids');
						$ids = explode(',',$ids);
						sort($ids);
						$i = 0;
            foreach ($ids as $id) {
                try {

                    $validator = Validator::make($request->all(), [
                        // 'reference_no' => 'required',
												'interview_date' => 'required',
												'start_time' => 'required',
												'end_time' => 'required',
                        'subject' => 'required'
                    ]);
                    if ($validator->fails()) {
                        return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
                    }

                    if ($request->input('is_update')) {
                        $interview = Interview::find($request->input('listing_id'));
                    } else {
                        $interview = new Interview();

                        $interview->reference_no = $cn_no = "INTV".rand(111111,999999);
                        $interview->batch_no = $batch_no;
                    }


                    $candidateExist = Candidate::find($id);
                    if($candidateExist)
                    {
                        $token = $candidateExist->user_uuid;
                        if(empty($token))
                        {
                            $token = (string) Str::uuid();
                        }
                    }else{
                        $token = (string) Str::uuid();
                    }


                    $interview->company_id = Auth::user()->company_id;
                    $interview->created_by = $user_id;
                    $interview->plan_id = $plan_id;
                    $interview->position_id = $position_id;
										// $interview->interview_date = db_date_format($request->input('interview_date'));
										$interview->interview_date = date('Y-m-d H:i:s', ($request->input('start') + ($i * $request->input('interval') * 60)));
                    $interview->subject = $request->input('subject');
                    $interview->candidate_id = $id;
                    $interview->location = $request->input('location');

                    if($request->input('notes'))
                    {
                        $contents = str_replace("http://{view_link}", "{view_link}", $request->input('notes'));
                        $interview->notes = $contents;
                    }

                    //save for later use
                    $data['location'] = $request->input('location');
                    $data['datetime'] = date('Y-m-d H:i:s', ($request->input('start') + ($i * $request->input('interval') * 60)));

                    if (!$request->input('is_update')) {
                        $interview->created_at = date('Y-m-d H:i:s');

                    }
                    $interview->updated_at = date('Y-m-d H:i:s');

                    if ($interview->save()) {
												$interview_id = $interview->id;

						$email_contents = $interview->notes;

                        $candidate = Candidate::find($id);
                        $email = $candidate->email;
                        $candidate->user_uuid = $token;
                        $candidate->is_interviewed = 1;
                        $candidate->plan_id = $plan_id;
                        $candidate->position_id = $position_id;
                        $candidate->status = 'interview';
                        $candidate->company_id = Auth::user()->company_id;
                        if ($candidate->save()) {
                            //create user


                        }

                        if(!empty($email))
                        {


                            if (User::where('email', '=', $email)->exists()) {
                                // user found
                                $user = User::where('email', '=', $email)->first();
                                $user = User::find($user->id);
                            }else{
                            $user = new User();
                            }

                            $user->name = $candidate->name;
                            $user->email = $candidate->email;
                            $user->password = Hash::make('123456789');
                            $user->user_type = 2;
                            $user->user_uuid = $token;
                            $user->save();
                        }

                        //save interviews interviewer_id
                        $interviewers = $request->input('interviewer_id');
                        foreach ($interviewers as $interviewer)
                        {
                            $interv = new InterviewAttendee();
                            $interv->interview_id = $interview_id;
                            $interv->candidate_id = $id;
                            $interv->interviewer_id = $interviewer;
                            $interv->company_id = Auth::user()->company_id;
                            $interv->plan_id = $plan_id;
                            $interv->position_id = $position_id;
                            $interv->created_at = date('Y-m-d H:i:s');
                            $interv->save();

                        }

                        //save history
                        $activity = new Activities();
                        $activity->listing_id = $interview_id;
                        $activity->type = "interviews";
                        $activity->activity_title = 'Interview Invitation Sent';
                        $activity->activity_details = "Interview Invitation Sent by - ".Auth::user()->name;
                        $activity->action_type = 3;//interview sent
                        $activity->created_by = Auth::user()->id;
                        $activity->company_id = Auth::user()->company_id;
                        $activity->created_at = date('Y-m-d H:i:s');
                        $activity->save();



                        //send email
                        $data['token'] = $token;
                        $data['candidate_id'] = $id;
                        $data['email_contents'] = $email_contents;
                        $data['url'] = \App::make('url')->to('/candidate/uuid/' . $data['token']);
                        $send_email = $this->sendInterviewEmail($data);

                    } else {
											$success = false;
											$message = 'An error occurred.';
//                        $message = "Error Occured!";
//                        return response()->json([
//                            'success' => false,
//                            'job_id' => $interview_id,
//                            'message' => $message
//                        ]);
                    }

                } catch (\Exception $e) {

//                    $message = $e->getMessage();
//                    return response()->json([
//                        'success' => false,
//                        'job_id' => $interview_id,
//                        'message' => $message
//                    ]);
								}

								$i++;
            }

        }

        return response()->json([
            'success' => $success,
            'interview_id' => $interview_id,
						'message' => $message
        ]);
		}

    public function save_job(Request $request)
    {
        $user_id = Auth::user()->id;
        $job_id = 0;
        try {

            $validator = Validator::make($request->all(), [
                'job_ref_no'     => 'required',
                'job_title' => 'required',
                'job_description' => 'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $job = Vacancy::find($request->input('listing_id'));
            }else{
                $job = new Vacancy();
            }


            $job->position_id = $request->input('position_id');
            $job->created_by = $user_id;
            $job->job_ref_no = $request->input('job_ref_no');
            $job->job_title = $request->input('job_title');
            $job->job_description = $request->input('job_description');

            $job->nationality = $request->input('nationality');
            $job->location = $request->input('location');
            $job->gender = $request->input('gender');

            $job->age = $request->input('age');
            $job->education_level = $request->input('education_level');
            $job->work_type = $request->input('work_type');
            $job->salary = $request->input('salary');
            $job->company_id = Auth::user()->company_id;

            if(!$request->input('is_update')){
                $job->created_at = date('Y-m-d H:i:s');

            }
            $job->updated_at = date('Y-m-d H:i:s');

            if($job->save())
            {
                $job_id = $job->id;
                $message = "Saved Successfully! ";
                return response()->json([
                    'success' => true,
                    'job_id' => $job_id,
                    'message' =>$message
                ]);
            }else{
                $message = "Error Occured!";
                return response()->json([
                    'success' => false,
                    'job_id' => $job_id,
                    'message' =>$message
                ]);
            }

        } catch (\Exception $e) {

            $message =  $e->getMessage();
            return response()->json([
                'success' => false,
                'job_id' => $job_id,
                'message' =>$message
            ]);
        }
    }

    public function all_jobs($id = false,Request $request)
    {
        $all_users = User::all();
        $user_id = Auth::user()->id;
        if($id){
        $jobs = Vacancy::where('position_id', $id)
            ->orderBy('created_at', 'desc')
            ->take(500)
            ->get();
        }else{
            abort(404);
        }
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'jobs'=>$jobs,

        );

        return view('admin.pages.hr.vacancy.all_jobs')->with('data', $data);
    }


    public function matching_candidates($id = 0, Request $request)
    {
        if($id>0){

            $data = array(
                'position_id' => $id,

            );
        }else{
            abort(404);
        }
        return view('admin.pages.hr.vacancy.matching_list')->with('data',$data);
    }

    public function online_candidates($id = 0, Request $request)
    {
        if($id>0){
            $position = PositionManagement::where('id', $id)->first();
            $data = array(
                'position_id' => $id,
                'position'=>$position,

            );
        }else{
            abort(404);
        }
        return view('admin.pages.hr.vacancy.online_list')->with('data',$data);
    }


    public function matching_candidate_filter(Request $request)
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

        if($request->has('position_id') && $request->input('position_id') > 0){
            $candidates->where('position_id', $request->input('position_id'));
            $candidates->where('is_online', 0);
            $is_filter = true;
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
            $candidates = Candidate::offset($start)->limit($length)->orderBy('id', 'desc')->get();
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
            $candidates_data[$count][] = $candidate->age;
            $candidates_data[$count][] = findEducation($candidate->education_level);
            $candidates_data[$count][] = $candidate->position->title;
            $candidates_data[$count][] = $candidate->status;
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

    public function online_candidate_filter(Request $request)
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

        if($request->has('position_id') && $request->input('position_id') > 0){
            $candidates->where('position_id', $request->input('position_id'));
            $candidates->where('is_online', 1);
            $is_filter = true;
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
            $candidates = Candidate::offset($start)->limit($length)->orderBy('id', 'desc')->get();
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
            $candidates_data[$count][] = $candidate->age;
            $candidates_data[$count][] = findEducation($candidate->education_level);
            //$candidates_data[$count][] = $candidate->position->title;
            $candidates_data[$count][] = $candidate->status;
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

    public function short_list_xple_candidate(Request $request)
    {
        $ids = $request->input('ids');
        $ids=explode(',',$ids);
        foreach($ids as $id){
           //echo $id."<br>";
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


//                return response()->json([
//                    'success' => $success,
//                    'msg' => $msg,
//                    'candidate' => $candidate
//                ]);
            }

            return view('admin.pages.hr.vacancy.list');

        }

    }

    public function call_for_interview(Request $request)
    {
        $ids = Input::get('ids');
        $plan_id = Input::get('plan_id',0);
        $position_id = Input::get('position_id',0);
        $all_users = User::all();
        $user_id = Auth::user()->id;
				$cn_no = "INT-".date('YmdHis');
				$_ids = explode(',', $ids);
				$candidates = Candidate::whereIn('id', $_ids)->get();

			$company_id = Auth::user()->company_id ? Auth::user()->company_id : 1;
			$interviewers = User::where('company_id', $company_id)->whereIn('user_type', [0, 1, 3])->get();

        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'cn_no' => $cn_no,
						'ids' => $ids,
			'candidates' => $candidates,
            'plan_id' => $plan_id,
            'position_id' =>$position_id,
				'interviewers' => $interviewers

        );
        return view('admin.pages.hr.vacancy.interview_new')->with('data', $data);
		}

		public function interview_preview(Request $request)
    {
        $_ids = Input::get('ids');
				$ids = explode(',', $_ids);

				$interviews = Interview::whereIn('id', $ids)->get();

        return view('admin.pages.hr.vacancy.interview_preview', compact(
					'interviews',
					'_ids'
				));
    }

    public function test_email(Request $request)
    {
        try {
            if(true)
            {
                //$candidate = Candidate::find($data['candidate_id']);

                $data['email'] = 'muhammad.shafiq@itforce-tech.com';
                $data['name'] = 'shafiq';
                $email = $data['email'];
                $data['url'] = 'urllink';
                $position = "IT MANG";
                $datetime = '2017-02-02 02:02:02';
                $location = "Georgia";
                $template_data = [ 'name' => $data['name'],'email'=>$data['email'],'url_link'=>$data['url'],
                    'position'=>$position,'datetime'=>$datetime,'location'=>$location];
                Mail::send(['html' => 'admin.emails.interview'], $template_data,
                    function ($message) use ($email) {
                        $message->to($email)
                            ->from('muhammad.shafiq@itforce-tech.com')
                            ->subject('Interview Schedule');
                    });
                //Mail::to($data['email'])->send(new InterviewEmail($data));

                return [
                    'success' => true,
                    'msg' => __('message.message_sent')
                ];
            }

        } catch (Exception $e) {
            // Debug via $ex->getMessage();
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'msg' => __('message.message_fail')
            ];
        }
    }
    public function sendInterviewEmail($data)
    {
        try {
            if(!empty($data['candidate_id']))
            {
                $candidate = Candidate::find($data['candidate_id']);

                $data['email'] = $candidate->email;
                $data['name'] = $candidate->name;
                //Mail::to($data['email'])->send(new InterviewEmail($data));
                $location = $data['location'];
                $position = $candidate->position->title;
                $datetime = $data['datetime'];
                if(empty($location))
                {
                    $location = $candidate->position->location;
                }

                $email = $data['email'];
//                $template_data = [ 'name' => $data['name'],'email'=>$data['email'],'url_link'=>$data['url'],
//                    'position'=>$position,'datetime'=>$datetime,'location'=>$location];

                $company_name = Auth::user()->company ? Auth::user()->company->company_name : 'ITForce.com';
                $phrase = $data['email_contents'];
                $view_link = $data['url'];
                $name = $data['name'];
                //date & time
                $timestamp = strtotime($datetime);
                $interviewdate = date('n.j.Y', $timestamp);
                $interviewtime = date('H:i', $timestamp);
                $temp_var_values = array($view_link, $name, $company_name,$interviewdate,$interviewtime,$location,$position);
                $temp_var = array("{view_link}", "{name}", "{company_name}","{interviewdate}","{interviewtime}","{location}","{position}");
                $template_data = str_replace($temp_var, $temp_var_values, $phrase);


//                Mail::send(['html' => 'admin.emails.interview'], $template_data,
//                    function ($message) use ($email) {
//                        $message->to($email)
//                            ->from('muhammad.shafiq@itforce-tech.com')
//                            ->subject('Interview Schedule');
//                    });
                Mail::send([], [],
                    function ($message) use ($email,$template_data) {
                        $message->to($email)
                            ->from('muhammad.shafiq@itforce-tech.com')
                            ->subject('Interview Schedule')
                            ->setBody($template_data, 'text/html');
                    });

                return [
                    'success' => true,
                    'msg' => __('message.message_sent')
                ];
            }

        } catch (\Exception $e) {
            // Debug via $ex->getMessage();
            return [
                'success' => false,
                'error' => $e->getMessage(),
                'msg' => __('message.message_fail')
            ];
        }

    }


    public function interviewee_list($id = 0,$planid=0, Request $request)
    {
        $interviews_this_week = [];
        $day_of_week = date('N');
        $end_of_week = date('Y-m-d', strtotime('next Sunday'));
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $company_id =  Auth::user()->company_id ? Auth::user()->company_id : 0;
        $plan = Plan::find($planid);
        if (Auth::user()->hasRole('itfpobadmin')) {
            $candidates = Candidate::where('deleted_at',null)->where('is_qualified',0)->get();
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
            $interviews_later = Interview::where('position_id', $id)->where('is_qualified', 0)->whereDate('interview_date', '>=', $end_of_week)
                ->orderBy('interview_date', 'ASC')
                ->limit(5)
                ->get();
        }else{
            $candidates = Candidate::where('deleted_at',null)->where('company_id', $company_id)->where('is_qualified',0)->get();
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

            $ex_positions = PositionRelationship::where('position_id',$id)->whereNull('deleted_at')->get();

            $data = array(
                'position_id' => $id,
                'position'=>$position,
                'plan_id' =>$planid,
								'plan' => $plan,
				'candidates'=>$candidates,
                'ex_positions' =>$ex_positions
            );
        }else{
            abort(404);
        }
        return view('admin.pages.hr.vacancy.interviewwee_list', compact(
					'data',
                    'interviews',
					'interviews_today',
					'interviews_tomorrow',
					'interviews_this_week',
					'interviews_later'
				));
    }

    public function interviewee_filter(Request $request)
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

        if (!Auth::user()->hasRole('itfpobadmin')) {
        $candidates->where('company_id', Auth::user()->company_id);
        $is_filter = true;
        }

        if($request->has('position_id') && $request->input('position_id') > 0){
            $candidates->where('position_id', $request->input('position_id'));
            $candidates->where('plan_id', $request->input('plan_id'));
            //$candidates->where('is_online', 0);
            $candidates->where('is_qualified',1);
            $is_filter = true;
        }

        if($is_filter){
            $total_candidates = count($candidates->get());
            $candidates = $candidates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
						 $candidates = Candidate::where('plan_id', $request->input('plan_id'))->where('position_id', $request->input('position_id'))->get();
						//$candidates = Candidate::all();
            $total_candidates = count($candidates);
            $candidates = Candidate::where('plan_id', $request->input('plan_id'))->where('position_id', $request->input('position_id'))->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($candidates as $candidate) {
            $is_offered = 0;
            $prepared_approved = 0;
            if(Offer::where('candidate_id', '=', $candidate->id)->exists())
            {
                $is_offered = 1;
                $offerExist = Offer::where('candidate_id', '=', $candidate->id)->orderBy('created_at', 'desc')->first();
                //if all three depts approved then can not prepare
                if(($offerExist->dm_approved == 1) && ($offerExist->hrm_approved == 1) && ($offerExist->gm_approved == 1))
                {
                    $prepared_approved = 1;
                }
            }
            $candidates_data[$count][] = $candidate->id;
            $candidates_data[$count][] = '';
            $candidates_data[$count][] = $candidate->reference_no;
            $candidates_data[$count][] = $candidate->name." ".$candidate->last_name;
            $candidates_data[$count][] = $candidate->nationality;
            $candidates_data[$count][] = $candidate->location;
            $candidates_data[$count][] = $candidate->gender;
            $candidates_data[$count][] = $candidate->age;
            $candidates_data[$count][] = findEducation($candidate->education_level);
						$candidates_data[$count][] = $candidate->fixed_salary;
						$candidates_data[$count][] = $candidate->level;
						$candidates_data[$count][] = $candidate->is_interviewed;
						$candidates_data[$count][] = $candidate->is_offered;
						$candidates_data[$count][] = $candidate->is_contract;
            $candidates_data[$count][] = $is_offered;
            $candidates_data[$count][] = $prepared_approved;
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
}
