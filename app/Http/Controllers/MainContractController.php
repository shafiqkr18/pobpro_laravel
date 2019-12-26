<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MainContractController extends Controller
{
  /**
	* Index/List page
	*
	* @return View
	*/
	public function index()
	{
		return view('admin.pages.management.main-contract');
	}
}
