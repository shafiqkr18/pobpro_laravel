<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Travel;

class TravelController extends Controller
{
	/**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.administration.travel.list');
	}

	/**
	 * Get travel requests.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function travel_filter(Request $request)
	{
		$travels_data = array();
		$travels = Travel::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$travels->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		if($is_filter) {
			$total_travels = count($travels->get());
			$travels = $travels->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$travels = Travel::all();
				$total_travels = count($travels);
				$travels = Travel::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($travels as $travel) {
			$travels_data[$count][] = $travel->name_on_passport;
			$travels_data[$count][] = $travel->position->title;
			$travels_data[$count][] = $travel->department->department_short_name;
			$travels_data[$count][] = date('Y-m-d', strtotime($travel->application_date));
			$travels_data[$count][] = $travel->class;
			$travels_data[$count][] = $travel->hotel;
			$travels_data[$count][] = date('Y-m-d', strtotime($travel->departure_date));
			$travels_data[$count][] = date('Y-m-d', strtotime($travel->return_date));
			$travels_data[$count][] = "";
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_travels,
			'recordsFiltered' => $total_travels,
			'data' 						=> $travels_data
		);
		return json_encode($data);
	}

}
