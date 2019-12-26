<?php

namespace App\Http\Controllers;

use App\Candidate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\Interview;
use App\StatusDetail;
use App\PlansPdf;

class InterviewController extends Controller
{
  /**
	 * List page
	 *
	 * @return View
	 */
	public function list()
	{
		return view('admin.pages.hr.interview.list');
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$user = Auth::user();
		$interview = Interview::findOrFail($id);
		$uuid = $interview->candidate->uuid;

		$view_link = \App::make('url')->to('/candidate/uuid/' . $uuid);
		$name = $interview->candidate ? $interview->candidate->name . ' ' . $interview->candidate->last_name : '';
		$company_name = Auth::user()->company ? Auth::user()->company->company_name : 'ITForce.com';
		$interviewdate = date('n.j.Y', strtotime($interview->interview_date));
		$interviewtime = date('H:i', strtotime($interview->interview_date));
		$location = $interview->location ? $interview->location : '';
		$position = $interview->position ? $interview->position->title : '';

		$temp_var_values = array($view_link, $name, $company_name,$interviewdate,$interviewtime,$location,$position);
		$temp_var = array("{view_link}", "{name}", "{company_name}","{interviewdate}","{interviewtime}","{location}","{position}");
		$template_data = str_replace($temp_var, $temp_var_values, $interview->notes);

		return view('admin.pages.hr.interview.detail', compact(
			'interview',
			'user',
			'template_data'
		));
	}
    function candidate_status(Request $request)
    {
        $message = "Not selected";
        $success = false;
        $candidate_id = $request->input('candidate_id');
        $intv_id = $request->input('intv_id');
        if(!empty($candidate_id))
        {
            $candidate = Candidate::find($candidate_id);
            $candidate->is_qualified = $request->input('rdbtn');
            if ($candidate->save()) {
                $success = true;
                $message = 'Status saved.';

                if($intv_id)
                {
                    $interviW = Interview::find($intv_id);
                    $interviW->is_qualified = $request->input('rdbtn');
										$interviW->comments = $request->input('comments') ? $request->input('comments') : null;
                    $interviW->save();
                }


            }
            else {
                $message = 'An error occurred.';
                $success = false;
            }
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
            'cid'=>$candidate_id

        ]);

    }
	/**
	 * Save interview comment.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function saveComment(Request $request)
	{
		$user_id = Auth::user()->id;
		$success = false;

		try {
			$validator = Validator::make($request->all(), [
				'status_details' => 'required'
			]);

			if ($validator->fails()) {
				return response()->json([
					'success' => false,
					'errors' => $validator->getMessageBag()->toArray()]);
			}

			$status_detail = new StatusDetail();
			$status_detail->listing_id = $request->input('interview_id');
			$status_detail->type = 1;
			$status_detail->status_title = 'comments';
			$status_detail->status_details = $request->input('status_details');
			$status_detail->created_by = $user_id;
			$status_detail->status_datetime = date('Y-m-d H:i:s');
			$status_detail->created_at = date('Y-m-d H:i:s');

			if ($status_detail->save()) {
				$success = true;
				$message = 'Comment saved.';

				$avatar = $status_detail->createdBy->avatar ? json_decode($status_detail->createdBy->avatar, true) : null;
			}
			else {
				$message = 'An error occurred.';
			}
		}
		catch (\Exception $e) {
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $success,
			'message' => $message,
			'comment' => $status_detail,
			'createdBy' => $status_detail->createdBy->getName(),
			'avatar' => $avatar ? asset('/storage/' . $avatar[0]['download_link']) : null
		]);

	}

	/**
	 * Get interviews.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function interview_filter(Request $request)
	{
		$interviews_data = array();
		$interviews = Interview::select("*")->where('deleted_at', null);
		$draw = $request->get('draw');
		$start = $request->get('start');
		$length = $request->get('length');
		$is_filter = false;
		$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;

		if($search) {
			$is_filter = true;
			$interviews->where('name','like', '%'.$request->get('search')['value'].'%');
		}

        if (!Auth::user()->hasRole('itfpobadmin')) {
            $interviews->where('company_id', Auth::user()->company_id);
            $is_filter = true;
        }

		if($is_filter) {
			$total_interviews = count($interviews->get());
			$interviews = $interviews->offset($start)->limit($length)->orderBy('id', 'desc')->get();

		}
		else {
				$interviews = Interview::all();
				$total_interviews = count($interviews);

				if (Auth::user()->hasRole('itfpobadmin')) {
					$interviews = Interview::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
				}
				else {
				$interviews = Interview::where('deleted_at', null)->where('company_id', Auth::user()->company_id)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
		}
		}

		$count = 0;
		foreach ($interviews as $interview) {
			$interviews_data[$count][] = $interview->id;
			$interviews_data[$count][] = $interview->batch_no;
			$interviews_data[$count][] = $interview->candidate ? $interview->candidate->name . ' ' . $interview->candidate->last_name : '';
			$interviews_data[$count][] = date('Y-m-d H:i:s', strtotime($interview->interview_date));
			$interviews_data[$count][] = $interview->candidate && $interview->candidate->position ? $interview->candidate->position->title : '';
			$interviews_data[$count][] = $interview->plan ? $interview->plan->subject : '';
			$interviews_data[$count][] = $interview->is_confirmed;
            $interviews_data[$count][] = $interview->is_qualified;
			$interviews_data[$count][] = "";
			$interviews_data[$count][] = $interview->candidate ? $interview->candidate->id : 0;
			$count++;

		}

		$data = array(
			'draw'            => $draw,
			'recordsTotal'    => $total_interviews,
			'recordsFiltered' => $total_interviews,
			'data' 						=> $interviews_data
		);
		return json_encode($data);
	}

	/**
	 * Generate PDF
	 *
	 * @return PDF
	 */
	public function generatePdf($id, $test = 0)
	{
		$interview = Interview::findOrFail($id);

		$file_name = 'interview-' . $id . '.pdf';
		
		$uuid = $interview->candidate->uuid;
		$view_link = \App::make('url')->to('/candidate/uuid/' . $uuid);
		$name = $interview->candidate ? $interview->candidate->name . ' ' . $interview->candidate->last_name : '';
		$company_name = Auth::user()->company ? Auth::user()->company->company_name : 'ITForce.com';
		$interviewdate = date('n.j.Y', strtotime($interview->interview_date));
		$interviewtime = date('H:i', strtotime($interview->interview_date));
		$location = $interview->location ? $interview->location : '';
		$position = $interview->position ? $interview->position->title : '';

		$temp_var_values = array($view_link, $name, $company_name,$interviewdate,$interviewtime,$location,$position);
		$temp_var = array("{view_link}", "{name}", "{company_name}","{interviewdate}","{interviewtime}","{location}","{position}");
		$template_data = str_replace($temp_var, $temp_var_values, $interview->notes);

		if ($test) {
			return view('admin.pages.exports.interview_pdf', compact(
				'interview',
				'template_data'
			));
		}
		else {
			$html = view('admin.pages.exports.interview_pdf', [
								'interview' => $interview,
								'template_data' => $template_data
							])->render();

			$pdf = new PlansPdf();
			$pdf->SetMargins(10, 10, 10);
			$pdf->SetHeaderMargin(5);
			$pdf->SetFooterMargin(0);
			$pdf->setListIndentWidth(4);

			$pdf->SetAutoPageBreak(TRUE, 20);
			$pdf->SetTitle($file_name);

			$pdf->AddPage();
			$pdf->writeHTML($html, true, false, true, false, '');
			$pdf->lastPage();
			$pdf->Output($file_name,'D');
		}

	}

}
