<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\RotationType;
use App\Company;

class RotationTypeController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.settings.rotation_type.list');
	}

	/**
	 * Create page
	 *
	 * @return View
	 */
	public function create()
	{
		$companies = null;
		
		if (Auth::user()->hasRole('itfpobadmin')) {
			$companies = Company::where('deleted_at', null)->get();
		}

		return view('admin.pages.settings.rotation_type.create', compact(
			'companies'
		));
	}

	/**
	 * Update page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		$rotation = RotationType::findOrFail($id);
		$companies = null;
		
		if (Auth::user()->hasRole('itfpobadmin')) {
			$companies = Company::where('deleted_at', null)->get();
		}

		return view('admin.pages.settings.rotation_type.update', compact(
			'rotation',
			'companies'
		));
	}

	/**
	 * Get rotation_types.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function rotations_filter(Request $request)
	{
		$rotation_types_data = array();
		$rotation_types = RotationType::select("*");
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$rotation_types->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		$company_id = Auth::user()->company_id;
		if (!Auth::user()->hasRole('itfpobadmin'))
		{
			$rotation_types->where('company_id', $company_id);
			$is_filter = true;
		}

		if($is_filter) {
			$rotation_types->where('deleted_at', null);
			$total_rotation_types = count($rotation_types->get());
			$rotation_types = $rotation_types->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
			$rotation_types = RotationType::all();
			$total_rotation_types = count($rotation_types);
			$rotation_types = RotationType::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}

		$count = 0;
		foreach ($rotation_types as $rotation_type) {
			$rotation_types_data[$count][] = $rotation_type->id;
			$rotation_types_data[$count][] = $rotation_type->title;
			$rotation_types_data[$count][] = $rotation_type->company ? $rotation_type->company->company_name : '';
			$rotation_types_data[$count][] = $rotation_type->createdBy ? $rotation_type->createdBy->name . ' ' . $rotation_type->createdBy->last_name : '';
			$rotation_types_data[$count][] = date('Y-m-d', strtotime($rotation_type->created_at));
			$rotation_types_data[$count][] = "";
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_rotation_types,
			'recordsFiltered' => $total_rotation_types,
			'data' 						=> $rotation_types_data
		);
		return json_encode($data);
	}

}
