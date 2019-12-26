<?php

namespace App\Http\Controllers;

use App\DepartmentApproval;
use App\DepartmentApprovalRelationShip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Input;
use Illuminate\Database\Eloquent\Builder;
use URL;

use App\Section;
use App\Position;
use App\SectionRequest;
use App\PositionRequest;
use App\DepartmentManagement;
use App\PositionManagement;

class DepartmentRequestController extends Controller
{
  /**
	* Index page
	*
	* @return View
	*/
	public function index()
	{
		$department = Auth::user()->department ? Auth::user()->department : null;
		$requested_sections = $department ? $department->requestedSections : null;
		if ($requested_sections) {
			$requested_sections = $requested_sections->where('action_type', 0)->where('status', '!=', 1)->all();
		}
		$all_requested_positions = $department ? $department->requestedPositions : null;
		if ($all_requested_positions) {
			$all_requested_positions = $all_requested_positions->where('action_type', 0)->where('status', '!=', 1)->all();
		}

		$existing_sections = Section::whereHas('department', function (Builder $query) use ($department) {
																	if ($department)
																		$query->where('id', $department->id);
																})
																->whereDoesntHave('sectionUpdateRequest', function (Builder $query) {
																		$query->where('status', '!=', 1);
																})
																->where('deleted_at', null)
																// ->where('created_by', Auth::user()->id)
																->get();
		$existing_sections_updates = Section::whereHas('department', function (Builder $query) use ($department) {
																					if ($department)
																						$query->where('id', $department->id);
																				})
																				->whereHas('sectionUpdateRequest', function (Builder $query) {
																					$query->where('action_type', 1);
																					$query->where('status', '!=', 1);
																					$query->where('deleted_at', null);
																				})
																				// ->where('created_by', Auth::user()->id)
																				->orderBy('id', 'asc')
																				->get();

		$all_existing_positions = PositionManagement::whereHas('department', function (Builder $query) use ($department) {
																									if ($department)
																										$query->where('id', $department->id);
																								})
																								->whereDoesntHave('positionUpdateRequest', function (Builder $query) {
																									$query->where('deleted_at', null);
																								})
																								->where('deleted_at', null)
																								// ->where('created_by', Auth::user()->id)
																								->get();
		$existing_positions_updates = PositionManagement::whereHas('department', function (Builder $query) use ($department) {
																											if ($department)
																												$query->where('id', $department->id);
																										})
																										->whereHas('positionUpdateRequest', function (Builder $query) {
																											$query->where('action_type', 1);
																											$query->where('status', '!=', 1);
																											$query->where('deleted_at', null);
																										})
																										// ->where('created_by', Auth::user()->id)
																										->orderBy('id', 'asc')
																										->get();

		$dept_approval_last = DepartmentApproval::where('deleted_at', null)->orderBy('id', 'desc')->first();
		
		return view('admin.pages.management.department_requests.index', compact(
			'department',
			'requested_sections',
			'all_requested_positions',
			'existing_sections',
			'all_existing_positions',
			'existing_sections_updates',
			'existing_positions_updates',
			'dept_approval_last'
		));
	}

