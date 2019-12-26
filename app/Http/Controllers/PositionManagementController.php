<?php

namespace App\Http\Controllers;

use App\DepartmentManagement;
use App\Division;
use App\OrganizationManagement;
use App\PositionManagement;
use App\Section;
use App\User;
use App\Vacancy;
use App\WorkType;
use App\CandidateAge;
use App\EducationLevel;
use App\RotationType;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Session;

class PositionManagementController extends Controller
{
	/**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{
		return view('admin.pages.planning.position-management.list');
	}

	/**
	 * Create page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function create()
	{
        $all_users = User::all();
        $user_id = Auth::user()->id;
				$company_id = Auth::user()->company_id;
        $depts = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
					$query->where('company_id', $company_id);
				})->get();
        $reference_no = "P".date('ymdHis');
        $data = array(
            'all_users' => $all_users,
            'user_id' =>$user_id,
            'reference_no'=>$reference_no,
            'depts'=>$depts

        );
		return view('admin.pages.planning.position-management.create')->with('data', $data);
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$position = PositionManagement::findOrFail($id);

		return view('admin.pages.planning.position-management.detail', compact(
			'position'
		));
	}

	/**
	 * Update page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		$all_users = User::all();
		if ($id) {
				$position = PositionManagement::find($id);
				$vacancy = Vacancy::where('position_id', $id)->first();
				$company_id = Auth::user()->company_id;
				$ages = CandidateAge::all();
				$work_types = WorkType::all();
				$education_levels = EducationLevel::all();
				$rotation_types = RotationType::all();

				$depts = DepartmentManagement::whereHas('organization', function ($query) use ($company_id) {
					$query->where('company_id', $company_id);
				})->get();

				$company_departments = [];
				if ($depts) {
					foreach ($depts as $dept) {
						array_push($company_departments, $dept->id);
					}
				}

//				get sections
                $sections = Section::whereHas('organization', function ($query) use ($company_id) {
                    $query->where('company_id', $company_id);
                })->get();



				$dept_positions = PositionManagement::where('company_id', $company_id)
                    ->whereIn('department_id', $company_departments)->get();
				$data = array(
						'is_update' => true,
						'position' => $position,
						'sections' =>$sections,
						'all_users' => $all_users,
						'departments' => $depts,
						'vacancy' => $vacancy,
						'dept_positions' => $dept_positions,
						'ages' => $ages,
						'work_types' => $work_types,
						'education_levels' => $education_levels,
						'rotation_types' => $rotation_types
						);
		} else {
				abort(404);
		}

		return view('admin.pages.planning.position-management.update')->with('data', $data);
	}

	/**
	 * Delete position.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function delete($id, Request $request)
	{
			$position = PositionManagement::find($id);
			$type = $request->input('type');
			$view = $request->input('view');

			if ($position) {
					$success = false;
					$msg = 'An error occured.';
					$position->deleted_at = date('Y-m-d H:i:s');

					if ($position->save()) {
							$success = true;
							$msg = 'Position deleted.';
					}

					return response()->json([
							'success' => $success,
							'position_id' => $position->id,
							'msg' => $msg,
							'type' => $type,
							'view' => $view,
							'return_url' => $request->input('view') == 'department_request' ? url('admin/department-requests') : url('admin/position-management')
					]);
			}
	}

	/**
	 * Monitoring page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function monitoring()
	{
        $data = array(

            'positions'=>PositionManagement::all(),

        );
		return view('admin.pages.planning.position-management.monitoring')->with('data',$data);
	}

    public function save_position(Request $request)
    {
        $user_id = Auth::user()->id;
        $position_id = 0;
        try {

						$validator = $request->input('is_update')
							? Validator::make($request->all(), [
                'reference_no'     => 'required',
                'title' => 'required',
                'total_positions' => 'required'
							])
							: Validator::make($request->all(), [
                'reference_no'     => 'required',
                'title' => 'required',
                'total_positions' => 'required',
                        //'section_id'=>'required',// all position do not have dept & section, new logic
                'due_date'=>'required'
            ]);
            if ($validator->fails()) {
                return response()->json(['success' => false,'errors'=>$validator->getMessageBag()->toArray()]);
            }

            if($request->input('is_update')){
                $position = PositionManagement::find($request->input('listing_id'));
            }else{
                $position = new PositionManagement();
            }

            $position->reference_no = $request->input('reference_no');
            $position->created_by = $user_id;
            $position->company_id = Auth::user()->company_id;
            $position->title = $request->input('title');
            $local_positions = $request->input('local_positions')?$request->input('local_positions'):0;
            $expat_positions = $request->input('expat_positions')?$request->input('expat_positions'):0;
            $position->other_positions = $request->input('other_positions')?$request->input('other_positions'):0;
            $position->local_positions = $local_positions;
            $position->expat_positions = $expat_positions;


            if($request->input('total_positions'))
            {
                $position->total_positions = $request->input('total_positions');
            }else{
                $total_positions = $expat_positions + $local_positions;
                $position->total_positions = $total_positions;
                if($total_positions < 1)
                {
                    return response()->json([
                        'success' => false,
                        'position_id' => 0,
                        'message' =>"Total positions can not be 0!"
                    ]);
                }
            }


            $position->notes = $request->input('notes');
            $position->job_description = $request->input('notes');

            if($request->input('div_id'))
            {
                $position->div_id =   $request->input('div_id');
            }

            if($request->input('department_id'))
            {
                $position->department_id = $request->input('department_id');
            }
            if($request->input('section_id'))
            {
                $position->section_id = $request->input('section_id');
            }
            if($request->input('due_date'))
            {
                $position->due_date = db_date_format($request->input('due_date'));
            }

						$position->location = $request->input('location');
						$position->is_lock = $request->input('is_lock') ? 1 : 0;

            if(!$request->input('is_update')){
                $position->created_at = date('Y-m-d H:i:s');

            }
            $position->updated_at = date('Y-m-d H:i:s');

            if($position->save())
            {
                $position_id = $position->id;
                $total_positions = $position->total_positions ? $position->total_positions : 0;
                $positions_filled = $position->positions_filled ? $position->positions_filled : 0;
                if($positions_filled >= $total_positions)
                {
                    PositionManagement::where('id', $position_id)
                        ->update([
                            'status'=> 'close',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                }else{
                    PositionManagement::where('id', $position_id)
                        ->update([
                            'status'=> 'open',
                            'updated_at' => date('Y-m-d H:i:s')
                        ]);
                }

				if ($request->input('create_vacancy')) {
									if ($request->input('vacancy_id')) {
										$job = Vacancy::find($request->input('vacancy_id'));
									}
									else {
                                    $job = new Vacancy();
									}

									$my_files = '';
									if ($request->hasFile('file')) {
										$files = Arr::wrap($request->file('file'));
										$filesPath = [];
										$path = generatePath('vacancies');

										foreach ($files as $file) {
											$filename = generateFileName($file, $path);
											$file->storeAs(
												$path,
												$filename.'.'.$file->getClientOriginalExtension(),
												config('app.storage.disk', 'public')

											);

											array_push($filesPath, [
												'download_link' => $path.$filename.'.'.$file->getClientOriginalExtension(),
												'original_name' => $file->getClientOriginalName(),
												'file_size' => $file->getSize(),
											]);
										}

										$my_files = json_encode($filesPath);
									}

                                    $job->position_id = $position_id;
                                    $job->created_by = $user_id;
                                    $job->company_id = Auth::user()->company_id;
									$job->job_ref_no = $request->input('job_ref_no');
									$job->job_title = $request->input('job_title');
                                    $job->job_description = $request->input('notes');
                                    $job->created_at = date('Y-m-d H:i:s');
                                    $job->updated_at = date('Y-m-d H:i:s');
                                    $job->location = $request->input('location');
									$job->gender = $request->input('gender');
									$job->nationality = $request->input('nationality');
									$job->age = $request->input('age');
									$job->education_level = $request->input('education_level');
									$job->work_type = $request->input('work_type');
									$job->salary = $request->input('salary');
									$job->report_to = $request->input('report_to');
									$job->status = 'open';
									$job->rotation_pattern = $request->input('rotation_pattern');
                                    if($request->input('department_id'))
                                    {
                                        $job->dept_id = $request->input('department_id');
                                    }

									if ($request->input('job_purpose'))
									$job->job_purpose = $request->input('job_purpose');

									if ($request->input('duty_responsibility'))
									$job->duty_responsibility = $request->input('duty_responsibility');

									if ($request->input('certifications'))
									$job->certifications = $request->input('certifications');

									if ($request->input('experience_details'))
									$job->experience_details = $request->input('experience_details');

									if ($request->input('skills'))
									$job->skills = $request->input('skills');

									if ($request->input('others'))
									$job->others = $request->input('others');

									if ($my_files != '') {
										$job->attachments = $my_files;
									}

                                    $job_id = $job->save();
									//as business logic, if plan approved , he can not add new position or JD so no need to check here


								}

				//set session
                if (!$request->input('create_vacancy'))
                {
                    Session::flash('alert-message', 'Please fill JD also to show on Candidate side');
                    Session::flash('alert-type', 'warning');
                }

                $message = "Saved Successfully! ";
                return response()->json([
                    'success' => true,
                    'position_id' => $position_id,
										'message' =>$message,
										'vacancy' => $request->input('create_vacancy')
                ]);
            }else{
                $message = "Error Occured!";
                return response()->json([
                    'success' => false,
                    'position_id' => $position_id,
                    'message' =>$message
                ]);
            }

        } catch (\Exception $e) {

            $message =  $e->getMessage();
            return response()->json([
                'success' => false,
                'position_id' => $position_id,
                'message' =>$message
            ]);
        }
    }



    public function position_filter(Request $request)
    {
        $position_data = array();
        $positions = PositionManagement::select("*");
        $draw = $request->get('draw');
        $start = $request->get('start');
        $length = $request->get('length');
        $is_filter = false;
        $search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
        if($search)
        {
            $is_filter = true;
            $positions->where('reference_no','like', '%'.$request->get('search')['value'].'%');
        }
        if (!Auth::user()->hasRole('itfpobadmin')) {
             $positions->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }
        if($is_filter){
            $total_positions = count($positions->get());
            $positions = $positions->offset($start)->limit($length)->orderBy('id', 'desc')->get();

        }else{
            $positions = PositionManagement::all();
            $total_positions = count($positions);
            $positions = PositionManagement::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
        }

        $count = 0;
        foreach ($positions as $position) {
            $position_data[$count][] = $position->id;
            $position_data[$count][] = $position->reference_no;
            $position_data[$count][] = $position->title;
            $position_data[$count][] = $position->department? $position->department->department_short_name: '';
            $position_data[$count][] = $position->total_positions;
            $position_data[$count][] = $position->positions_filled;
            $position_data[$count][] = $position->createdBy->getName();
            $position_data[$count][] = $position->created_at;
            $position_data[$count][] = $position->job_description;
            $position_data[$count][] = "";
            $count++;

        }

        $data = array(
            'draw'            => $draw,
            'recordsTotal'    => $total_positions,
            'recordsFiltered' => $total_positions,
            'data' => $position_data
        );
        return json_encode($data);
    }

    public function getPositionHTMLData(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $id = $request->input('section_id');
            $positions = PositionManagement::where('section_id',$id)->get();
						$new_plan = $request->input('new_plan');

            $returnHTML_list = view('admin.partials.positions_list')->with(compact('positions', $positions, 'new_plan'))->render();


            return response()->json(array('success' => true, 'list_data' => $returnHTML_list));
        }
    }

    public function getPositionHTMLDataTable(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $id = $request->input('div_id');

//            $positions = DB::table("positions")->select('*')
//                ->whereIn('department_id',function($query)use ($id){
//                    $query->select('id')->from('departments')->where('div_id',$id);
//                })
//                ->get();
            //new logic, division can directly have positions without dept & section
            $positions = DB::table("positions")->select('*')
                ->where('div_id','=', $id)->get();

            $division = Division::select('id', 'short_name')
                ->where('id','=', $id)
                ->first();

						$new_plan = $request->input('new_plan');

            $returnHTML_list = view('admin.partials.positions_list_table')->with(compact('positions', $positions,
                'division',$division, 'new_plan'))->render();


            return response()->json(array('success' => true, 'list_data' => $returnHTML_list));
        }
    }

    public function getPositionHTMLDataTableService(Request $request)
    {
        if ($request->isMethod('post') && $request->ajax()) {
            $id = $request->input('list_id');
            $type = $request->input('type');
            if($type == 'sec-dept-lst')
            {
                $positions = DB::table("positions")->select('*')
										->where('department_id',$id)
										->where('deleted_at', null)
                    ->get();
                $division = DepartmentManagement::select('id', 'department_short_name as short_name')
                    ->where('id','=', $id)
                    ->first();
            }else{
                $positions = DB::table("positions")->select('*')
                    ->where('section_id',$id)
                    ->get();
                $division = Section::select('id', 'short_name')
                    ->where('id','=', $id)
                    ->first();
            }





            $returnHTML_list = view('admin.partials.positions_list_table')->with(compact('positions', $positions,
                'division',$division))->render();


            return response()->json(array('success' => true, 'list_data' => $returnHTML_list));
        }
    }

    public function export_docx($id=0)
    {
        $position = PositionManagement::findOrFail($id);
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

				$phpWord->getSettings()->setZoom(150);

        $section = $phpWord->addSection();
				$header = $section->addHeader();
				$headerFontStyle = array('size' => 10, 'bold' => true, 'color' => '1c4a79', 'name' => 'Calibri Light');
				$headerParagraphStyle = array('alignment' => 'center', 'spaceAfter' => 100);

				// $section->addImage(asset('img/a1.jpg'));
				$company_name = $position->company ? $position->company->company_name : '';
				$header->addText($company_name, $headerFontStyle, $headerParagraphStyle);
				$header->addText('Job Description', $headerFontStyle, array('alignment' => 'center', 'spaceAfter' => 300));

        $tableStyle = array(
					'borderColor' => '000000',
					'borderSize'  => 1,
					'cellMargin'  => 100,
					'position'		=> ['vertAnchor' => 'page']
				);
				$firstRowStyle = array('bgColor' => '66BBFF');
				$firstColumnStyle = array('size' => 10, 'bold' => true, 'color' => '000000', 'name' => 'Georgia', 'cellSpacing' => 10);
				$phpWord->addTableStyle('myTable', $tableStyle/*, $firstRowStyle*/);
				$table = $section->addTable('myTable');

        $table->addRow();
				$table->addCell(2500)->addText('Position title', $firstColumnStyle);
				$table->addCell(7000)->addText($position->vacancy ? $position->vacancy->job_title : $position->title);

        $table->addRow();
				$table->addCell(2500)->addText('Position status', $firstColumnStyle);
				$table->addCell(7000)->addText($position->status);

        $table->addRow();
				$table->addCell(2500)->addText('Position reports to', $firstColumnStyle);
				$table->addCell(7000)->addText($position->vacancy && $position->vacancy->reportTo ? $position->vacancy->reportTo->title : '-');

				$table->addRow();
				$table->addCell(2500)->addText('Department', $firstColumnStyle);
				$table->addCell(7000)->addText($position->department?$position->department->department_name:'-');

        $table->addRow();
				$table->addCell(2500)->addText('Rotation pattern', $firstColumnStyle);
				$table->addCell(7000)->addText($position->vacancy && $position->vacancy->rotationType ? $position->vacancy->rotationType->title : '-' );

				// $section = $phpWord->addSection();
				$labelFontStyle = array('size' => 10, 'bold' => true, 'color' => '000000', 'name' => 'Georgia', 'bgColor' => 'e0e0e0');

				$section->addText('Job purpose', $labelFontStyle, array('spaceBefore' => 500));
				$section->addText($position->vacancy && $position->vacancy->job_purpose ? $position->vacancy->job_purpose : '-');
                $section->addTextBreak(1);


				$section->addText('Duties and responsibilities', $labelFontStyle);
				$section->addText($position->vacancy && $position->vacancy->duty_responsibility ? $position->vacancy->duty_responsibility : '-' );
                $section->addTextBreak(1);

				$section->addText('Qualification &amp; Training Requirements', $labelFontStyle);
				$section->addText($position->vacancy && $position->vacancy->certifications ? $position->vacancy->certifications : '-');
                $section->addTextBreak(1);

				$section->addText('Experience', $labelFontStyle);
                $section->addText($position->vacancy && $position->vacancy->experience_details ? $position->vacancy->experience_details : '-');
				$section->addTextBreak(1);

				$section->addText('Language proficiency, computer and software skills', $labelFontStyle);
				$section->addText($position->vacancy && $position->vacancy->skills ? $position->vacancy->skills : '-');
				$section->addTextBreak(1);

				$section->addText('Skills', $labelFontStyle);
                $section->addText($position->vacancy && $position->vacancy->others ? $position->vacancy->others : '-');
				$section->addTextBreak(1);


				$sigTable = $section->addTable(array('cellMargin'  => 100));
				$sigTableStyle = array('size' => 10, 'color' => '000000', 'name' => 'Georgia', 'cellSpacing' => 10);
				$small = array('size' => 8, 'color' => '000000', 'name' => 'Georgia', 'cellSpacing' => 10);

				$sigTable->addRow();
				$sigTable->addCell(4500)->addText('Line Manager: (name) ________________', $sigTableStyle);
				$sigTable->addCell(4500)->addText('Employee: (name) ____________________', $sigTableStyle);

				$sigTable->addRow();
				$sigTable->addCell(4500)->addText('________________________________', $sigTableStyle);
				$sigTable->addCell(4500)->addText('________________________________', $sigTableStyle);

				$sigTable->addRow();
				$sigTable->addCell(4500)->addText('(signature, date)', $small);
				$sigTable->addCell(4500)->addText('(signature, date)', $small);


        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path('JD-'.$id.'.docx'));
        } catch (Exception $e) {
        }
        return response()->download(storage_path('JD-'.$id.'.docx'));
    }

	/**
	 * Get position
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function getPosition($id)
	{
		$position = PositionManagement::findOrFail($id);

		return response()->json([
			'position' => $position
		]);
	}

}
