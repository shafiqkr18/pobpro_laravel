<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Candidate;
use App\Offer;
use App\PositionManagement;
use App\DepartmentManagement;
use App\User;
use App\StatusDetail;
use App\Template;
use App\RotationType;
use App\ContractDuration;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;


class OfferController extends Controller
{
    //
    public function index()
    {
        return view('admin.pages.hr.offers.index');
    }


    public function offers_filter(Request $request)
    {
        $candidates_data = array();
        $candidates = Candidate::select("*");
        //$candidates->where('is_interviewed', 1)->where('status', 'interviewed');
        $candidates->where('is_interviewed', 1);
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
            //$candidates = Candidate::where('is_interviewed', 1)->where('status', 'interviewed')->get();
            $candidates = Candidate::where('is_interviewed', 1)->get();
            $total_candidates = count($candidates);
            $candidates = Candidate::where('is_interviewed', 1)
               // ->where('status', 'interviewed')
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
            // $candidates_data[$count][] = $candidate->gender;
            // $candidates_data[$count][] = $candidate->age;
            // $candidates_data[$count][] = findEducation($candidate->education_level);
            $candidates_data[$count][] = $candidate->position->title;
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
     * Send offer page
     *
     * @return View
     */
    public function sendOffer()
    {
        $ids = Input::get('ids');
        $position_id = Input::get('pos_id');
        $plan_id = Input::get('plan_id');
				$templates = Template::where('type', 'offer')->where('deleted_at', null)->get();

        if(empty($ids) || empty($position_id) || empty($plan_id)) {
					abort(404);
				}

        $all_users = User::all();
				$position = PositionManagement::where('id',$position_id)->first();
				$company_id = Auth::user()->company_id;
				$_ids = explode(',', $ids);
				$candidates = Candidate::whereIn('id', $_ids)->get();
				$rotation_types = RotationType::all();
				$contract_durations = ContractDuration::all();

				$depts = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
					$query->where('company_id', $company_id);
				})->get();

				$company_departments = [];
				if ($depts) {
					foreach ($depts as $dept) {
						array_push($company_departments, $dept->id);
					}
				}
				$dept_positions = PositionManagement::where('company_id', $company_id)
																						->whereIn('department_id', $company_departments)
																						->get();

