<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

use App\CompanyContractor;

class CompanyContractorsExport implements FromView, WithEvents
{
	public function __construct(int $id = 0)
	{
		$this->contractor_id = $id;
	}

	/**
     * @return array
     */
    public function registerEvents(): array
    {
			return [
				AfterSheet::class    => function(AfterSheet $event) {
					$event->sheet->getStyle('A1:L999')->getNumberFormat()->setFormatCode(\PhpOffice\PhpSpreadsheet\Style\NumberFormat::FORMAT_NUMBER);
				}
			];
    }

	public function view(): View
	{
		$id = $this->contractor_id;

		if ($id) {
			$contractors = CompanyContractor::where('id', $id)->get();
		}
		else {
			$contractors = CompanyContractor::where('company_id', Auth::user()->company_id)
																			->where('deleted_at', null)
																			->get();
		}

		return view('admin.pages.exports.company_contractors', [
				'contractors' => $contractors
		]);
	}
}
