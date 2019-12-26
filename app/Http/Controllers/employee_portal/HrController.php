<?php

namespace App\Http\Controllers\employee_portal;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

use App\PassportManagement;
use App\Question;
use App\QuestionCategory;
use App\Offer;

class HrController extends Controller
{
  /**
	* My Profile page
	*
	* @return View
	*/
	public function profile()
	{
		$user = Auth::user();
		$employee = $user && $user->employee ? $user->employee : null;
		$candidate = $user && $user->candidate ? $user->candidate : null;

		return view('employee_portal.pages.hr.profile.detail', compact(
			'user',
			'employee',
			'candidate'
		));
	}

	/**
	* Update profile page
	*
	* @return View
	*/
	public function updateProfile()
	{
		$user = Auth::user();
		$employee = $user && $user->employee ? $user->employee : null;
		$candidate = $user && $user->candidate ? $user->candidate : null;

		return view('employee_portal.pages.hr.profile.update', compact(
			'user',
			'employee',
			'candidate'
		));
	}

	/**
	* Q & A page
	*
	* @return View
	*/
	public function questions()
	{
		$user = Auth::user();
		$employee = $user && $user->employee ? $user->employee : null;
		$company_id = $employee->company_id ? $employee->company_id : $user->company_id;

		$questions = Question::where('company_id', $company_id)
												->where('created_by', $user->id)
												// ->orWhere(function ($query) use ($company_id) {
												// 	$query->where('question_type', 'public')
												// 				->where('company_id', $company_id);
												// })
												->orderBy('created_at', 'DESC')
												->get();
		$categories = QuestionCategory::all();
		$faqs = Question::where('company_id', $company_id)
										->where('created_by', '!=', $user->id)
										// ->whereHas('createdBy', function ($query) use ($company_id) {
										// 	$query->whereHas('roles', function ($q) {
										// 		$q->where('id', '!=', 8);
										// 	});
										// })
										->where('question_type', 'public')
										->orderBy('created_at', 'DESC')
										->get();

		return view('employee_portal.pages.hr.questions.index', compact(
			'user',
			'employee',
			'questions',
			'categories',
			'faqs'
		));
	}

	/**
	* My Passport page
	*
	* @return View
	*/
	public function passport()
	{
		$user = Auth::user();
		$employee = $user && $user->employee ? $user->employee : null;
		$primary_passport = $user->primaryPassport ? $user->primaryPassport : null;

		return view('employee_portal.pages.hr.passport.index', compact(
			'user',
			'primary_passport',
			'employee'
		));
	}

	/**
	* Create Passport page
	*
	* @return View
	*/
	public function createPassport()
	{
		return view('employee_portal.pages.hr.passport.create');
	}

	/**
	* Update Passport page
	*
	* @return View
	*/
	public function updatePassport($id)
	{
		$user = Auth::user();
		$employee = $user && $user->employee ? $user->employee : null;
		$passport = PassportManagement::findOrFail($id);

		return view('employee_portal.pages.hr.passport.update', compact(
			'user',
			'passport',
			'employee'
		));
	}

	/**
	* My Offers page
	*
	* @return View
	*/
	public function offers()
	{
		$user = Auth::user();
		$candidate = $user->candidate ? $user->candidate : null;

		return view('employee_portal.pages.hr.offers.index', compact(
			'candidate'
		));
	}

}
