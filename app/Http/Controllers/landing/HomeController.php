<?php

namespace App\Http\Controllers\landing;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{
  /**
	* Home page
	*
	* @return View
	*/
	public function index()
	{
		return view('landing.home');
	}
}
