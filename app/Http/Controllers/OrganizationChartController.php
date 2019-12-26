<?php

namespace App\Http\Controllers;

use App\Division;
use App\User;
use App\DepartmentManagement;
use App\Section;
use App\PositionManagement;
use App\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Builder;
use URL;

class OrganizationChartController extends Controller
{
  /**
	 * Index page
	 *
	 * @return View
	 */
	public function index()
	{
		$all_users = User::all();
		$user_id = Auth::user()->id;
		$divisions = Division::all();
		$data = array(
			'all_users' => $all_users,
			'user_id' =>$user_id,
			'divisions'=>$divisions
		);

		return view('admin.pages.planning.organization-chart')->with('data', $data);
	}

	/**
	 * Company view page
	 *
	 * @return View
	 */
	public function companyView()
	{
		$tree = [];
		$company_id = Auth::user()->company_id;

		if (Auth::user()->hasRole('itfpobadmin')) {
			$divisions = Division::all();
			$departments = DepartmentManagement::all();
		}
		else {
			$divisions = Division::where('deleted_at', null)
													->whereHas('organization', function (Builder $query) use ($company_id) {
														$query->where('company_id', $company_id);
													})
													->get();
			$departments = DepartmentManagement::where('deleted_at', null)
																				->whereHas('organization', function (Builder $query) use ($company_id) {
																					$query->where('company_id', $company_id);
																				})
																				->get();
		}

		foreach ($divisions as $division) {

			// $_division = [
			// 	'text' => $division->short_name . '<small class="ml-2 text-muted">(' . $division->employees->count() . ')</small>',
			// 	'id' => 'div_id-' . $division->id,
			// 	'children' => [],
			// 	'state' => [
			// 		'opened' => false
			// 	]
			// ];

			if ($division->departments) {
				$_departments = [];

				foreach ($division->departments as $department) {
					$_dept = [
						'text' => $department->department_short_name . '<small class="ml-2 text-warning">(' . $department->employees->count() . ')</small>',
						'id' => $department->id,
						'children' => []
					];

					if ($department->sections) {
						$_sections = [];

						foreach ($department->sections as $section) {
							$_sec = [
								'text' => $section->short_name . ($section->getPositionsCount() > 0 ? '<small class="ml-2 text-warning">(' . $section->getFilledPositionsCount() . '/' . $section->getPositionsCount() . ')</small>' : ''),
								'id' => 'sec_id-' . $section->id,
								'children' => [],
								'state' =>array('opened'=>true)
							];
							$section_count = 0;

							if ($section->positions) {
								$_positions = [];
								$section_count += $section->positions->count();

								foreach ($section->positions as $position) {
									$_pos = [
										'text' => $position->title . ($position->total_positions > 0 ? '<small class="ml-2 text-warning">(' . (count($position->offers->where('accepted', 1)) ) . '/' . ($position->total_positions ? $position->total_positions : '0') . ')</small>' : ''),
										'id' => 'position_id-' . $position->id,
										'state' => array('opened' => true)
									];

									if (count($position->offers) > 0) {
										$_offers = [];

										foreach ($position->offers as $offer) {

											if ($offer->accepted == 1) {
												$_offer = [
													'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . '" srcset="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . ' 1x, ' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span class="candidate-name" title="' . ($offer->candidate->name ? $offer->candidate->name : '') . ' ' . ($offer->candidate->last_name ? $offer->candidate->last_name : '') . '">' . ($offer->candidate->name ? $offer->candidate->name : '') . '</span>' . ' ' . '<img src="' . URL::asset('img/icon-rotation-type.png') . '" srcset="' . URL::asset('img/icon-rotation-type.png') . ' 1x, ' . URL::asset('img/icon-rotation-type@2x.png') . ' 2x" class="img-fluid pl-1 pr-1 mr-1 ml-1">' . ' <span class="rotation-type-value">' . ($offer->rotationType ? $offer->rotationType->title : '') . '</span></div>',
													'id' => 'offer_id-' . $offer->id,
													'a_attr' => [
														'class' => 'no-hover'
													]
												];

												array_push($_offers, $_offer);
											}
										}

										$_pos['children'] = $_offers;
									}

									array_push($_positions, $_pos);
								}

								$_sec['children'] = $_positions;
							}

							array_push($_sections, $_sec);
						}

						$_dept['children'] = $_sections;
					}

					array_push($tree, $_dept);
				}

				// $_division['children'] = $_departments;
			}

			// array_push($tree, $_division);

			// get positions direct from division (without departments)
			if ($division->positions) {
				$_dept = [
					'text' => 'dept',
					'id' => $division->id,
					'children' => []
				];

				$_positions = [];

				foreach ($division->positions as $position) {
					$_pos = [
						'text' => $position->title . ($position->total_positions > 0 ? '<small class="ml-2 text-warning">(' . (count($position->offers->where('accepted', 1)) ) . '/' . ($position->total_positions ? $position->total_positions : '0') . ')</small>' : ''),
						'id' => 'position_id-' . $position->id,
						'state' => array('opened'=>true)
					];

					if (count($position->offers) > 0) {
						$_offers = [];

						foreach ($position->offers as $offer) {

							if ($offer->accepted == 1) {
								$_offer = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . '" srcset="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . ' 1x, ' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span class="candidate-name" title="' . ($offer->candidate->name ? $offer->candidate->name : '') . ' ' . ($offer->candidate->last_name ? $offer->candidate->last_name : '') . '">' . ($offer->candidate->name ? $offer->candidate->name : '') . '</span>' . ' ' . '<img src="' . URL::asset('img/icon-rotation-type.png') . '" srcset="' . URL::asset('img/icon-rotation-type.png') . ' 1x, ' . URL::asset('img/icon-rotation-type@2x.png') . ' 2x" class="img-fluid pl-1 pr-1 mr-1 ml-1">' . ' <span class="rotation-type-value">' . ($offer->rotationType ? $offer->rotationType->title : '') . '</span></div>',
									'id' => 'offer_id-' . $offer->id,
									'a_attr' => [
										'class' => 'no-hover'
									]
								];

								array_push($_offers, $_offer);
							}
						}

						$_pos['children'] = $_offers;
					}

					array_push($_dept['children'], $_pos);
				}

				array_push($tree, $_dept);
			}
			
		}

