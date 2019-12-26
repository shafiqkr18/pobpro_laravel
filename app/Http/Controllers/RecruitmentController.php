<?php

namespace App\Http\Controllers;

use App\Candidate;
use App\Division;
use App\PositionManagement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Interview;

class RecruitmentController extends Controller
{
  /**
	 * Index page
	 *
	 * @return View
	 */
	public function index()
	{
        $company_id =  Auth::user()->company_id ? Auth::user()->company_id : 0;
        $day_of_week = date('N');
        $end_of_week = date('Y-m-d', strtotime('next Sunday'));
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $interviews_this_week = [];

        if (Auth::user()->hasRole('itfpobadmin')) {
		$interviews = Interview::orderBy('interview_date', 'ASC')->get();
		$divisions = Division::whereNull('deleted_at')->get();
            $positions = PositionManagement::whereNull('deleted_at')->where('status','=','open')->get();

            $interviews_today = Interview::whereDate('interview_date', date('Y-m-d'))->where('is_qualified', 0)
																->orderBy('interview_date', 'ASC')
																->get();


            $interviews_tomorrow = Interview::whereDate('interview_date', $tomorrow)->where('is_qualified', 0)
															->orderBy('interview_date', 'ASC')
															->get();

		if ($day_of_week != 6) {
                $interviews_this_week = Interview::whereBetween('interview_date', [$tomorrow, $end_of_week])->where('is_qualified', 0)
																			->orderBy('interview_date', 'ASC')
																			->get();
		}

            $interviews_later = Interview::whereDate('interview_date', '>=', $end_of_week)->where('is_qualified', 0)
																		->orderBy('interview_date', 'ASC')
																		->limit(5)
																		->get();


        }else{

            $interviews = Interview::where('company_id', $company_id)->orderBy('interview_date', 'ASC')->get();
            $org_id = Auth::user()->organization ? Auth::user()->organization->id : 0;

            $divisions = Division::where('org_id', $org_id)->whereNull('deleted_at')->get();
            $positions = PositionManagement::whereNull('deleted_at')->where('status','=','open')
                         ->where('company_id', $company_id)->get();

            $interviews_today = Interview::where('company_id', $company_id)->where('is_qualified', 0)->whereDate('interview_date', date('Y-m-d'))
                ->orderBy('interview_date', 'ASC')
                ->get();


            $interviews_tomorrow = Interview::where('company_id', $company_id)->where('is_qualified', 0)->whereDate('interview_date', $tomorrow)
                ->orderBy('interview_date', 'ASC')
                ->get();

            if ($day_of_week != 6) {
                $interviews_this_week = Interview::where('company_id', $company_id)->where('is_qualified', 0)->whereBetween('interview_date', [$tomorrow, $end_of_week])
                    ->orderBy('interview_date', 'ASC')
                    ->get();
            }

            $interviews_later = Interview::where('company_id', $company_id)->where('is_qualified', 0)->whereDate('interview_date', '>=', $end_of_week)
                ->orderBy('interview_date', 'ASC')
                ->limit(5)
                ->get();

        }





		return view('admin.pages.hr.recruitment', compact(
			'interviews',
			'divisions',
			'positions',
			'interviews_today',
			'interviews_tomorrow',
			'interviews_this_week',
			'interviews_later'
		));
	}

	/**
	 * Contract/Onboarding page
	 *
	 * @return View
	 */
	public function contractOnboarding($id = 0,$planid=0, Request $request)
	{
        $interviews_this_week = [];
        $day_of_week = date('N');
        $end_of_week = date('Y-m-d', strtotime('next Sunday'));
        $tomorrow = date('Y-m-d', strtotime('+1 day'));
        $company_id =  \Illuminate\Support\Facades\Auth::user()->company_id ? Auth::user()->company_id : 0;
        if (\Illuminate\Support\Facades\Auth::user()->hasRole('itfpobadmin')) {
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

            $interviews = Interview::where('company_id', $company_id)->orderBy('interview_date', 'ASC')->get();
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

        $position_id = $id;
        $plan_id = $planid;
        if($id>0){
            $position = PositionManagement::where('id', $id)->first();
            $data = array(
                'position_id' => $id,
                'position'=>$position,
                'plan_id' =>$planid,

            );
        }else{
            abort(404);
        }

		return view('admin.pages.hr.contract_onboarding', compact(
			'interviews',
			'interviews_today',
			'interviews_tomorrow',
			'interviews_this_week',
			'interviews_later','position_id','plan_id','data'

		));
	}

    public function contract_onboarding_filter(Request $request)
    {
        $candidates_data = array();
        $candidates = Candidate::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $position_id = $request->input('position_id');
        $plan_id = $request->input('plan_id');
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
            //18 sep,2019 logic change, now show who accept offers
            //$candidates->where('is_contract',1);
            $candidates->where('offer_accepted',1);
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
            $candidates_data[$count][] = $candidate->id;
            $candidates_data[$count][] = $candidate->reference_no;
            $candidates_data[$count][] = $candidate->name." ".$candidate->last_name;
            $candidates_data[$count][] = $candidate->nationality;
            $candidates_data[$count][] = $candidate->location;
            $candidates_data[$count][] = $candidate->gender;
            $candidates_data[$count][] = $candidate->age;
            $candidates_data[$count][] = findEducation($candidate->education_level);
						$candidates_data[$count][] = $candidate->is_interviewed;
						$candidates_data[$count][] = $candidate->is_offered;
						$candidates_data[$count][] = $candidate->is_contract;
						$candidates_data[$count][] = $candidate->is_enrolled;
            $candidates_data[$count][] =  "";
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
