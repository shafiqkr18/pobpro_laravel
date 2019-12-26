<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;

use App\Division;
use App\DepartmentManagement;
use App\Section;
use App\PositionManagement;
use App\Employee;

class AddressBookController extends Controller
{
	/**
	 * Index/List page
	 *
	 * @return View
	 */
	public function list(Request $request)
	{

		$tree = [];
		$company_id = Auth::user()->company_id;

		$divisions = Division::where('deleted_at', null)
												->whereHas('organization', function (Builder $query) use ($company_id) {
													$query->where('company_id', $company_id);
												})
												->get();

		foreach ($divisions as $division) {

			$_division = [
				'text' => $division->short_name . '<small class="ml-2 text-muted">(' . count($division->accepted_candidates) . ')</small>',
				'id' => 'div_id-' . $division->id,
				'children' => [],
				'state' => [
					'opened' => false
				],
				'children' => []
			];

			if ($division->departments) {
				$_departments = [];

				foreach ($division->departments as $department) {
					$_dept = [
						'text' => $department->department_short_name . '<small class="ml-2 text-muted">(' . count($department->accepted_candidates) . ')</small>',
						'id' => 'dept_id-' . $department->id,
						'children' => []
					];

					if ($department->sections) {
						$_sections = [];

						foreach ($department->sections as $section) {
							$_sec = [
								'text' => $section->short_name . '<small class="ml-2 text-muted">(' . count($section->accepted_candidates) . ')</small>',
								'id' => 'section_id-' . $section->id,
								'children' => []
							];
							$section_count = 0;

							if ($section->positions) {
								$_positions = [];
								$section_count += $section->positions->count();

								foreach ($section->positions as $position) {
									$_pos = [
										'text' => $position->title . '<small class="ml-2 text-muted">(' . count($position->accepted_candidates) . ')</small>',
										'id' => 'position_id-' . $position->id
									];

									array_push($_positions, $_pos);
								}

								$_sec['children'] = $_positions;
							}

							array_push($_sections, $_sec);
						}

						$_dept['children'] = $_sections;
					}

					array_push($_departments, $_dept);
				}

				$_division['children'] = $_departments;
			}

			// get positions directly from division
			if ($division->positions) {
				// $_positions = [];

				foreach ($division->positions as $position) {
					if (!$position->department_id && !$position->section_id) {
						$_pos = [
							'text' => $position->title . '<small class="ml-2 text-muted">(' . count($position->accepted_candidates) . ')</small>',
							'id' => 'position_id-' . $position->id
						];

						// array_push($_positions, $_pos);
						array_push($_division['children'], $_pos);
					}
				}

				// $_division['children'] = $_positions;
			}

			array_push($tree, $_division);
		}

		return view('admin.pages.hr.address_book.list', compact(
			'tree'
		));
	}

	/**
	 * Get employees.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function employees_filter(Request $request)
	{
		$employees_data = array();
		$employees = Candidate::select("*");
		$employees->where('deleted_at', null)->where('offer_accepted',1);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if ($request->input('type')) {
			$type = str_replace('_anchor', '', $request->input('type'));
			$params = explode('-', $type);
			$employees->where($params[0], $params[1]);
		}



		if($search) {
			$is_filter = true;
			$employees->where('name','like', '%'.$request->get('search')['value'].'%');
		}

		if (!Auth::user()->hasRole('itfpobadmin')) {
				$employees->where('company_id', Auth::user()->company_id);
				$is_filter = true;
		}

		if($is_filter) {
			$total_employees = count($employees->get());
			$employees = $employees->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
			$employees = Candidate::all();
			$total_employees = count($employees);
			if ($request->input('type')) {
				$type = str_replace('_anchor', '', $request->input('type'));
				$params = explode('-', $type);
				$employees = Candidate::where($params[0], $params[1])->where('offer_accepted',1)->where('company_id', Auth::user()->company_id)->where('deleted_at', null)->orderBy('id', 'desc')->get();
			}
			else {
				$employees = Candidate::where('deleted_at', null)->where('offer_accepted',1)->where('company_id', Auth::user()->company_id)->orderBy('id', 'desc')->get();
			}

		}

		$count = 0;
		foreach ($employees as $employee) {
			$employees_data[$count][] = $employee->reference_no;
			$employees_data[$count][] = $employee->badge_id;
			$employees_data[$count][] = $employee->name." ".$employee->last_name;
			$employees_data[$count][] = $employee->email;
			$employees_data[$count][] = $employee->mobile_number;
			$employees_data[$count][] = $employee->nationality;
			$employees_data[$count][] = $employee->department ? $employee->department->department_short_name: '';
			$employees_data[$count][] = $employee->position ? $employee->position->title : '';
			$employees_data[$count][] = $employee->id;
			$employees_data[$count][] = '';
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_employees,
			'recordsFiltered' => $total_employees,
			'data' 						=> $employees_data
		);
		return json_encode($data);
	}

	/**
	 * Get details
	 *
	 * @return View
	 */
	public function detail($id, $modal = 0)
	{
		$employee = Candidate::findOrFail($id);
		$modal_size = 'modal-lg xl address-book-detail';
		$hide_header = 1;

		return view('admin.pages.address_book.detail', compact(
			'employee',
			'modal',
			'modal_size',
			'hide_header'
		));
	}

}