		// get positions direct from company 
		if (Auth::user()->company->positions) {
			$_dept = [
				'text' => 'dept',
				'id' => Auth::user()->company->id,
				'children' => []
			];

			$_positions = [];

			foreach (Auth::user()->company->positions as $position) {
				if (!$position->div_id && !$position->department_id && !$position->section_id) {
					$_pos = [
						'text' => $position->title . ($position->total_positions > 0 ? '<small class="ml-2 text-warning">(' . (count($position->offers->where('accepted', 1)) ) . '/' . ($position->total_positions ? $position->total_positions : '0') . ')</small>' : ''),
						'id' => 'position_id-' . $position->id,
						'state' => array('opened'=>true)
					];

					if (count($position->offers) > 0) {
						$_offers = [];

						foreach ($position->offers as $offer) {

							if ($offer->accepted == 1) {
								$_offer = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . '" srcset="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . ' 1x, ' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span class="candidate-name" title="' . ($offer->candidate->name ? $offer->candidate->name : '') . ' ' . ($offer->candidate->last_name ? $offer->candidate->last_name : '') . '">' . ($offer->candidate->name ? $offer->candidate->name : '') . '</span>' . ' ' . '<img src="' . URL::asset('img/icon-rotation-type.png') . '" srcset="' . URL::asset('img/icon-rotation-type.png') . ' 1x, ' . URL::asset('img/icon-rotation-type@2x.png') . ' 2x" class="img-fluid pl-1 pr-1 mr-1 ml-1">' . ' <span class="rotation-type-value">' . ($offer->rotationType ? $offer->rotationType->title : '') . '</span></div>',
									'id' => 'offer_id-' . $offer->id,
									'a_attr' => [
										'class' => 'no-hover'
									]
								];

								array_push($_offers, $_offer);
							}
						}

						$_pos['children'] = $_offers;
					}

					array_push($_dept['children'], $_pos);
				}
			}

