<?php
namespace App\Imports;
use App\CompanyContractor;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ToCollection;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

use DB;
use Session;
use App\User;


class ImportContractorCollection implements ToCollection
{
    public function collection(Collection $rows)
    {
        $user_id = Auth::user()->id;
        $company_id = Auth::user()->company_id;
        $rows = $rows->slice(1)->take(100);
        foreach ($rows as $row) {
            if (!empty($row[0]) && isset($row[0]) && isset($row[1])) {
                $cContractor = new CompanyContractor();
                $cContractor->created_at = date('Y-m-d H:i:s');
                $cContractor->reference_number = trim($row[0]);
                $cContractor->title = trim($row[1]);
                $cContractor->contact_person = trim($row[2]);
                $cContractor->email = trim($row[3]);
                $cContractor->phone = trim($row[4]);
                $cContractor->fax = trim($row[5]);
                $cContractor->website = trim($row[6]);
                $cContractor->address = trim($row[7]);
                $cContractor->city = trim($row[8]);
                $cContractor->country = trim($row[8]);
                $cContractor->created_by = $user_id;
                $cContractor->company_id = Auth::user()->company_id;
                if ($cContractor->save()) {
                    $contractor_id = $cContractor->id;
                    $success = true;
                    $message = 'Contractor submitted';
                }
            }
        }
    }
}
