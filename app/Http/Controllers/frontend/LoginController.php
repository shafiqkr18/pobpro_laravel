<?php

namespace App\Http\Controllers\frontend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class LoginController extends Controller
{
  /**
	 * Login page
	 *
	 * @return View
	 */
	public function login()
	{
		return view('frontend.pages.login');
	}
}
