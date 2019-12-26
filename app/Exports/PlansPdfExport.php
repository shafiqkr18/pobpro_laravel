<?php

namespace App\Exports;

use App\PlanExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;

class PlansPdfExport implements FromView
{
    public function __construct(int $id)
    {
        $this->plan_id = $id;
    }
    public function view(): View
    {
        $id = $this->plan_id;
        $plan = PlanExport::where('id',$id)->first();
        $company = Auth::user()->company?Auth::user()->company->company_name:'';
        $recruitment_type = $plan->recruitmentType?$plan->recruitmentType->title:'';

        return view('admin.pages.exports.plans_pdf', [
            'plans' => $plan,'company'=>$company,'recruitment_type' =>$recruitment_type
        ]);
    }
}
