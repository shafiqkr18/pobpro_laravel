<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\CompanyContract;

class CompanyContractsExport implements FromView, WithEvents
{
	public function __construct(int $id = 0)
	{
		$this->contract_id = $id;
	}

	/**
     * @return array
     */
    public function registerEvents(): array
    {
			return [
				AfterSheet::class    => function(AfterSheet $event) {
					$event->sheet->getStyle('A1:L999')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
				}
			];
    }

	public function view(): View
	{
		$id = $this->contract_id;

		if ($id) {
			$contracts = CompanyContract::where('id', $id)->get();
		}
		else {
			$contracts = CompanyContract::where('company_id', Auth::user()->company_id)
																	->where('deleted_at', null)
																	->get();
		}

		return view('admin.pages.exports.company_contracts', [
				'contracts' => $contracts
		]);
	}
}
