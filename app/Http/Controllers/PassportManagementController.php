<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\User;
use App\PassportManagement;

class PassportManagementController extends Controller
{
  /**
	 * Index/List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.passport.list');
	}

	/**
	 * Update page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		$passport = PassportManagement::findOrFail($id);
		$users = User::all();

		return view('admin.pages.passport.update', compact(
			'passport',
			'users'
		));
	}

	/**
	 * Delete passport.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
			$passport = PassportManagement::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($passport) {
					$success = false;
					$msg = 'An error occured.';
					$passport->deleted_at = date('Y-m-d H:i:s');

					if ($passport->save()) {
							$success = true;
							$msg = 'Passport deleted.';
					}

					return response()->json([
							'success' => $success,
							'passport_id' => $passport->id,
							'msg' => $msg,
							'type' => $type,
							'view' => $view,
							'return_url' => url('admin/passport-management')
					]);
			}
	}

	/**
	 * Get passport list
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function passport_filter(Request $request)
	{
		$passports_data = array();
		$passports = PassportManagement::select("*")->where('deleted_at', null);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$passports->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		if (!Auth::user()->hasRole('itfpobadmin')) {
			$passports->where('company_id', Auth::user()->company_id);
			$is_filter = true;
		}

		if($is_filter) {
			$total_passports = count($passports->get());
			$passports = $passports->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		} 
		else {
			$passports = PassportManagement::all();
			$total_passports = count($passports);
			$passports = PassportManagement::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($passports as $passport) {
			$passports_data[$count][] = $passport->passport_number;
			$passports_data[$count][] = $passport->user ? $passport->user : '';
			$passports_data[$count][] = $passport->is_primary;
			$passports_data[$count][] = date('Y-m-d', strtotime($passport->issue_date));
			$passports_data[$count][] = date('Y-m-d', strtotime($passport->expiry_date));
			$passports_data[$count][] = $passport->id;
			$count++;
		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_passports,
			'recordsFiltered' => $total_passports,
			'data' => $passports_data
		);

		return json_encode($data);
	}

}