	/**
	 * Get positions.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getPositions(Request $request)
	{
		$success = false;
		$section = $request->input('type') == 'requested'
								? SectionRequest::find($request->input('id'))
								: Section::find($request->input('id'));
		$requested_positions = [];
		$existing_positions = [];
		$existing_positions_updates = [];

		if ($section) {
			$success = true;
			$positions = $section->positions;

			if ($request->input('type') == 'requested') {
				$requested_positions = $section->positions;
			}
			else {
				$requested_positions = $section->positionRequests;
				$existing_positions = PositionManagement::whereHas('section', function (Builder $query) use ($section) {
																									$query->where('id', $section->id);
																								})
																								->whereDoesntHave('positionUpdateRequest', function (Builder $query) {
																									$query->where('deleted_at', null);
																								})
																								->where('deleted_at', null)
																								->where('created_by', Auth::user()->id)
																								->orderBy('id', 'asc')
																								->get();
				$existing_positions_updates = PositionRequest::where('section_id', $request->input('id'))
																											->where('action_type', 1)
																											->where('status', '!=', 1)
																											->where('created_by', Auth::user()->id)
																											->where('deleted_at', null)
																											->orderBy('id', 'asc')
																											->get();
			}
		}
		else {
			$message = 'Section not found.';
		}

		return response()->json([
			'success' => $success,
			'requested_positions' => $requested_positions,
			'existing_positions' => $existing_positions,
			'existing_positions_updates' => $existing_positions_updates,
			'type' => $request->input('type')
		]);
	}

	/**
	 * Save section.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function saveSection(Request $request)
	{
		$success = false;
		$message = '';
		$company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
		$department_id = Auth::user()->department ? Auth::user()->department->id : 0;

		try {
			$validator = Validator::make($request->all(), [
				'short_name' => 'required',
				'full_name' => 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
			}

			if ($request->input('is_update')) {
				$section = SectionRequest::findOrFail($request->input('section_id'));
				$section->updated_at = date('Y-m-d H:i:s');
				$section->updated_by = Auth::user()->id;
			}
			else {
				$section = new SectionRequest();

				if ($request->input('action_type') == 0) {
					$section->section_code = 'S' . date('ymdHis');
				}

				if ($request->input('action_type') == 1) {
					$section->section_id = $request->input('section_id');
				}
				
				$section->created_by = Auth::user()->id;
				$section->created_at = date('Y-m-d H:i:s');
			}

			$section->dept_id = $department_id;
			$section->short_name = $request->input('short_name');
			$section->full_name = $request->input('full_name');
			$section->company_id = $company_id;
			$section->action_type = $request->input('action_type');
			$section->status = 0;

			if ($section->save()) {
				$success = true;
				$message = 'Section ' . ($request->input('is_update') ? 'updated.' : 'saved.');
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message
		]);
	}

	/**
	 * Save position.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function savePosition(Request $request)
	{
		$success = false;
		$message = '';
		$company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
		$department_id = Auth::user()->department ? Auth::user()->department->id : 0;
		$division_id = Auth::user()->department && Auth::user()->department->division ? Auth::user()->department->division->id : 0;

		try {
			$validator = Validator::make($request->all(), [
				'title' => 'required',
				'total_positions' => 'required|gt:0',
				'due_date'=>'required'
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
			}

			if ($request->input('is_update')) {
				$position = PositionRequest::findOrFail($request->input('position_id'));
				$position->updated_at = date('Y-m-d H:i:s');
				if ($request->input('position_type') == 'requested') {
					$position->updated_by = Auth::user()->id;
				}
			}
			else {
				$position = new PositionRequest();

				if ($request->input('action_type') == 0) {
					$max_id = PositionRequest::max('id');
					$max_id = $max_id + 1;
					$position->reference_no = 'P' . str_pad($max_id, 3, '0', STR_PAD_LEFT);
				}

				if ($request->input('action_type') == 1) {
					$position->position_id = $request->input('position_id');
				}

				$position->section_id = $request->input('section_id') ? $request->input('section_id') : 0;
				$position->created_by = Auth::user()->id;
				$position->created_at = date('Y-m-d H:i:s');
			}

			

			$position->title = $request->input('title');
			$position->local_positions = $request->input('local_positions') ? $request->input('local_positions') : 0;
			$position->expat_positions = $request->input('expat_positions') ? $request->input('expat_positions') : 0;
			$position->total_positions = $request->input('total_positions') ? $request->input('total_positions') : 0;
			$position->department_id = $department_id;
			$position->location = $request->input('location');
			$position->notes = $request->input('remarks');
			$position->due_date = db_date_format($request->input('due_date'));
			$position->company_id = $company_id;
			$position->action_type = $request->input('action_type');
			$position->status = 0;

			if ($position->save()) {
				$success = true;
				$message = 'Position ' . ($request->input('is_update') ? 'updated.' : 'saved.');
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message
		]);
	}

	/**
	 * Delete section.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deleteSection($id, $delete_type = null, Request $request)
	{
		$success = false;
		$message = '';
		$type = $request->input('type');
		$view = $request->input('view');

		try {
			if ($delete_type == null || $delete_type == 'existing-update') {
				$section = SectionRequest::findOrFail($id);
				$section->updated_by = Auth::user()->id;
				$section->deleted_at = date('Y-m-d H:i:s');

			}
			elseif ($delete_type == 'existing') {
				$section = new SectionRequest();
				$section->dept_id = Auth::user()->department ? Auth::user()->department->id : 0;
				$section->company_id = Auth::user()->company ? Auth::user()->company->id : 0;
				$section->section_id = $id;
				$section->action_type = 2;
				$section->status = 0;
				$section->created_by = Auth::user()->id;
				$section->created_at = date('Y-m-d H:i:s');
			}

			if ($section->save()) {
				$success = true;
				$message = 'Section deleted.';

				if ($delete_type == 'existing') {
					// get existing section from sections table
					$existing_section = Section::findOrFail($id);
					
					// create delete requests for positions belonging to section
					if ($existing_section->positions) {
						foreach ($existing_section->positions as $pos) {
							$position = new PositionRequest();
							$position->local_positions = $pos->local_positions;
							$position->expat_positions = $pos->expat_positions;
							$position->total_positions = $pos->total_positions;
							$position->action_type = 2;
							$position->status = 0;
							$position->department_id = $existing_section->dept_id;
							$position->company_id = Auth::user()->company ? Auth::user()->company->id : 0;
							$position->created_by = Auth::user()->id;
							$position->created_at = date('Y-m-d H:i:s');
							$position->position_id = $pos->id;
							$position->save();
						}
					}
				}
				else {
				if ($section->positions) {
					foreach ($section->positions as $pos) {
						$position = PositionRequest::find($pos->id);
						$position->deleted_at = date('Y-m-d H:i:s');
						$position->save();
					}
				}
			}

			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'msg' => $message,
			'type' => $type,
			'view' => $view,
			'delete_type' => $delete_type,
			'return_url' => url('admin/department-requests')
		]);
	}

	/**
	 * Delete position.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function deletePosition($id, $delete_type = null, Request $request)
	{
		$success = false;
		$message = '';
		$type = $request->input('type');
		$view = $request->input('view');

		try {
			if ($delete_type == null || $delete_type == 'existing-update') {
			$position = PositionRequest::findOrFail($id);
			$position->updated_by = Auth::user()->id;
			$position->deleted_at = date('Y-m-d H:i:s');
			}
			elseif ($delete_type == 'existing') {
				$position = new PositionRequest();
				$position->action_type = 2;
				$position->status = 0;
				$position->company_id = Auth::user()->company ? Auth::user()->company->id : 0;
				$position->created_by = Auth::user()->id;
				$position->created_at = date('Y-m-d H:i:s');
				$position->updated_by = Auth::user()->id;
				$position->position_id = $id;

				// get existing position, then save its department_id to this position_request
				$existing_position = PositionManagement::findOrFail($position->position_id);
				$position->department_id = $existing_position->department_id;
				$position->expat_positions = $existing_position->expat_positions;
				$position->local_positions = $existing_position->local_positions;
				$position->total_positions = $existing_position->total_positions;
			}

			if ($position->save()) {
				$success = true;
				$message = 'Position deleted.';
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'msg' => $message,
			'type' => $type,
			'view' => $view,
			'return_url' => url('admin/department-requests')
		]);
	}


    public function section_pending()
    {
        $pending = Input::get('pending', 0);
        $type = Input::get('type', 0);
        $department = Auth::user()->department ? Auth::user()->department : null;
        $requested_sections = $department ? $department->requestedSections : null;
        return view('admin.pages.management.department_requests.section_pending',compact(
            'pending','type','requested_sections'
        ));
    }

    public function section_pending_status(Request $request)
    {
        $user_id = Auth::user()->id;
        $message = 'Section Approved';
        $success = false;
        $type = $request->input('type');
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',', $ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $id) {
                $ReqSection = SectionRequest::find($id);
                if ($ReqSection->first()) {
                    $ReqSection->updated_at = date('Y-m-d H:i:s');
                    $ReqSection->is_approved = 1;
                    $ReqSection->updated_by = $user_id;
                    $ReqSection->save();

                    // save in section as well
                    $section = new Section();
                    $dept_id = $ReqSection->dept_id;
                    $section_id = $id;
                    $MyDept = DepartmentManagement::find($dept_id);
                    if($MyDept)
                    {

                        $section->org_id = $MyDept->organization ? $MyDept->organization->id : 0;
                        $section->div_id = $MyDept->division ? $MyDept->division->id : 0;
                        $section->dept_id = $dept_id;
                        $section->section_code = $ReqSection->section_code;
                        $section->short_name = $ReqSection->short_name;
                        $section->full_name = $ReqSection->full_name;
                        $section->is_active = 1;
                        $section->created_by = $user_id;
                        $section->created_at = date('Y-m-d H:i:s');
                        if($section->save())
                        {
                            //TODO
                        }

                    }
                }
            }

            return redirect()
                ->route("dashboard")
                ->with([
                    'alert-message'    => "Section(s) Approved Successfully",
                    'alert-type' => 'success',
                ]);
        }
    }


    public function position_pending()
    {
        $pending = Input::get('pending', 0);
        $type = Input::get('type', 0);
        $department = Auth::user()->department ? Auth::user()->department : null;
        $requested_positions = $department ? $department->requestedPositions : null;
        return view('admin.pages.management.department_requests.position_pending',compact(
            'pending','type','requested_positions'
        ));
    }


    public function position_pending_status(Request $request)
    {
        $user_id = Auth::user()->id;
        $message = 'Section Approved';
        $success = false;
        $type = $request->input('type');
        if($request->input('ids')) {
            $ids = $request->input('ids');
            $ids = explode(',', $ids);
            sort($ids);
            $i = 0;
            foreach ($ids as $id) {
                $ReqPosition = PositionRequest::find($id);
                if ($ReqPosition->first()) {
                    $ReqPosition->updated_at = date('Y-m-d H:i:s');
                    $ReqPosition->is_approved = 1;
                    $ReqPosition->updated_by = $user_id;
                    $ReqPosition->save();

                    // save in position as well
                    $position = new PositionManagement();



                        $position->department_id = $ReqPosition->department_id;
                        $position->section_id = $ReqPosition->section_id;
                        $position->reference_no = $ReqPosition->reference_no;
                        $position->total_positions = $ReqPosition->total_positions;
                        $position->local_positions = $ReqPosition->local_positions;
                        $position->expat_positions = $ReqPosition->expat_positions;
                        $position->title = $ReqPosition->title;
                        $position->location = $ReqPosition->location;
                        $position->created_by = $user_id;
                        $position->company_id = Auth::user()->company_id;
                        $position->created_at = date('Y-m-d H:i:s');
                        if($position->save())
                        {
                            //TODO
                        }

                }
            }

            return redirect()
                ->route("dashboard")
                ->with([
                    'alert-message'    => "Position(s) Approved Successfully",
                    'alert-type' => 'success',
                ]);
        }
    }

    public function SubmitForApproval(Request $request)
    {
        $success = false;
        $message = 'Error Occurred!';
        $company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
        $department_id = Auth::user()->department ? Auth::user()->department->id : 0;

        try {

            if($department_id)
            {
                //create new request
                $approval = new DepartmentApproval();
                $approval->department_id = $department_id;
                $approval->created_by = Auth::user()->id;
                $approval->company_id = $company_id;
                $approval->created_at = date('Y-m-d H:i:s');
                $approval->status = 0;  //new request

                if($approval->save())
                {
                    $approval_id = $approval->id;

                    //save relationship
                    $ReqSections = SectionRequest::where('status',0)->whereNull('deleted_at')->get();
                    foreach ($ReqSections as $ReqSection)
                    {
                        $deptRelation = new DepartmentApprovalRelationShip();
                        $deptRelation->section_request_id = $ReqSection->id;
                        $deptRelation->dept_approval_id = $approval_id;
                        $deptRelation->type = 0;
                        $deptRelation->save();
                    }

                    $ReqPositions = PositionRequest::where('status',0)->whereNull('deleted_at')->get();
                    foreach ($ReqPositions as $ReqPosition)
                    {
                        $deptRelation = new DepartmentApprovalRelationShip();
                        $deptRelation->position_request_id = $ReqPosition->id;
                        $deptRelation->dept_approval_id = $approval_id;
                        $deptRelation->type = 1;
                        $deptRelation->save();
                    }

                    $success = true;
                    $message = "Request Submitted Successfully!";

                }

            }

        }catch (\Exception $e) {
            $message =  $e->getMessage();
        }

//        return response()->json([
//            'success' => $success,
//            'message' => $message
//        ]);
        return redirect()
            ->route("management.department-requests.list")
            ->with([
                'alert-message'    => $message,
                'alert-type' => $success ? 'success' : 'warning',
            ]);
    }

    public function ApproveRequestById(Request $request)
    {
        $success = false;
        $message = 'Error Occurred!';
        $company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
        $user_id = Auth::user()->id;

        $request_id = $request->input('id');
        try{
            if($request_id)
            {
                $approvalRequest = DepartmentApproval::where('id',$request_id)->where('status',0)->first();
                if($approvalRequest)
                {
                    //first do section
                    $reqSectionRships = DepartmentApprovalRelationShip::where('dept_approval_id',$request_id)->where('type',0)->get();

                    foreach($reqSectionRships as $reqSectionRship)
                    {
                        $ReqSection = SectionRequest::find($reqSectionRship->section_request_id);
                        if ($ReqSection->first()) {
                            $dept_id = $ReqSection->dept_id;
                            if($ReqSection->action_type == 0)//new entry
                            {
                                // save in section as well
                                $section = new Section();
                                $MyDept = DepartmentManagement::find($dept_id);
                                if($MyDept)
                                {

                                    $section->org_id = $MyDept->organization ? $MyDept->organization->id : 0;
                                    $section->div_id = $MyDept->division ? $MyDept->division->id : 0;
                                    $section->dept_id = $dept_id;
                                    $section->section_code = $ReqSection->section_code;
                                    $section->short_name = $ReqSection->short_name;
                                    $section->full_name = $ReqSection->full_name;
                                    $section->is_active = 1;
                                    $section->created_by = $user_id;
                                    $section->created_at = date('Y-m-d H:i:s');
                                    if($section->save())
                                    {
																				// save new section id to section_request
																				$ReqSection->approved_section_id = $section->id;
                                    }

                                }
                            }elseif ($ReqSection->action_type == 1)//edit
                            {
                                $section = Section::find($ReqSection->section_id);
                                if($section)
                                {
                                    $MyDept = DepartmentManagement::find($dept_id);
                                    if($MyDept)
                                    {

                                        $section->org_id = $MyDept->organization ? $MyDept->organization->id : 0;
                                        $section->div_id = $MyDept->division ? $MyDept->division->id : 0;
                                        $section->dept_id = $dept_id;
                                        $section->section_code = $ReqSection->section_code;
                                        $section->short_name = $ReqSection->short_name;
                                        $section->full_name = $ReqSection->full_name;
                                        $section->is_active = 1;
                                        $section->created_by = $user_id;
                                        $section->created_at = date('Y-m-d H:i:s');
                                        if($section->save())
                                        {
                                            //TODO
                                        }

                                    }

                                }
                            }elseif ($ReqSection->action_type == 2)
                            {
                                $section = Section::find($ReqSection->section_id);
                                if($section)
                                {
                                    $section->deleted_at = date('Y-m-d H:i:s');
                                    $section->updated_by = $user_id;
                                    if($section->save())
                                    {
                                        //TODO
                                    }
                                }
                            }else{
                                //TODO
                            }

                            //update back
                            $ReqSection->updated_at = date('Y-m-d H:i:s');
                            $ReqSection->status = 1;
                            $ReqSection->updated_by = $user_id;
                            if($ReqSection->save())
                            {
                                $message = "Request Approved Successfully!";
                                $success = true;
                            }
                        }
                    }

                    //now update positions
                    $reqPositionRships = DepartmentApprovalRelationShip::where('dept_approval_id',$request_id)->where('type',1)->get();

                    foreach($reqPositionRships as $reqPositionRship)
                    {
                        $ReqPosition = PositionRequest::find($reqPositionRship->position_request_id);
                        if ($ReqPosition->first()) {
                            $dept_id = $ReqPosition->department_id;
                            if($ReqPosition->total_positions < 1)
                            {
                                return redirect()
                                    ->route("management.department-requests.list")
                                    ->with([
                                        'alert-message'    => "Total positions can not be 0",
                                        'alert-type' => 'warning',
                                    ]);
                            }
                            if($ReqPosition->action_type == 0)//new entry
                            {
                                // save in position as well
                                $position = new PositionManagement();
                                $position->department_id = $ReqPosition->department_id;
                                $position->div_id = $ReqPosition->department->div_id;



																// if sections_request has approved_section_id, this is a new position for new section (use approved_section_id)
																// otherwise, this is a new position for an existing section (use section_id on positions_requests table)
																$position->section_id = $ReqPosition->section && $ReqPosition->section->approved_section_id != 0 ? $ReqPosition->section->approved_section_id : $ReqPosition->section_id;
																
																if ($ReqPosition->reference_no) {
																	$max_id = PositionManagement::max('id');
																	$max_id = $max_id + 1;
																	$position->reference_no = 'P' . str_pad($max_id, 3, '0', STR_PAD_LEFT);
																}

                                $position->reference_no = $ReqPosition->reference_no;
                                $position->total_positions = $ReqPosition->total_positions;
                                $position->local_positions = $ReqPosition->local_positions;
                                $position->expat_positions = $ReqPosition->expat_positions;
                                $position->title = $ReqPosition->title;
                                $position->location = $ReqPosition->location;
                                $position->created_by = $user_id;
                                $position->company_id = Auth::user()->company_id;
                                $position->created_at = date('Y-m-d H:i:s');
                                if($position->save())
                                {
                                    //TODO
                                }

                            }elseif ($ReqPosition->action_type == 1)//edit
                            {
                                $position = PositionManagement::find($ReqPosition->position_id);
                                if($position)
                                {
                                    $position->department_id = $ReqPosition->department_id;
                                    $position->section_id = $ReqPosition->section_id;
                                    $position->reference_no = $ReqPosition->reference_no;
                                    $position->total_positions = $ReqPosition->total_positions;
                                    $position->local_positions = $ReqPosition->local_positions;
                                    $position->expat_positions = $ReqPosition->expat_positions;
                                    $position->title = $ReqPosition->title;
                                    $position->location = $ReqPosition->location;
                                    $position->created_by = $user_id;
                                    $position->company_id = Auth::user()->company_id;
                                    $position->created_at = date('Y-m-d H:i:s');
                                    if($position->save())
                                    {
                                        //TODO
                                    }
                                }


                            }elseif ($ReqPosition->action_type == 2)//delete
                            {
                                $position = PositionManagement::find($ReqPosition->position_id);
                                if($position)
                                {
                                    $position->deleted_at = date('Y-m-d H:i:s');
                                    $position->updated_by = $user_id;
                                    if($position->save())
                                    {
                                        //TODO
                                    }
                                }
                            }else{
                                //TODO
                            }

                            //update back
                            $ReqPosition->updated_at = date('Y-m-d H:i:s');
                            $ReqPosition->status = 1;
                            $ReqPosition->updated_by = $user_id;
                            if($ReqPosition->save())
                            {
                                $message = "Request Approved Successfully!";
                                $success = true;
                            }
                        }
                    }

                    //update DepartmentApproval back
                    $approvalRequest->approved_by = $user_id;
                    $approvalRequest->status = 1;
                    $approvalRequest->updated_at = date('Y-m-d H:i:s');
                    $approvalRequest->save();

                }


            }
        }catch (\Exception $e) {
            $message =  $e->getMessage();
        }

        return redirect()
            ->route("management.department-requests.list")
            ->with([
                'alert-message'    => $message,
                'alert-type' => $success ? 'success' : 'warning',
            ]);

    }

    public function RejectRequestById(Request $request)
    {
        $success = false;
        $message = 'Error Occurred!';
        $company_id = Auth::user()->company_id ? Auth::user()->company_id : 0;
        $user_id = Auth::user()->id;

        $request_id = $request->input('id');

        try{
            if($request_id)
            {
                $approvalRequest = DepartmentApproval::where('id',$request_id)->where('status',0)->first();
                if($approvalRequest)
                {
                    $reqSectionRships = DepartmentApprovalRelationShip::where('dept_approval_id',$request_id)->where('type',0)->get();
                    foreach($reqSectionRships as $reqSectionRship) {
                        $ReqSection = SectionRequest::find($reqSectionRship->section_request_id);
                        if ($ReqSection->first()) {
                            $ReqSection->updated_at = date('Y-m-d H:i:s');
                            $ReqSection->status = 2;
                            $ReqSection->updated_by = $user_id;
                            if($ReqSection->save())
                            {
                                $message = "Request Rejected Successfully!";
                                $success = true;
                            }
                        }
                    }

                    $reqPositionRships = DepartmentApprovalRelationShip::where('dept_approval_id',$request_id)->where('type',1)->get();

                    foreach($reqPositionRships as $reqPositionRship) {
                        $ReqPosition = PositionRequest::find($reqPositionRship->position_request_id);
                        if ($ReqPosition->first()) {
                            $ReqPosition->updated_at = date('Y-m-d H:i:s');
                            $ReqPosition->status = 2;
                            $ReqPosition->updated_by = $user_id;
                            if($ReqPosition->save())
                            {
                                $message = "Request Rejected Successfully!";
                                $success = true;
                            }
                        }
                    }


                    //update DepartmentApproval back
                    $approvalRequest->approved_by = $user_id;
                    $approvalRequest->status = 2;
                    $approvalRequest->updated_at = date('Y-m-d H:i:s');
                    $approvalRequest->save();


                }
            }
        }catch(\Exception $e)
        {
            $message = $e->getMessage();
        }
    }


	/**
	 * Quick view page
	 *
	 * @return View
	 */
	public function quickView($id = 0, $show_buttons = 0, $approval_id = 0)
	{
		$department = $id 
									? DepartmentManagement::findOrFail($id) 
									: (Auth::user()->department ? Auth::user()->department : null);
		$total_requested_positions = 0;
		$requested_local_positions = 0;
		$requested_expat_positions = 0;
		$tree = [];

		if ($department) {
			// get requested positions
			if ($department->requestedPositions) {
				foreach ($department->requestedPositions as $requested_position) {
					if ($requested_position->status != 1) {
						// new request
						if ($requested_position->action_type == 0) {
							$total_requested_positions += $requested_position->total_positions;
							$requested_local_positions += $requested_position->local_positions;
							$requested_expat_positions += $requested_position->expat_positions;
						}
						// delete request
						// removed since requested positions when deleted will automatically be deleted
						/*elseif ($requested_position->action_type == 2) {
							$total_requested_positions -= $requested_position->total_positions;
							$requested_local_positions -= $requested_position->local_positions;
							$requested_expat_positions -= $requested_position->expat_positions;
						}*/
					}
				}
			}

			// get edited positions
			if ($department->positions) {
				foreach ($department->positions as $edited_position) {
					// get previous values
					$previous_value = $edited_position->total_positions;
					$previous_local_value = $edited_position->local_positions;
					$previous_expat_value = $edited_position->expat_positions;

					if ($edited_position->positionUpdateRequest) {
						if ($edited_position->positionUpdateRequest->action_type == 1) {
							if ($edited_position->positionUpdateRequest->total_positions > $previous_value) {
								$total_requested_positions += $edited_position->positionUpdateRequest->total_positions;
							}
							elseif ($edited_position->positionUpdateRequest->total_positions < $previous_value) {
								$total_requested_positions -= ($previous_value - $edited_position->positionUpdateRequest->total_positions);
							}

							if ($edited_position->positionUpdateRequest->local_positions > $previous_local_value) {
								$requested_local_positions += $edited_position->positionUpdateRequest->local_positions;
							}
							elseif ($edited_position->positionUpdateRequest->total_positions < $previous_local_value) {
								$requested_local_positions -= ($previous_local_value - $edited_position->positionUpdateRequest->local_positions);
							}

							if ($edited_position->positionUpdateRequest->expat_positions > $previous_expat_value) {
								$requested_expat_positions += $edited_position->positionUpdateRequest->expat_positions;
							}
							elseif ($edited_position->positionUpdateRequest->total_positions < $previous_expat_value) {
								$requested_expat_positions -= ($previous_expat_value - $edited_position->positionUpdateRequest->expat_positions);
							}

						}
						elseif ($edited_position->positionUpdateRequest->action_type == 2 && $edited_position->positionUpdateRequest->deleted_at == null) {
							$total_requested_positions -= $edited_position->total_positions;
							$requested_local_positions -= $edited_position->local_positions;
							$requested_expat_positions -= $edited_position->expat_positions;
						}
					}
				}
			}

			// get sections
			if ($department->sections) {
				$_sections = [];

				// existing positions for existing departments
				foreach ($department->sections as $section) {
					$_sec = [
						'text' => $section->sectionUpdateRequest && $section->sectionUpdateRequest->action_type == 1 && $section->sectionUpdateRequest->status != 1 ? $section->sectionUpdateRequest->short_name : $section->short_name,
						'id' => $section->id,
						'children' => [],
						'state' =>array('opened'=>true)
					];
					$section_count = 0;

					if ($section->positions) {
						$_positions = [];
						// $section_count += $section->positions->count();

						foreach ($section->positions as $position) {
							$type = null;

							if ($position->positionUpdateRequest && $position->positionUpdateRequest->action_type == 1 && $position->positionUpdateRequest->deleted_at == NULL) {
								$type = 'new';
							}
							elseif ($position->positionUpdateRequest && $position->positionUpdateRequest->action_type == 2 && $position->positionUpdateRequest->deleted_at == NULL) {
								$type = 'delete';
							}

							$include = true;

							// exclude delete requests
							if ($position->positionUpdateRequest && $position->positionUpdateRequest->action_type == 2 && $position->positionUpdateRequest->deleted_at == null) {
								$include = false;
							}

							if ($include) {
							$_pos = [
									'text' => $type == 'new' ? $position->positionUpdateRequest->title : $position->title,
								'id' => 'position_id-' . $position->id,
								'state' => array('opened' => true),
								'children' => array()
							];

							$local_value_change = 0;
							$expat_value_change = 0;

								if ($type == 'new') {
								$local_value_change = $position->local_positions - $position->positionUpdateRequest->local_positions;
								$local_value_change = $local_value_change * -1;

								$expat_value_change = $position->expat_positions - $position->positionUpdateRequest->expat_positions;
								$expat_value_change = $expat_value_change * -1;
							}
								elseif ($type == 'delete') {
									$local_value_change = $position->local_positions * -1;
									$expat_value_change = $position->expat_positions * -1;
								}

							$local = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-local-positions.png') . '" srcset="' . URL::asset('img/icon-local-positions.png') . ' 1x, ' . URL::asset('img/icon-local-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Local</span> <span class="ml-2 font-weight-bold text-muted">' . ($type == 'new' ? $position->positionUpdateRequest->local_positions : ($type == 'delete' ? 0 : $position->local_positions)) . '</span> ' . ($local_value_change ? '<small class="ml-1 text-' . ($local_value_change > 0 ? 'navy' : 'danger') . '">(' . ($local_value_change > 0 ? '+' : '') . $local_value_change . ')</small>' : '') . '</div>',
								'id' => 'local-' . $position->id,
							];

							$expat = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-expat-positions.png') . '" srcset="' . URL::asset('img/icon-expat-positions.png') . ' 1x, ' . URL::asset('img/icon-expat-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Expat</span> <span class="ml-2 font-weight-bold text-muted">' . ($type == 'new' ? $position->positionUpdateRequest->expat_positions : ($type == 'delete' ? 0 : $position->expat_positions)) . '</span> ' . ($expat_value_change ? '<small class="ml-1 text-' . ($expat_value_change > 0 ? 'navy' : 'danger') . '">(' . ($expat_value_change > 0 ? '+' : '') . $expat_value_change . ')</small>' : '') . '</div>',
								'id' => 'expat-' . $position->id,
							];

							array_push($_pos['children'], $local);
							array_push($_pos['children'], $expat);

							array_push($_positions, $_pos);
						}
							
						}

						// array_push($_sec['children'], $_positions);
						$_sec['children'] = $_positions;
					}

					// new position requests for existing section
					if ($section->positionRequests) {
						$_positions = [];
						// $section_count += $section->positions->count();

						foreach ($section->positionRequests as $position) {
							if ($position->section_id == $section->id) {
								$_pos = [
									'text' => $position->title,
									'id' => 'existing_section_requested_position_id-' . $position->id,
									'state' => array('opened' => true),
									'children' => array()
								];

								$local = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-local-positions.png') . '" srcset="' . URL::asset('img/icon-local-positions.png') . ' 1x, ' . URL::asset('img/icon-local-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Local</span> <span class="ml-2 font-weight-bold text-muted">' . $position->local_positions . '</span></div>',
									'id' => 'existing_section_requested_position_local-' . $position->id,
								];

								$expat = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-expat-positions.png') . '" srcset="' . URL::asset('img/icon-expat-positions.png') . ' 1x, ' . URL::asset('img/icon-expat-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Expat</span> <span class="ml-2 font-weight-bold text-muted">' . $position->expat_positions . '</span></div>',
									'id' => 'existing_section_requested_position_expat-' . $position->id,
								];

								array_push($_pos['children'], $local);
								array_push($_pos['children'], $expat);

								array_push($_positions, $_pos);
							}
						}

						// $_sec['children'] = $_positions;
						// array_push($_sec['children'], $_positions);
						foreach ($_positions as $pos) {
							array_push($_sec['children'], $pos);
						} 
					}