        $data = array(
					'all_users' => $all_users,
					'ids' => $ids,
					'position' => $position,
					'position_id' => $position_id,
					'plan_id' => $plan_id,
					'templates' => $templates,
					'dept_positions' => $dept_positions,
					'candidates' => $candidates,
					'rotation_types' => $rotation_types,
					'contract_durations' => $contract_durations
        );
        return view('admin.pages.hr.offers.send_offer')->with('data', $data);
    }

    public function sendContract()
    {
        $ids = Input::get('ids');
        $position_id = Input::get('pos_id');
        $plan_id = Input::get('plan_id');
				$templates = Template::where('type', 'contract')->where('deleted_at', null)->get();

        if(empty($ids) || empty($position_id) || empty($plan_id))
        {
            abort(404);
        }
        $all_users = User::all();
        $position = PositionManagement::where('id',$position_id)->first();

        $data = array(
            'all_users' => $all_users,
            'ids' => $ids,
            'position' => $position,
            'position_id' => $position_id,
						'plan_id' => $plan_id,
						'templates' => $templates

        );
        return view('admin.pages.hr.contracts.send_contract')->with('data', $data);
    }

    public function send_offer_letter_final(Request $request)
    {
        $user_id = Auth::user()->id;
        $message = 'Offer Sent.';
        $success = false;
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',',$ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $id) {

                $offer = Offer::find($id);
                if ($offer->first()) {

                    $job_title = $offer->position?$offer->position->title:'';
                    //$applicant_name = $offer->candidate?$offer->candidate->name:'';

                    $candidate_id = $offer->candidate_id;

                    //if offer not approved from GM,
                    if($offer->gm_approved == 0)
                    {
                        return redirect()
                            ->route("offerlist")
                            ->with([
                                'alert-message'    => "One or more offers not approved from GM!",
                                'alert-type' => 'warning',
                            ]);
                    }
                    try{
                        if(!empty($candidate_id))
                        {
                            $candidate = Candidate::find($candidate_id);
                            if ($candidate->first()) {
                                $data['email'] = $candidate->email;
                                $applicant_name = $candidate->name;
                                $company_name = Auth::user()->company ? Auth::user()->company->company_name : 'ITForce.com';

                                $location = $offer->location;
                                $phrase = $offer->notes;
                                $email = $data['email'];
                                $view_link = \App::make('url')->to('/candidate/uuid/' . $candidate->user_uuid);

                                $temp_var_values = array($view_link, $applicant_name, $company_name);
                                $temp_var = array("{view_link}", "{applicant_name}", "{company_name}");
                                $template_data = str_replace($temp_var, $temp_var_values, $phrase);

                                Mail::send([], [],
                                    function ($message) use ($email,$template_data) {
                                        $message->to($email)
                                            ->from('muhammad.shafiq@itforce-tech.com')
                                            ->subject('Your Offer Letter')
                                            ->setBody($template_data, 'text/html');
                                    });

                                //update offers
                                $offer->sending_status = 1;
                                $offer->save();

                                //sometime user do not have uuid
                                $userEx = User::where('email', '=', $email)->first();
                                if($userEx)
                                {
                                    $user_uuid = $userEx->user_uuid;
                                    if(empty($user_uuid))
                                    {
                                        $user = User::find($userEx->id);
                                        $user->user_uuid = $candidate->user_uuid;
                                        $user->save();
                                    }
                                }
                            }
                        }
                    }catch (\Exception $e) {


                        return redirect()
                            ->route("offerlist")
                            ->with([
                                'alert-message'    => "One or more emails has this error: ".$e->getMessage(),
                                'alert-type' => 'error',
                            ]);
                    }


                }

            }
            //return redirect('admin/offers');
            return redirect()
                ->route("offerlist")
                ->with([
                    'alert-message'    => "Offer(s) sent successfully",
                    'alert-type' => 'success',
                ]);
        }
    }
    public function send_offer_letter(Request $request)
    {
        $user_id = Auth::user()->id;
        $interview_id = 0;
        $message = 'Offer Prepared.';
        $success = false;
        $plan_id = $request->input('plan_id');
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',',$ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $key => $id) {
                $validator = Validator::make($request->all(), [
                    // 'reference_no' => 'required',
                    'position_id' => 'required',
                    'work_start_date' => 'required',
                    'location' => 'required',
                    'subject' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
                }

                /*save file*/
                $my_files = '';
                if ($request->hasFile('file')) {
                    $files = Arr::wrap($request->file('file'));
                    $filesPath = [];
                    $path = generatePath('offers');

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

                if ($request->input('is_update')) {
                    $offer = Offer::find($request->input('listing_id'));
                }else{
                    $offer = new Offer();

                }
                $offer->reference_no = $cn_no = 'OFF-' . date('YmdHis');
                $offer->created_by = $user_id;
                $offer->subject = $request->input('subject');
                $offer->notes = $request->input('contents');
                $offer->location = $request->input('location');
                $offer->work_start_date = db_date_format($request->input('work_start_date'));
                $offer->attachments = $my_files;
                $offer->candidate_id = $id;
                $offer->type = 0;
                $offer->position_id = $request->input('position_id');
                $offer->position_type = $request->input('position_type');
                $offer->report_to = $request->input('report_to');
                $offer->plan_id = $request->input('plan_id');
                $offer->company_id = Auth::user()->company_id;

                //set table data
                $salaries = $request->input('salary');
                $rotations = $request->input('rotation_type');
                $durations = $request->input('contract_duration');
                $pay_type = $request->input('pay_type');
                $hire_type = $request->input('hire_type');


                $offer->offer_amount = $salaries ? $salaries[$key] : 0;
                $offer->rotation_type_id = $rotations ? $rotations[$key] : 0;
                $offer->contract_duration_id = $durations ? $durations[$key] : 0;
                $offer->pay_type = $pay_type ? $pay_type[$key] : 1;
                $offer->hire_type = $hire_type ? $hire_type[$key] : 1;



                if (!$request->input('is_update')) {
                    $offer->created_at = date('Y-m-d H:i:s');

                }
                $offer->updated_at = date('Y-m-d H:i:s');

                if ($offer->save()) {
                    $offer_id = $offer->id;
                    $position_id = $offer->position_id;
                    $dept_id = 0;
                    $sec_id = 0;
                    $div_id = 0;
                    if($position_id)
                    {
                        $my_position = PositionManagement::find($position_id);
                        if($my_position)
                        {
                            $dept_id = $my_position->department ? $my_position->department->id : 0;
                            $sec_id = $my_position->section ? $my_position->section->id : 0;
                            $div_id = $my_position->myDivision ? $my_position->myDivision->id : 0;

                        }
                    }
                    //update status
                    $candidate = Candidate::findOrFail($id);
                $candidate->is_offered = 1;
                $candidate->status = 'offer';
                    if($plan_id > 0)
                    {
                        $candidate->plan_id = $plan_id;
                    }
                    //assign candidate to this company
                    $candidate->company_id = Auth::user()->company_id;

                    $candidate->div_id = $div_id;
                    $candidate->dept_id = $dept_id;
                    $candidate->section_id = $sec_id;

                if ($candidate->save()) {
                        //TODO
                }


                    $success = true;
                    $message = 'Offer prepared!';
                }else{
                    $success = false;
                    $message = 'An error occurred.';
                }


            }
            return response()->json([
                'success' => $success,
                //'job_id' => $interview_id,
                'message' => $message
                ]);
            }



        }

    public function sendCandidateEmail($candidate_id, $view='offer',$offer_id = 0)
    {

        try{
            if(!empty($candidate_id))
            {
                $candidate = Candidate::find($candidate_id);
                $offer = Offer::find($offer_id);

                $data['email'] = $candidate->email;
                $data['name'] = $candidate->name;

                $location = $offer->location;
                $notes = $offer->notes;
                $email = $data['email'];
                if($view == 'offer')
                {
                $data['url'] = \App::make('url')->to('/candidate/uuid/' . $candidate->user_uuid);
                $template_data = [ 'name' => $data['name'],'email'=>$data['email'],'url_link'=>$data['url'],
                    'notes'=>$notes,'location'=>$location,'subject'=>$offer->subject];
                Mail::send(['html' => 'admin.emails.offer'], $template_data,
                    function ($message) use ($email) {
                        $message->to($email)
                            ->from('muhammad.shafiq@itforce-tech.com')
                            ->subject('Your Offer Letter');
                    });
                }else{
                    $data['url'] = \App::make('url')->to('/candidate/uuid/' . $candidate->user_uuid);
                    $template_data = [ 'name' => $data['name'],'email'=>$data['email'],'url_link'=>$data['url'],
                        'notes'=>$notes,'location'=>$location,'subject'=>$offer->subject];
                    Mail::send(['html' => 'admin.emails.contract'], $template_data,
                        function ($message) use ($email) {
                            $message->to($email)
                                ->from('muhammad.shafiq@itforce-tech.com')
                                ->subject('Your Contract');
                        });
                }


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
    public function sendInterviewEmail($candidate_id, $view='offer')
    {
        try {
            if(!empty($candidate_id))
            {
                $candidate = Candidate::find($candidate_id);

                $data['email'] = $candidate->email;
                $data['name'] = $candidate->name;
                $data['token'] = $candidate->user_uuid;
                $data['url'] = \App::make('url')->to('/candidate/uuid/' . $data['token']);
                //Mail::to($data['email'])->send(new InterviewEmail($data));
                $email = $data['email'];
                $template_data = [ 'name' => $data['name'],'email'=>$data['email'],'url_link'=>$data['url']];

                if($view == 'offer')
                {
                    Mail::send(['html' => 'admin.emails.offer'], $template_data,
                        function ($message) use ($email) {
                            $message->to($email)
                                ->from('muhammad.shafiq@itforce-tech.com')
                                ->subject("Your Offer Letter");
                        });
                }else{
                    Mail::send(['html' => 'admin.emails.contract'], $template_data,
                        function ($message) use ($email) {
                            $message->to($email)
                                ->from('muhammad.shafiq@itforce-tech.com')
                                ->subject("Your Contract");
                        });
                }


                return true;
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

    public function send_contract_letter(Request $request)
    {
        $user_id = Auth::user()->id;
        $interview_id = 0;
        $message = 'Contract Prepared';
        $success = false;
        $plan_id = $request->input('plan_id');
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',',$ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $id) {
                $validator = Validator::make($request->all(), [
                    // 'reference_no' => 'required',
                    'position_id' => 'required',
                    'work_start_date' => 'required',
                    'location' => 'required',
                    'subject' => 'required'
                ]);
                if ($validator->fails()) {
                    return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
                }

                /*save file*/
                $my_files = '';
                if ($request->hasFile('file')) {
                    $files = Arr::wrap($request->file('file'));
                    $filesPath = [];
                    $path = generatePath('offers');

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

                if ($request->input('is_update')) {
                    $offer = Offer::find($request->input('listing_id'));
                }else{
                    $offer = new Offer();

                }
                $offer->reference_no = $cn_no = 'CON-' . date('YmdHis');
                $offer->created_by = $user_id;
                $offer->company_id = Auth::user()->company_id;
                $offer->subject = $request->input('subject');
                $offer->notes = $request->input('contents');
                $offer->location = $request->input('location');
                $offer->work_start_date = db_date_format($request->input('work_start_date'));
                $offer->attachments = $my_files;
								$offer->offer_amount = $request->input('offer_amount');
                $offer->candidate_id = $id;
                $offer->type = 1;
                $offer->position_id = $request->input('position_id');
                $offer->plan_id = $request->input('plan_id');
                $offer->position_type = $request->input('position_type');
                $offer->report_to = $request->input('report_to');


                if (!$request->input('is_update')) {
                    $offer->created_at = date('Y-m-d H:i:s');

                }
                $offer->updated_at = date('Y-m-d H:i:s');

                if ($offer->save()) {
                    //update status
                    $candidate = Candidate::findOrFail($id);
                $candidate->is_contract = 1;
                $candidate->status = 'contract';
                    $candidate->company_id = Auth::user()->company_id;
                    if($plan_id > 0)
                    {
                        $candidate->plan_id = $plan_id;
                    }
                if ($candidate->save()) {
                        //TODO
                    }
                    $offer_id = $offer->id;

                    //$send_email = $this->sendCandidateEmail($id,'contract',$offer_id);
                    $success = true;
                    $message = 'Contract prepared';
                }else{
                    $success = false;
                    $message = 'An error occurred.';
                }


            }
            return response()->json([
                'success' => $success,
                //'job_id' => $interview_id,
                'message' => $message
                ]);
            }




    }

    public function send_contract_letter_final(Request $request)
    {
        $user_id = Auth::user()->id;
        $message = 'Contract Sent.';
        $success = false;
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',',$ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $id) {

                $offer = Offer::find($id);
                if ($offer->first()) {

                    $job_title = $offer->position?$offer->position->title:'';
                    //$applicant_name = $offer->candidate?$offer->candidate->name:'';

                    $candidate_id = $offer->candidate_id;

                    //if offer not approved from GM,
                    if($offer->gm_approved == 0)
                    {
                        return redirect()
                            ->route("employee_contracts_list")
                            ->with([
                                'alert-message'    => "One or more contracts not approved from GM!",
                                'alert-type' => 'warning',
                            ]);
                    }
                    try{
                        if(!empty($candidate_id))
                        {
                            $candidate = Candidate::find($candidate_id);
                            if ($candidate->first()) {
                                $data['email'] = $candidate->email;
                                $applicant_name = $candidate->name;
                                $company_name = Auth::user()->company ? Auth::user()->company->company_name : 'ITForce.com';

                                $location = $offer->location;
                                $phrase = $offer->notes;
                                $email = $data['email'];
                                $view_link = \App::make('url')->to('/candidate/uuid/' . $candidate->user_uuid);

                                $temp_var_values = array($view_link, $applicant_name, $company_name);
                                $temp_var = array("{view_link}", "{applicant_name}", "{company_name}");
                                $template_data = str_replace($temp_var, $temp_var_values, $phrase);

                                Mail::send([], [],
                                    function ($message) use ($email,$template_data) {
                                        $message->to($email)
                                            ->from('muhammad.shafiq@itforce-tech.com')
                                            ->subject('Your Contract Letter')
                                            ->setBody($template_data, 'text/html');
                                    });

                                //update offers
                                $offer->sending_status = 1;
                                $offer->save();
                            }
                        }
                    }catch (\Exception $e) {


                        return redirect()
                            ->route("employee_contracts_list")
                            ->with([
                                'alert-message'    => "One or more emails has this error: ".$e->getMessage(),
                                'alert-type' => 'error',
                            ]);
                    }


                }

            }
            //return redirect('admin/offers');
            return redirect()
                ->route("employee_contracts_list")
                ->with([
                    'alert-message'    => "Contract(s) sent successfully",
                    'alert-type' => 'success',
                ]);
        }
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
        $gm_app = Input::get('gm_app', 0);
		return view('admin.pages.hr.offers.list',compact(
		    'pending','ur','gm_app'
        ));
	}

    public function offers_pending()
    {
        $pending = Input::get('pending', 0);
        $ur = Input::get('ur', 0);
        return view('admin.pages.hr.offers.list_pending',compact(
            'pending','ur'
        ));
    }



	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$offer = Offer::find($id);
		$user = Auth::user();

        if (Auth::user()->hasRole('itfpobadmin')) {
            $my_role = 'itfpobadmin';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }elseif ((Auth::user()->hasRole('DM')) && ($offer->dm_approved != 1))
        {
            $my_role = 'DM';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }elseif ((Auth::user()->hasRole('HRM')) && ($offer->dm_approved == 1) && ($offer->hrm_approved != 1))
        {
            $my_role = 'HRM';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }elseif ((Auth::user()->hasRole('GM')) && ($offer->dm_approved == 1) && ($offer->hrm_approved == 1) && ($offer->gm_approved != 1))
        {
            $my_role = 'GM';
            $returnHTML = view('admin.partials.offer_approve_form',compact('offer','my_role'))->render();
        }else{
            $returnHTML = '';
        }



		return view('admin.pages.hr.offers.detail', compact(
			'offer',
			'user','returnHTML'
		));
	}

	/**
	 * Get offers.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function offer_list_filter(Request $request)
	{
		$offers_data = array();
		$offers = Offer::select("*");
		$offers->where('type', 0)->where('deleted_at', null);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;



        if($request->has('gm_app') && $request->input('gm_app') > 0){
            $is_filter = true;
            $offers->where('gm_approved', 1)->where('sending_status',0);
				}

		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$offers->where('name','like', '%'.$request->get('search')['value'].'%');
		}

        if (!Auth::user()->hasRole('itfpobadmin')) {
            $offers->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }

		if($is_filter) {
			$total_offers = count($offers->get());
			$offers = $offers->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$offers = Offer::where('type', 0)->get();
				$total_offers = count($offers);
				$offers = Offer::where('type', 0)->where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($offers as $offer) {
			// get status
			$status = '';
			if ($offer->dm_approved == 1) {
				if ($offer->hrm_approved == 1) {
					if ($offer->gm_approved == 1) {
						$status = 'Approved';
					}elseif ($offer->gm_approved == 2)
                    {
                        $status = 'Rejected by GM';
					}
					else {
						$status = 'Pending for GM';
					}
				}elseif ($offer->hrm_approved == 2)
                {
                    $status = 'Rejected by HRM';
				}
				else {
					$status = 'Pending for HRM';
				}
			}elseif ($offer->dm_approved == 2)
            {
                $status = 'Rejected by DM';
			}
			else {
				$status = 'Pending for DM';
			}

			$offers_data[$count][] = $offer->id;
			$offers_data[$count][] = $status;
			$offers_data[$count][] = $offer->sending_status;
			$offers_data[$count][] = $offer->accepted;
			$offers_data[$count][] = $offer->candidate ? $offer->candidate : '';
			$offers_data[$count][] = $offer->candidate && $offer->candidate->old_position ? $offer->candidate->old_position->title : '';
			$offers_data[$count][] = $offer->position ? $offer->position->title : '';
			$offers_data[$count][] = $offer->offer_amount;
			$offers_data[$count][] = $offer->candidate ? $offer->candidate->level : '';
			$offers_data[$count][] = '';
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_offers,
			'recordsFiltered' => $total_offers,
			'data' 						=> $offers_data
		);
		return json_encode($data);
	}


    public function offer_list_filter_pending(Request $request)
    {
        $offers_data = array();
        $offers = Offer::select("*");
        $offers->where('type', 0);
        $offers->where('deleted_at', null);
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;

        if($request->has('pending') && $request->input('pending') > 0){
            $ur_role = $request->input('ur');
            if($ur_role == 'DM')
            {
                $offers->where('dm_approved', 0);
            }elseif($ur_role == 'HRM'){
                $offers->where('hrm_approved', 0)->where('dm_approved',1);
            }elseif ($ur_role == 'GM')
            {
                $offers->where('gm_approved', 0)->where('dm_approved',1)->where('hrm_approved',1);
            }else{
							$offers->where(function ($query) {
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
            $offers->where('name','like', '%'.$request->get('search')['value'].'%');
        }

        if (!Auth::user()->hasRole('itfpobadmin')) {
            $offers->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }

        if($is_filter) {
            $total_offers = count($offers->get());
            $offers = $offers->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }
        else {
            $offers = Offer::where('type', 0)->get();
            $total_offers = count($offers);
            $offers = Offer::where('type', 0)->where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($offers as $offer) {
					// get status
					$status = '';
					$dm = $hrm = $gm = 0;
					if ($offer->dm_approved == 1) {
                $dm = 1;
						if ($offer->hrm_approved == 1) {
                    $hrm = 1;
							if ($offer->gm_approved == 1) {
                        $gm = 1;
								$status = 'Approved';
                    }elseif ($offer->gm_approved == 2)
                    {
                        $status = 'Rejected by GM';
							}
							else {
								$status = 'Pending for GM';
							}
                }elseif ($offer->hrm_approved == 2)
                {
                    $status = 'Rejected by HRM';
						}
						else {
							$status = 'Pending for HRM';
						}
            }elseif ($offer->dm_approved == 2)
            {
                $status = 'Rejected by DM';
					}
					else {
						$status = 'Pending for DM';
					}

					$offers_data[$count][] = $offer->id;
					$offers_data[$count][] = $status;
					$offers_data[$count][] = $offer->sending_status;
					$offers_data[$count][] = $offer->accepted;
					$offers_data[$count][] = $offer->candidate ? $offer->candidate : '';
            $offers_data[$count][] = $offer->candidate && $offer->candidate->old_position ? $offer->candidate->old_position->title : '';
					$offers_data[$count][] = $offer->position ? $offer->position->title : '';
					$offers_data[$count][] = $offer->offer_amount;
					$offers_data[$count][] = $offer->candidate ? $offer->candidate->level : '';
					$offers_data[$count][] = '';
            $offers_data[$count][] = $dm;
            $offers_data[$count][] = $hrm;
            $offers_data[$count][] = $gm;
					$count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_offers,
            'recordsFiltered' => $total_offers,
            'data' 						=> $offers_data
        );
        return json_encode($data);
    }

	/**
	 * Save offer comment.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function saveComment(Request $request)
	{
		$user_id = Auth::user()->id;
		$success = false;

		try {
			$validator = Validator::make($request->all(), [
				'status_details' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors' => $validator->getMessageBag()->toArray()]);
			}

			$status_detail = new StatusDetail();
			$status_detail->listing_id = $request->input('offer_id');
			$status_detail->type = 3;
			$status_detail->status_title = 'comments';
			$status_detail->status_details = $request->input('status_details');
			$status_detail->created_by = $user_id;
			$status_detail->status_datetime = date('Y-m-d H:i:s');
			$status_detail->created_at = date('Y-m-d H:i:s');

			if ($status_detail->save()) {
				$success = true;
				$message = 'Comment saved.';

				$avatar = $status_detail->createdBy->avatar ? json_decode($status_detail->createdBy->avatar, true) : null;
			}
			else {
				$message = 'An error occurred.';
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'comment' => $status_detail,
			'createdBy' => $status_detail->createdBy->name,
			'avatar' => $avatar ? asset('/storage/' . $avatar[0]['download_link']) : null
		]);

	}

	/**
	 * Save offer status.
	 *
	 * @return \Illuminate\Http\Response
	 */
	function saveStatus(Request $request)
	{
		$user = Auth::user();
		$roles = $user->roles->pluck('name')->all();

		$message = '';
		$success = false;
		$offer_id = $request->input('offer_id');

		if(!empty($offer_id)) {
			$offer = Offer::find($offer_id);

			if (in_array('GM', $roles)) {
				$offer->gm_approved = $request->input('rdbtn');
                $approve_by_role = 'GM';
			}

			if (in_array('HRM', $roles)) {
				$offer->hrm_approved = $request->input('rdbtn');
                $approve_by_role = 'HRM';
			}

			if (in_array('DM', $roles)) {
				$offer->dm_approved = $request->input('rdbtn');
                $approve_by_role = 'DM';
			}

			$offer->comments = $request->input('comments') ? $request->input('comments') : null;

			if ($offer->save()) {
				$success = true;
				$message = 'Offer ' . ($request->input('rdbtn') == 1 ? 'approved' : 'rejected') . '.';

				//save in status table
				$status_detail = new StatusDetail();
                $m = $request->input('rdbtn') == 1 ? 'approved' : 'rejected';
                $status_detail->listing_id = $offer_id;
                $status_detail->type = 4; // for offer status
                $status_detail->status_title = 'Offer(S) status changed';
                $status_detail->action_type = $request->input('rdbtn');
                $status_detail->status_details = $user->name." (".$approve_by_role.") ".$m." offer";
                $status_detail->created_by = $user->id;
                $status_detail->status_datetime = date('Y-m-d H:i:s');
                $status_detail->created_at = date('Y-m-d H:i:s');
				$status_detail->save();

				//create task / activity
                if (Auth::user()->hasRole('GM')) {
					if($request->input('rdbtn') == 1) {
                        $activity = new Activities();
                        $activity->listing_id = $offer_id;
                        $activity->type = "offers";
                        $activity->activity_title = 'Offer Approved';
                        $activity->activity_details = "Offer Approved by GM - ".Auth::user()->name;
                        $activity->action_type = 1;//approved
                        $activity->created_by = Auth::user()->id;
                        $activity->company_id = Auth::user()->company_id;
                        $activity->created_at = date('Y-m-d H:i:s');
                        $activity->save();
                    }

                }

			}
			else {
				$message = 'An error occurred.';
				$success = false;
			}
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'offer_ id' => $offer_id
		]);

	}
    public function saveXpleStatus(Request $request)
    {
        $user_id = Auth::user()->id;
        $message = 'Offer Sent.';
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
                    $status_detail->status_title = 'Offer(S) status changed';
                    $status_detail->action_type = 1;// as this is only approved function
                    $status_detail->status_details = Auth::user()->name." (".$approve_by_role.") approved offers";
                    $status_detail->created_by = Auth::user()->id;
                    $status_detail->status_datetime = date('Y-m-d H:i:s');
                    $status_detail->created_at = date('Y-m-d H:i:s');
                    $status_detail->save();

                    if (Auth::user()->hasRole('GM')) {
                        $activity = new Activities();
                        $activity->listing_id = $id;
                        $activity->type = "offers";
                        $activity->activity_title = 'Offer Approved';
                        $activity->activity_details = "Offer Approved by GM - ".Auth::user()->name;
                        $activity->action_type = 1;//approved
                        $activity->created_by = Auth::user()->id;
                        $activity->company_id = Auth::user()->company_id;
                        $activity->created_at = date('Y-m-d H:i:s');
                        $activity->save();
                    }

                }
            }

            return redirect()
                 ->route("offers_pending",['pending'=>1, 'ur'=>$my_role])
                ->with([
                    'alert-message'    => "Offer(s) Approved Successfully",
                    'alert-type' => 'success',
                ]);



        }
    }

}
