<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class InsuranceController extends Controller
{
	/**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{
		return view('admin.pages.hr.insurance.list');
	}

	/**
	 * Create page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
		return view('admin.pages.hr.insurance.create');
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail()
	{
		return view('admin.pages.hr.insurance.detail');
	}

	/**
	 * Update page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update()
	{
		return view('admin.pages.hr.insurance.update');
	}
}