			array_push($tree, $_dept);
		}

		return view('admin.pages.planning.company_view', compact(
			'tree',
			'divisions',
			'departments'
		));
	}

	/**
	 * Division view page
	 *
	 * @return View
	 */
	public function divisionView($id)
	{
		$tree = [];
		$company_id = Auth::user()->company_id;

		if (Auth::user()->hasRole('itfpobadmin')) {
			$divisions = Division::all();
			$departments = DepartmentManagement::all();
		}
		else {
			$divisions = Division::where('deleted_at', null)
													->whereHas('organization', function (Builder $query) use ($company_id) {
														$query->where('company_id', $company_id);
													})
													->get();
			$departments = DepartmentManagement::where('deleted_at', null)
																				->whereHas('organization', function (Builder $query) use ($company_id) {
																					$query->where('company_id', $company_id);
																				})
																				->get();
		}

		$division = Division::findOrFail($id);

		if ($division) {

			if ($division->departments) {
				$_departments = [];

				foreach ($division->departments as $department) {
					$_dept = [
						'text' => $department->department_short_name . '<small class="ml-2 text-warning">(' . $department->employees->count() . ')</small>',
						'id' => $department->id,
						'children' => []
					];

					if ($department->sections) {
						$_sections = [];

						foreach ($department->sections as $section) {
							$_sec = [
								'text' => $section->short_name . ($section->getPositionsCount() > 0 ? '<small class="ml-2 text-warning">(' . $section->getFilledPositionsCount() . '/' . $section->getPositionsCount() . ')</small>' : ''),
								'id' => 'sec_id-' . $section->id,
								'children' => [],
                                'state' =>array('opened'=>true)
							];
							$section_count = 0;

							if ($section->positions) {
								$_positions = [];
								$section_count += $section->positions->count();

								foreach ($section->positions as $position) {
									$_pos = [
										'text' => $position->title . ($position->total_positions > 0 ? '<small class="ml-2 text-warning">(' . (count($position->offers->where('accepted', 1)) ) . '/' . ($position->total_positions ? $position->total_positions : '0') . ')</small>' : ''),
										'id' => 'position_id-' . $position->id,
										'state' =>array('opened'=>true)
									];

									if (count($position->offers) > 0) {
										$_offers = [];

										foreach ($position->offers as $offer) {

											if ($offer->accepted == 1) {
												$_offer = [
													'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . '" srcset="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . ' 1x, ' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span class="candidate-name" title="' . ($offer->candidate->name ? $offer->candidate->name : '') . ' ' . ($offer->candidate->last_name ? $offer->candidate->last_name : '') . '">' . ($offer->candidate->name ? $offer->candidate->name : '') . '</span>' . ' ' . '<img src="' . URL::asset('img/icon-rotation-type.png') . '" srcset="' . URL::asset('img/icon-rotation-type.png') . ' 1x, ' . URL::asset('img/icon-rotation-type@2x.png') . ' 2x" class="img-fluid pl-1 pr-1 mr-1 ml-1">' . ' <span class="rotation-type-value">' . ($offer->rotationType ? $offer->rotationType->title : '') . '</span></div>',
													'id' => 'offer_id-' . $offer->id,
													'a_attr' => [
														'class' => 'no-hover'
													]
												];

												array_push($_offers, $_offer);
											}
										}

										$_pos['children'] = $_offers;
									}

									array_push($_positions, $_pos);
								}

								$_sec['children'] = $_positions;
							}

							array_push($_sections, $_sec);
						}

						$_dept['children'] = $_sections;
					}

					array_push($tree, $_dept);
				}

				// $_division['children'] = $_departments;
			}

			// get positions direct from division (without departments)
			if ($division->positions) {
				$_dept = [
					'text' => 'dept',
					'id' => $division->id,
					'children' => []
				];

				$_positions = [];

				foreach ($division->positions as $position) {
					$_pos = [
						'text' => $position->title . ($position->total_positions > 0 ? '<small class="ml-2 text-warning">(' . (count($position->offers->where('accepted', 1)) ) . '/' . ($position->total_positions ? $position->total_positions : '0') . ')</small>' : ''),
						'id' => 'position_id-' . $position->id,
						'state' => array('opened'=>true)
					];

					if (count($position->offers) > 0) {
						$_offers = [];

						foreach ($position->offers as $offer) {

							if ($offer->accepted == 1) {
								$_offer = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . '" srcset="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . ' 1x, ' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span class="candidate-name" title="' . ($offer->candidate->name ? $offer->candidate->name : '') . ' ' . ($offer->candidate->last_name ? $offer->candidate->last_name : '') . '">' . ($offer->candidate->name ? $offer->candidate->name : '') . '</span>' . ' ' . '<img src="' . URL::asset('img/icon-rotation-type.png') . '" srcset="' . URL::asset('img/icon-rotation-type.png') . ' 1x, ' . URL::asset('img/icon-rotation-type@2x.png') . ' 2x" class="img-fluid pl-1 pr-1 mr-1 ml-1">' . ' <span class="rotation-type-value">' . ($offer->rotationType ? $offer->rotationType->title : '') . '</span></div>',
									'id' => 'offer_id-' . $offer->id,
									'a_attr' => [
										'class' => 'no-hover'
									]
								];

								array_push($_offers, $_offer);
							}
						}

						$_pos['children'] = $_offers;
					}

					array_push($_dept['children'], $_pos);
				}

				array_push($tree, $_dept);
			}

			// array_push($tree, $_division);
		}

		return view('admin.pages.planning.division_view', compact(
			'tree',
			'division',
			'divisions',
			'departments'
		));
	}

	/**
	 * Department view page
	 *
	 * @return View
	 */
	public function departmentView($id)
	{
		$tree = [];
		$company_id = Auth::user()->company_id;
		$department = DepartmentManagement::findOrFail($id);

		if (Auth::user()->hasRole('itfpobadmin')) {
			$divisions = Division::all();
			$departments = DepartmentManagement::all();
		}
		else {
			$divisions = Division::where('deleted_at', null)
													->whereHas('organization', function (Builder $query) use ($company_id) {
														$query->where('company_id', $company_id);
													})
													->get();
			$departments = DepartmentManagement::where('deleted_at', null)
																				->whereHas('organization', function (Builder $query) use ($company_id) {
																					$query->where('company_id', $company_id);
																				})
																				->get();
		}

		if ($department) {

			// if ($division->departments) {
			// 	$_departments = [];

			// 	foreach ($division->departments as $department) {
					// $_dept = [
					// 	'text' => $department->department_short_name . '<small class="ml-2 text-muted">(' . $department->employees->count() . ')</small>',
					// 	'id' => $department->id,
					// 	'children' => []
					// ];

					if ($department->sections) {
						$_sections = [];

						foreach ($department->sections as $section) {
							$_sec = [
								'text' => $section->short_name . ($section->getPositionsCount() > 0 ? '<small class="ml-2 text-warning">(' . $section->getFilledPositionsCount() . '/' . $section->getPositionsCount() . ')</small>' : ''),
								'id' => $section->id,
								'children' => []

							];
							$section_count = 0;

							if ($section->positions) {
								$_positions = [];
								$section_count += $section->positions->count();

								foreach ($section->positions as $position) {
									$_pos = [
										'text' => $position->title . '<small class="ml-2 text-warning">(' . (count($position->offers->where('accepted', 1)) ) . '/' . ($position->total_positions ? $position->total_positions : '0') . ')</small>',
										'id' => 'position_id-' . $position->id,
										'state' =>array('opened'=>true)
									];

									if (count($position->offers) > 0) {
										$_offers = [];

										foreach ($position->offers as $offer) {

											if ($offer->accepted == 1) {
												$_offer = [
													'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . '" srcset="' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions.png') . ' 1x, ' . URL::asset('img/icon-' . ($offer->hire_type == 1 ? 'local' : 'expat') . '-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span class="candidate-name" title="' . ($offer->candidate->name ? $offer->candidate->name : '') . ' ' . ($offer->candidate->last_name ? $offer->candidate->last_name : '') . '">' . ($offer->candidate->name ? $offer->candidate->name : '') . '</span>' . ' ' . '<img src="' . URL::asset('img/icon-rotation-type.png') . '" srcset="' . URL::asset('img/icon-rotation-type.png') . ' 1x, ' . URL::asset('img/icon-rotation-type@2x.png') . ' 2x" class="img-fluid pl-1 pr-1 mr-1 ml-1">' . ' <span class="rotation-type-value">' . ($offer->rotationType ? $offer->rotationType->title : '') . '</span></div>',
													'id' => 'offer_id-' . $offer->id,
													'a_attr' => [
														'class' => 'no-hover'
													]
												];

												array_push($_offers, $_offer);
											}
										}

										$_pos['children'] = $_offers;
									}

									array_push($_positions, $_pos);
								}

								$_sec['children'] = $_positions;
							}

							array_push($tree, $_sec);
						}

						// array_push($tree, $_sections);

						// $_dept['children'] = $_sections;
					}

					// array_push($tree, $_dept);
			// 	}

			// 	// $_division['children'] = $_departments;
			// }

			// array_push($tree, $_division);
		}

		return view('admin.pages.planning.department_view', compact(
			'tree',
			'department',
			'divisions',
			'departments'
		));
	}

}
