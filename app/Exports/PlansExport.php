<?php

namespace App\Exports;

use App\PlanExport;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class PlansExport implements FromView, WithEvents
{
    public function __construct(int $id)
    {
        $this->plan_id = $id;
		}
		
		/**
     * @return array
     */
    public function registerEvents(): array
    {
			return [
				AfterSheet::class    => function(AfterSheet $event) {
					// $cellRange = 'A1:W1'; // All headers
					// $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(14);

					// $bordered_cells = [
					// 	'borders' => [
					// 		'right' => [
					// 			'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
					// 		],
					// 	],
					// ];
					// $event->sheet->getStyles()->applyFromArray($bordered_cells);

					// $event->sheet->setAllBorders('thin');
					// $event->sheet->getDelegate()->getStyle('A1')->getFont()->setSize(8);

					$event->sheet->getColumnDimension('A')->setWidth(5);
					$event->sheet->getColumnDimension('B')->setWidth(15);
					$event->sheet->getColumnDimension('C')->setWidth(15);
					$event->sheet->getColumnDimension('D')->setWidth(25);
					$event->sheet->getColumnDimension('E')->setWidth(25);
					$event->sheet->getColumnDimension('F')->setWidth(25);
					$event->sheet->getColumnDimension('G')->setWidth(15);
					$event->sheet->getColumnDimension('H')->setWidth(12);
					$event->sheet->getColumnDimension('I')->setWidth(12);
					$event->sheet->getColumnDimension('J')->setWidth(100);

					$row1_styles = [
						'font' => [
							'name' => 'Arial',
							'size' => 14,
							'color' => [
								'rgb' => 'FFFFFF'
							]
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
							'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						],
						'borders' => [
							'bottom' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_MEDIUM,
							],
						],
						'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'rotation' => 90,
							'startColor' => [
								'rgb' => '666795',
							],
						],
					];

					$event->sheet->getStyle('A1:J1')->applyFromArray($row1_styles);
					$event->sheet->getRowDimension('1')->setRowHeight(20);

					$row2_col1_styles = [
						'font' => [
							'name' => 'Arial',
							'bold' => true,
							'size' => 11,
							'color' => [
								'rgb' => 'FFFFFF'
							]
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
							'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						],
						'borders' => [
							'bottom' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
							],
						],
						'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'rotation' => 90,
							'startColor' => [
								'rgb' => 'ff9735',
							],
						],
					];

					$row2_col2_styles = [
						'font' => [
							'name' => 'Arial',
							'bold' => true,
							'size' => 11,
							'color' => [
								'rgb' => 'FFFFFF'
							]
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
							'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						],
						'borders' => [
							'bottom' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_DOUBLE,
							],
						],
						'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'rotation' => 90,
							'startColor' => [
								'rgb' => '99c3e3',
							],
						],
					];

					$event->sheet->getStyle('A2:F2')->applyFromArray($row2_col1_styles);
					$event->sheet->getStyle('G2:J2')->applyFromArray($row2_col2_styles);
					$event->sheet->getRowDimension('2')->setRowHeight(30);

					$row3_grp1_styles = [
						'font' => [
							'bold' => true,
							'size' => 11,
							'color' => [
								'rgb' => 'FFFFFF'
							]
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
							'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						],
						'borders' => [
							'bottom' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
						'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'rotation' => 90,
							'startColor' => [
								'rgb' => 'f17b41',
							],
						],
					];
					$event->sheet->getStyle('A3:F4')->applyFromArray($row3_grp1_styles);

					$row3_grp2_styles = [
						'font' => [
							'bold' => true,
							'size' => 11,
							'color' => [
								'rgb' => 'FFFFFF'
							]
						],
						'alignment' => [
							'horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER,
							'vertical' => \PhpOffice\PhpSpreadsheet\Style\Alignment::VERTICAL_CENTER,
						],
						'borders' => [
							'bottom' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
						'fill' => [
							'fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID,
							'rotation' => 90,
							'startColor' => [
								'rgb' => '4174be',
							],
						],
					];
					$event->sheet->getStyle('G3:J4')->applyFromArray($row3_grp2_styles);

					$bordered_headers = [
						'borders' => [
							'left' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
							'right' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
							'bottom' => [
								'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
							],
						],
					];
					$event->sheet->getStyle('A3:A4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('B3:B4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('C3:C4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('D3:D4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('E3:E4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('F3:F4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('G3:G4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('H3:H4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('H3:I3')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('I3:I4')->applyFromArray($bordered_headers);
					$event->sheet->getStyle('J3:J4')->applyFromArray($bordered_headers);


				},
			];
    }

    public function view(): View
    {
        $id = $this->plan_id;
        $plan = PlanExport::where('id',$id)->first();
        $company = Auth::user()->company?Auth::user()->company->company_name:'';
        $recruitment_type = $plan->recruitmentType?$plan->recruitmentType->title:'';

        return view('admin.pages.exports.plans', [
            'plans' => $plan,'company'=>$company,'recruitment_type' =>$recruitment_type
        ]);
    }
}