					array_push($tree, $_sec);
				}

			}


			// requested positions for requested sections
			if ($department->requestedSections) {
				foreach ($department->requestedSections as $section) {
					if ($section->status != 1 && $section->action_type == 0) {
						$_sec = [
							'text' => $section->short_name,
							'id' => 'requested_' . $section->id,
							'children' => [],
							'state' =>array('opened'=>true)
						];
						$section_count = 0;

						if ($section->positions) {
							$_positions = [];
							$section_count += $section->positions->count();

							foreach ($section->positions as $position) {
								$_pos = [
									'text' => $position->title,
									'id' => 'requested_position_id-' . $position->id,
									'state' => array('opened' => true),
									'children' => array()
								];

								$local = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-local-positions.png') . '" srcset="' . URL::asset('img/icon-local-positions.png') . ' 1x, ' . URL::asset('img/icon-local-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Local</span> <span class="ml-2 font-weight-bold text-muted">' . $position->local_positions . '</span></div>',
									'id' => 'requested_local-' . $position->id,
								];

								$expat = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-expat-positions.png') . '" srcset="' . URL::asset('img/icon-expat-positions.png') . ' 1x, ' . URL::asset('img/icon-expat-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Expat</span> <span class="ml-2 font-weight-bold text-muted">' . $position->expat_positions . '</span></div>',
									'id' => 'requested_expat-' . $position->id,
								];

								array_push($_pos['children'], $local);
								array_push($_pos['children'], $expat);

								array_push($_positions, $_pos);
							}

							$_sec['children'] = $_positions;
						}

						array_push($tree, $_sec);
					}
				}
			}

			// get positions direct from department (without section)
			if ($department->requestedPositionsDirect) {
				$_sections = [];

				// existing positions for existing departments
				// foreach ($department->sections as $section) {
					$_sec = [
						'text' => '',
						'id' => 'positions_without_section',
						'children' => [],
						'state' =>array('opened'=>true)
					];

					// if ($section->positions) {
						$_positions = [];

						foreach ($department->requestedPositionsDirect as $position) {
							if ($position->status != 1) {
								$_pos = [
									'text' => $position->title,
									'id' => 'position_id-' . $position->id,
									'state' => array('opened' => true),
									'children' => array()
								];

								// $local_value_change = 0;
								// $expat_value_change = 0;

								// // if ($position->positionUpdateRequest && $position->positionUpdateRequest->action_type == 1 && $position->positionUpdateRequest->deleted_at == NULL) {
								// 	// $local_value_change = $position->position->local_positions - $position->local_positions;
								// 	// $local_value_change = $local_value_change * -1;

								// 	// $expat_value_change = $position->position->expat_positions - $position->expat_positions;
								// 	// $expat_value_change = $expat_value_change * -1;
								// // }

								$local = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-local-positions.png') . '" srcset="' . URL::asset('img/icon-local-positions.png') . ' 1x, ' . URL::asset('img/icon-local-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Local</span> <span class="ml-2 font-weight-bold text-muted">' . $position->local_positions . '</span> <small class="ml-1 text-navy">(+' . $position->local_positions . ')</small></div>',
									'id' => 'local-' . $position->id,
								];

								$expat = [
									'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-expat-positions.png') . '" srcset="' . URL::asset('img/icon-expat-positions.png') . ' 1x, ' . URL::asset('img/icon-expat-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Expat</span> <span class="ml-2 font-weight-bold text-muted">' . $position->expat_positions . '</span> <small class="ml-1 text-navy">(+' . $position->expat_positions . ')</small></div>',
									'id' => 'expat-' . $position->id,
								];

								

								array_push($_pos['children'], $local);
								array_push($_pos['children'], $expat);

								array_push($_positions, $_pos);
							}
						}

						// array_push($_sec['children'], $_positions);
						$_sec['children'] = $_positions;
					// }

					// new position requests for existing section
					// if ($section->positionRequests) {
					// 	$_positions = [];
					// 	// $section_count += $section->positions->count();

					// 	foreach ($section->positionRequests as $position) {
					// 		if ($position->section_id == $section->id) {
					// 			$_pos = [
					// 				'text' => $position->title,
					// 				'id' => 'existing_section_requested_position_id-' . $position->id,
					// 				'state' => array('opened' => true),
					// 				'children' => array()
					// 			];

					// 			$local = [
					// 				'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-local-positions.png') . '" srcset="' . URL::asset('img/icon-local-positions.png') . ' 1x, ' . URL::asset('img/icon-local-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Local</span> <span class="ml-2 font-weight-bold text-muted">' . $position->local_positions . '</span></div>',
					// 				'id' => 'existing_section_requested_position_local-' . $position->id,
					// 			];

					// 			$expat = [
					// 				'text' => '<div class="d-flex align-items-center"><img src="' . URL::asset('img/icon-expat-positions.png') . '" srcset="' . URL::asset('img/icon-expat-positions.png') . ' 1x, ' . URL::asset('img/icon-expat-positions@2x.png') . ' 2x" class="img-fluid mr-1 pr-1">' . '<span>Expat</span> <span class="ml-2 font-weight-bold text-muted">' . $position->expat_positions . '</span></div>',
					// 				'id' => 'existing_section_requested_position_expat-' . $position->id,
					// 			];

					// 			array_push($_pos['children'], $local);
					// 			array_push($_pos['children'], $expat);

					// 			array_push($_positions, $_pos);
					// 		}
					// 	}

					// 	// $_sec['children'] = $_positions;
					// 	// array_push($_sec['children'], $_positions);
					// 	foreach ($_positions as $pos) {
					// 		array_push($_sec['children'], $pos);
					// 	} 
					// }

					array_push($tree, $_sec);
				// }

			}

		}

		return view('admin.pages.management.department_requests.quick_view', compact(
			'department',
			'total_requested_positions',
			'requested_local_positions',
			'requested_expat_positions',
			'tree',
			'show_buttons',
			'approval_id'
		));
	}

}
