<?php

namespace App\Http\Controllers;

use App\Exports\PlansExport;
use App\Exports\PlansPdfExport;
use App\PlanExport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\PlansPdf;

class PlanExportController extends Controller
{
    //
    public function export_plans($id,Request $request)
    {
        if($id < 1)
        {
            abort(404);
        }
        $file_name = 'plan-'.$id."-.xlsx";
        return Excel::download(new PlansExport($id), $file_name);
    }
    public function export_plans_pdf($id,Request $request)
    {
        if($id < 1)
        {
            abort(404);
        }
        $file_name = 'plan-'.$id."-.pdf";
				// return Excel::download(new PlansPdfExport($id), $file_name, \Maatwebsite\Excel\Excel::TCPDF);

			$plans = PlanExport::where('id',$id)->first();
			$company = Auth::user()->company?Auth::user()->company->company_name:'';
			$recruitment_type = $plans->recruitmentType?$plans->recruitmentType->title:'';

			$rows = '';

			$html = view('admin.pages.exports.plans_pdf', [
            'plans' => $plans,'company'=>$company,'recruitment_type' =>$recruitment_type
        ])->render();
				
			$pdf = new PlansPdf('L');


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

    public function export_plans_test($id)
    {
			$plans = PlanExport::where('id',$id)->first();
			$company = Auth::user()->company?Auth::user()->company->company_name:'';
			$recruitment_type = $plans->recruitmentType?$plans->recruitmentType->title:'';
			
			return view('admin.pages.exports.plans_pdf', compact(
				'plans',
				'company',
				'recruitment_type'
			));
    }
}
