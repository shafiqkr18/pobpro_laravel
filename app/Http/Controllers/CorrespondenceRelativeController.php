<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CorrespondenceRelativeController extends Controller
{
	/**
	* List page
	*
	* @return View
	*/
	public function list()
	{

		return view('admin.pages.correspondence.relative.list');
	}

}
