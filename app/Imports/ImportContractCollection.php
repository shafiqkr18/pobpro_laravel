<?php
namespace App\Imports;
use App\CompanyContract;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use DB;
use Session;
use App\User;


class ImportContractCollection implements ToCollection
{
    public function collection(Collection $rows)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $rows = $rows->slice(1)->take(100);
        foreach ($rows as $row) {
            if (!empty($row[0]) && isset($row[0]) && isset($row[1])) {
                $cContract = new CompanyContract();
                $cContract->created_at = date('Y-m-d H:i:s');
                $cContract->tender_reference = trim($row[0]);
                $cContract->tender_title = trim($row[1]);

                $cContract->amount = trim($row[4]);
                $cContract->currency = trim($row[5]);
                $cContract->location = trim($row[6]);
                $cContract->primary_term = trim($row[7]);
                $cContract->notes = trim($row[8]);
                $start_date = trim($row[2]);
                $end_date = trim($row[3]);
                if(!empty($start_date))
                {
                      $start_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($start_date);
                }
                if(!empty($end_date))
                {
                   $end_date = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($end_date);
                }
                $cContract->start_date = $start_date;
                $cContract->end_date = $end_date;

                $cContract->created_by = $user_id;
                $cContract->company_id = Auth::user()->company_id;
                if ($cContract->save()) {
                    $contract_id = $cContract->id;
                    $success = true;
                    $message = 'Contract submitted';
                }
            }
        }
    }
}
