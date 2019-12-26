<?php

namespace App\Http\Controllers;

use App\Activities;
use App\Interview;
use App\Meeting;
use App\Offer;
use App\Plan;
use App\PlanPosition;
use App\Topic;
use App\Vacancy;
use App\DepartmentApproval;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

	/**
	 * Dashboard home page
	 *
	 * @return View
	 */
	public function index(Request $request)
	{
		$show_welcome_message = !$request->session()->has('initial_login');

		if ($show_welcome_message) {
			$request->session()->put('initial_login', 1);
		}

        $user = Auth::user();
        $roles = $user->roles->pluck('name');
        if (Auth::user()->hasRole('itfpobadmin')) {
            $offers = Offer::where('deleted_at', null)->get();
            $plans =  Plan::where('is_approved',0)->where('deleted_at', null)->get();
		}
		else {
            $offers = Offer::where('deleted_at', null)->where('company_id',Auth::user()->company_id)->get();
            $plans =  Plan::where('is_approved',0)->where('deleted_at', null)->where('company_id',Auth::user()->company_id)->get();
        }

		if (!$plans) {
			$plans = [];
		}
        $myOffers = Offer::where('type', 0)->where('deleted_at', null)
            ->where('gm_approved', 1)->where('sending_status',0)
            ->where('created_by',Auth::user()->id)->get();
		$offIds = array();
        $myInt  = array();
		foreach ($myOffers as $myOff)
        {
            array_push($offIds,$myOff->id);
        }
		$activities = Activities::where('company_id',Auth::user()->company_id)
                    ->where('type','offers')->whereIn('listing_id',$offIds)
                    ->orderBy('id', 'DESC')->skip(0)->take(10)->get();
        $activities = $activities ? $activities : [];

         $intLst = Interview::where('created_by',Auth::user()->id)->where('company_id',Auth::user()->company_id)
                    ->where('is_confirmed',1)
                    ->orWhereHas('attendees', function ($query) {
                        $query->where('interviewer_id', Auth::user()->id);
                    })->get();
        foreach ($intLst as $intLs)
        {
            array_push($myInt,$intLs->id);
        }

        $activities_interviews = Activities::where('company_id',Auth::user()->company_id)
            ->where('type','interviews')->whereIn('listing_id',$myInt)
            ->orderBy('id', 'DESC')->skip(0)->take(10)->get();
        $activities_interviews = $activities_interviews ? $activities_interviews : [];

        //get feeds if JD not updated
         $jd_missing = Plan::with('positions')
            ->doesnthave('vacancies')
            ->where('created_by', Auth::user()->id)
            ->get();


		$requested_sections = [];
		$requested_positions = [];

		if (Auth::user()->department) {
			$department = Auth::user()->department;
			$requested_sections = $department->requestedSections;
			$requested_positions = $department->requestedPositions;
		}

		$company_id = Auth::user()->company_id;
		$department_approvals = null;

		if (Auth::user()->hasRole('HRM') || Auth::user()->hasRole('HR')) {
			$department_approvals = Auth::user()->company && Auth::user()->company->departmentApprovals ? Auth::user()->company->departmentApprovals : null;
		}

		$total_positions = Auth::user()->company->getPositionsCountDirect();
		$total_assigned_positions = Auth::user()->company->getFilledPositionsCountDirect();
		$total_vacant_positions = $total_positions - $total_assigned_positions;
		$local_positions = Auth::user()->company->localPositionsCount();
		$local_assigned_positions = Auth::user()->company->localAcceptedOffers->count();
		$local_vacant_positions = $local_positions - $local_assigned_positions;
		$expat_positions = Auth::user()->company->expatPositionsCount();
		$expat_assigned_positions = Auth::user()->company->expatAcceptedOffers->count();
		$expat_vacant_positions = $expat_positions - $expat_assigned_positions;

		return view('admin.pages.index',compact(
			'offers','user','plans', 'show_welcome_message','activities','activities_interviews','jd_missing', 'requested_sections', 'requested_positions', 'total_positions', 'total_assigned_positions', 'total_vacant_positions', 'local_positions', 'local_assigned_positions', 'local_vacant_positions', 'expat_positions', 'expat_assigned_positions', 'expat_vacant_positions', 'department_approvals'
        ));
	}


	/**
	 * Minutes of Meeting page
	 *
	 * @return View
	 */
	public function minutesOfMeeting()
	{
	    $meetings = Meeting::whereNull('deleted_at')->where('company_id',Auth::user()->company_id)->get();
        $topics = Topic::where('company_id', Auth::user()->company_id)->get();
$users = Auth::user()->company ? Auth::user()->company->company_users : null;

		return view('admin.pages.minutes-of-meeting',
        compact(
            'meetings','topics','users'
        ));
	}

	/**
	 * Minutes of Meeting details page
	 *
	 * @return View
	 */
	public function meetingDetails()
	{
		return view('admin.pages.mom-details');
	}


}
