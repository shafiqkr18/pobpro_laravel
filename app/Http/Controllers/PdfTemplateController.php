<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

use App\User;
use App\PdfTemplate;
use App\MyPdf;
use App\Offer;
use ZipArchive;
class PdfTemplateController extends Controller
{
  /**
	 * Index/List page
	 *
	 * @return View
	 */
	public function index()
	{
		return view('admin.pages.hr.pdf.list');
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
		$ref_no = 'Temp-' . date('YmdHis');


		return view('admin.pages.hr.pdf.create', compact(
			'all_users',
			'user_id',
			'ref_no'
		));
	}

	/**
	 * Detail page
	 *
	 * @return View
	 */
	public function detail($id)
	{
		$template = PdfTemplate::findOrFail($id);

		return view('admin.pages.hr.pdf.detail', compact(
			'template'
		));
	}

	/**
	 * Update page
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update($id)
	{
		$template = PdfTemplate::findOrFail($id);

		return view('admin.pages.hr.pdf.update', compact(
			'template'
		));
	}

	/**
	 * Save template
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function save(Request $request)
	{
		$user_id = Auth::user()->id;
		$listing_id = 0;

		try {
			$validator = Validator::make($request->all(), [
				'reference_no'	=> 'required',
				'title' 				=> 'required',
				'summary' 			=> 'required',
			]);

			if ($validator->fails()) {
				return response()->json(['success' => false, 'errors' => $validator->getMessageBag()->toArray()]);
			}

			if ($request->input('is_update')) {
				$template = PdfTemplate::find($request->input('listing_id'));
			}
			else {
				$template = new PdfTemplate();
			}

			$template->reference_no = $request->input('reference_no');
			$template->type = $request->input('type');
			$template->title = $request->input('title');
			$template->summary = $request->input('summary');
			$template->created_by = $user_id;
			$template->company_id = Auth::user()->company_id;

			if (!$request->input('is_update')){
				$template->created_at = date('Y-m-d H:i:s');
			}
			$template->updated_at = date('Y-m-d H:i:s');

			if ($template->save()) {
				$listing_id = $template->id;
				$message = 'Template ' . $request->input('is_update') ? 'updated.' : 'created.';
				$status = true;
			}
			else {
				$message = 'An error occurred.';
				$status = false;
			}

		} catch (\Exception $e) {
			$status = false;
			$message =  $e->getMessage();
		}

		return response()->json([
			'success' => $status,
			'contract_id' => $listing_id,
			'message' => $message,
			'is_update' => $request->input('is_update')
		]);
	}

	/**
	 * Get templates
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function template_filter(Request $request)
	{
			$template_data = array();
			$templates = PdfTemplate::select("*");
			$draw = $request->get('draw');
			$start = $request->get('start');
			$length = $request->get('length');
			$is_filter = false;
			$search = ($request->get('search')['value'] != '') ? $request->get('search')['value'] : false;
			if($search)
			{
					$is_filter = true;
					$templates->where('reference_no','like', '%'.$request->get('search')['value'].'%');
			}
			if($is_filter){
					$total_templates = count($templates->get());
					$templates = $templates->offset($start)->limit($length)->orderBy('id', 'desc')->get();

			}else{
					$templates = PdfTemplate::all();
					$total_templates = count($templates);
					$templates = PdfTemplate::where('deleted_at', null)->offset($start)->limit($length)->orderBy('id', 'desc')->get();
			}

			$count = 0;
			foreach ($templates as $template) {
					$template_data[$count][] = $template->id;
					$template_data[$count][] = $template->reference_no;
					$template_data[$count][] = $template->type;
					$template_data[$count][] = $template->title;

					$template_data[$count][] = "";
					$count++;

			}

			$data = array(
					'draw'            => $draw,
					'recordsTotal'    => $total_templates,
					'recordsFiltered' => $total_templates,
					'data' => $template_data
			);
			return json_encode($data);
	}



	/**
	 * Generate PDF
	 *
	 * @return PDF
	 */
	public function generate(Request $request)
	{
		$ids = explode(',', $request->input('ids'));
		$offers = Offer::whereIn('id', $ids)->get();
        if (count($offers) > 1) {
            $zip = new ZipArchive();
            $temp_file_name = public_path() . '/rough/my-offers-pdf.zip';
            if ($zip->open($temp_file_name, ZIPARCHIVE::CREATE | ZIPARCHIVE::OVERWRITE) !== TRUE) {
                die ("An error occurred creating your ZIP file.");
            }
        }

		$template = PdfTemplate::where('is_default', 1)->first();

		if (count($offers) > 0) {
			foreach ($offers as $offer) {
                $html = '';
		$html = $template->summary;
				$html = $html .
					$template->createdBy->getName() .
					'<br>' .
			'Human Resources Manager<br>' .
			'<br>' .
			'<br>' .
			'<br>' .
			'<br>' .
			'I <span style="text-decoration: underline; padding: 2px 5px; display: inline-block;">' . ($offer->candidate->name . ' ' . $offer->candidate->last_name) . '</span>, <i>(ID ____________ or passport number ____________)</i> hereby understand and agree to the terms outlined in this offer of employment.<br>' .
			'<br>' .
			'Signed:  _________________________<br>' .
			'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<i>(Name as per the passport or ID)</i><br>' .
			'<br>' .
			'DATE: &nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;/&nbsp;&nbsp;&nbsp;&nbsp;';

				$variables = [
					'{date}',
					'{name}',
					'{email}',
					'{position}',
					'{effective_date}',
					'{contract_end_date}',
					'{days_work}',
					'{days_leave}',
					'{salary}',
                    '{pay_type}',
                    '{pay_days}'
				];

				$duration = $offer->contractDuration ? $offer->contractDuration->title : '1 year';
				//default pay_type is monthly so
                if($offer->pay_type == 2)
                {

                    $pay_type = "Daily Rate";
                    $pay_days = '1 day';
                }else{
                    $pay_type = "Monthly";
                    $pay_days = '30 days';
                }

				$values = [
					date('Y-m-d'),
					$offer->candidate->name . ' ' . $offer->candidate->last_name,
					$offer->candidate->email,
					$offer->position->title,
					date('Y-m-d', strtotime($offer->work_start_date)),
					date('Y-m-d', strtotime($offer->work_start_date . ' + ' . strtolower($duration))),
					28,
					28,
					$offer->offer_amount,
                    $pay_type,
                    $pay_days

				];

				$html = str_replace($variables, $values, $html);

		$pdf = new MyPdf();


		$pdf->SetMargins(20, 30, 20);
		$pdf->SetHeaderMargin(15);
		$pdf->SetFooterMargin(0);
		$pdf->setListIndentWidth(4);

		$pdf->SetAutoPageBreak(TRUE, 20);
		$pdf->SetTitle($template->title);

		$pdf->AddPage();
		$pdf->writeHTML($html, true, false, true, false, '');
		$pdf->lastPage();
		//$pdf->Output($template->title . ' ' .$offer->id . ' ' . $offer->candidate->name . '.pdf','D');
                if(count($offers) == 1)
                {
				$pdf->Output($template->title . ' ' .$offer->id . ' ' . $offer->candidate->name . '.pdf','D');
                }else{
                    $pdf->Output(public_path() . '/rough/offer_' .$offer->id . '.pdf','F');
                    //zip

                    $filepath = public_path() . '/rough/offer_' .$offer->id . '.pdf';
                    $file = $temp_file_name;
                     if (file_exists($filepath)) {
                        $zip->addFile(public_path() . '/rough/offer_' .$offer->id . '.pdf',  'offer_' .$offer->id . '.pdf');
                    } else {
                        die("File $filepath doesnt exit");
                    }


                }
				// save multiple files to storage working but will not open pdf's in new tabs
				// $pdf->Output($_SERVER['DOCUMENT_ROOT'] . '/storage/pdf/'. $template->title . ' ' . $offer->candidate->name . '-' . $offer->id . date('YmdHis') . '.pdf','F');
			}

			if(count($offers)>=1)
            {
                $zip->close();
                 $headers = array(
                    'Content-Type: application/pdf',
                );
                return \Response::download($temp_file_name, 'my-offers.zip', $headers)->deleteFileAfterSend(true);
            }


		}

	}



}
