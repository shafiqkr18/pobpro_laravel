<?php

namespace App\Http\Controllers\employee_portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
  /**
	* Index/Dashboard page
	*
	* @return View
	*/
	public function index()
	{
		return view('employee_portal.pages.index');
	}

	/**
	* Timesheet page
	*
	* @return View
	*/
	public function timesheet()
	{
		return view('employee_portal.pages.timesheet');
	}

	/**
	* Handover page
	*
	* @return View
	*/
	public function handover()
	{
		return view('employee_portal.pages.handover');
	}

	/**
	* Training page
	*
	* @return View
	*/
	public function training()
	{
		return view('employee_portal.pages.training');
	}

	/**
	* My Travel page
	*
	* @return View
	*/
	public function myTravel()
	{
		return view('employee_portal.pages.my_travel');
	}

	/**
	* My Visa page
	*
	* @return View
	*/
	public function myVisa()
	{
		return view('employee_portal.pages.my_visa');
	}

	/**
	* Visa Request page
	*
	* @return View
	*/
	public function visaRequest()
	{
		return view('employee_portal.pages.visa_request');
	}

	/**
	* Create Ticket page
	*
	* @return View
	*/
	public function createTicket()
	{
		return view('employee_portal.pages.create_ticket');
	}

	/**
	* My Accommodation page
	*
	* @return View
	*/
	public function myAccommodation()
	{
		return view('employee_portal.pages.my_accommodation');
	}

	/**
	* Dining Card Request page
	*
	* @return View
	*/
	public function diningCardRequest()
	{
		return view('employee_portal.pages.dining_card_request');
	}

	/**
	* Accommodation Form page
	*
	* @return View
	*/
	public function accommodationForm()
	{
		return view('employee_portal.pages.accommodation_form');
	}

	/**
	* PPE Management page
	*
	* @return View
	*/
	public function ppeManagement()
	{
		return view('employee_portal.pages.ppe_management');
	}

	/**
	* Certification & Training page
	*
	* @return View
	*/
	public function certificationAndTraining()
	{
		return view('employee_portal.pages.certification_and_training');
	}

	/**
	* PPE Form page
	*
	* @return View
	*/
	public function ppeForm()
	{
		return view('employee_portal.pages.ppe_form');
	}

	/**
	* Daily POB Submit page
	*
	* @return View
	*/
	public function dailyPobSubmit()
	{
		return view('employee_portal.pages.daily_pob_submit');
	}

	/**
	* Access Application page
	*
	* @return View
	*/
	public function accessApplication()
	{
		return view('employee_portal.pages.access_application');
	}

	/**
	* Access Application Form page
	*
	* @return View
	*/
	public function accessApplicationForm()
	{
		return view('employee_portal.pages.access_application_form');
	}

	/**
	* IT Systems page
	*
	* @return View
	*/
	public function itSystems()
	{
		return view('employee_portal.pages.it_systems');
	}

	/**
	* Cash Advance page
	*
	* @return View
	*/
	public function cashAdvance()
	{
		return view('employee_portal.pages.cash_advance');
	}

	/**
	* Cash Advance form page
	*
	* @return View
	*/
	public function cashAdvanceForm()
	{
		return view('employee_portal.pages.cash_advance_form');
	}

	/**
	* Reimbursement page
	*
	* @return View
	*/
	public function reimbursement()
	{
		return view('employee_portal.pages.reimbursement');
	}

	/**
	* Reimbursement form page
	*
	* @return View
	*/
	public function reimbursementForm()
	{
		return view('employee_portal.pages.reimbursement_form');
	}

	/**
	* My Profile page
	*
	* @return View
	*/
	public function myProfile()
	{
		return view('employee_portal.pages.my_profile');
	}

	/**
	* My Jobs page
	*
	* @return View
	*/
	public function myJobs()
	{
		return view('employee_portal.pages.my_jobs');
	}

	/**
	* My Offers page
	*
	* @return View
	*/
	public function myOffers()
	{
		return view('employee_portal.pages.my_offers');
	}

	/**
	* FAQ page
	*
	* @return View
	*/
	public function faq()
	{
		return view('employee_portal.pages.faq');
	}

	/**
	* Detail page
	*
	* @return View
	*/
	public function detail()
	{
		return view('employee_portal.pages.detail');
	}

	/**
	* My Rotation page
	*
	* @return View
	*/
	public function myRotation()
	{
		return view('employee_portal.pages.my_rotation');
	}

}
