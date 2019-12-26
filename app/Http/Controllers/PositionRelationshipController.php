<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use App\Division;
use App\DepartmentManagement;
use App\ExDepartment;
use App\ExPosition;
use App\PositionRelationship;

class PositionRelationshipController extends Controller
{
	
	/**
	*  Index page
	*
	* @return View
	*/
	public function index()
	{
		$company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
		$divisions = Division::where('deleted_at', null)
												->whereHas('organization', function (Builder $query) use ($company_id) {
													$query->where('company_id', $company_id);
												})
												->get();

		return view('admin.pages.hr.position_relationship.index', compact(
			'divisions'
		));
	}

	/**
	*  Settings page
	*
	* @return View
	*/
	public function settings($id = null)
	{
		$company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;

		$divisions = Division::where('deleted_at', null)
												->whereHas('organization', function (Builder $query) use ($company_id) {
													$query->where('company_id', $company_id);
												})
												->get();
		
		$ex_departments = ExDepartment::where('deleted_at', null)
																	->where('company_id', $company_id)
																	->get();

		$active_division = null;
		$department = null;
		if ($id) {
			$department = DepartmentManagement::findOrFail($id);
			$active_division = $department->division;
		}

		return view('admin.pages.hr.position_relationship.settings', compact(
			'divisions',
			'department',
			'active_division',
			'ex_departments',
			'ex_positions_moved'
		));
	}

	/**
	*  Get departments
	*
	* @return \Illuminate\Http\Response
	*/
	public function getDepartments($id)
	{
		// $division = Division::findOrFail($id);
		$departments = DepartmentManagement::where('div_id', $id)
																			->where('deleted_at', null)
																			->get();

		return response()->json([
			'success' => true,
			'departments' => $departments
		]);
	}

	/**
	*  Get department positions
	*
	* @return \Illuminate\Http\Response
	*/
	public function getDepartmentPositions($id)
	{
		$department = DepartmentManagement::findOrFail($id);

		return response()->json([
			'success' => true,
			'department' => $department
		]);
	}

	/**
	*  Save relations
	*
	* @return \Illuminate\Http\Response
	*/
	public function save(Request $request)
	{
		$success = false;
		$message = '';

		try {
			if($request->input('ex_position_id')) {
				foreach ($request->input('ex_position_id') as $ex_position_id) {
					$ex_position = ExPosition::find($ex_position_id);
					$ex_department_id = $ex_position->department ? $ex_position->department->id : 0;

					$relationship = new PositionRelationship();
					$relationship->div_id = $request->input('div_id');
					$relationship->dept_id = $request->input('dept_id');
					$relationship->position_id = $request->input('position_id');
					$relationship->ex_dept_id = $ex_department_id;
					$relationship->ex_position_id = $ex_position->id;
					$relationship->company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
					$relationship->created_by = Auth::user()->id;
					$relationship->created_at = date('Y-m-d H:i:s');
					if ($relationship->save()) {
						$success = true;
						$message = 'Positions moved.';
					}
				}
			}			

		} 
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'request' => $request->all()
		]);

	}

	/**
	*  Delete relation
	*
	* @return \Illuminate\Http\Response
	*/
	public function delete($id)
	{
		$success = false;
		$message = '';
		$position_relationship_count = 0;

		try {
			$relationship = PositionRelationship::find($id);
			$relationship->deleted_at = date('Y-m-d H:i:s');
			if ($relationship->save()) {
				$success = true;
				$message = 'Position removed.';

				if ($relationship->position) {
					$position = $relationship->position;
					$position_relationship_count = count($position->positionRelationships);
				}
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'ex_pos' => 'pos_' . $relationship->ex_position_id,
			'position_relationship_count' => $position_relationship_count
		]);
	}

}
