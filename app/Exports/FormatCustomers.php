<?php

namespace App\Exports;

use App\Potency;
use App\Sales;
use App\Customers;
use App\Services;
use App\Offices;
use App\SbuNames;
use DB;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithStrictNullComparison;
use Maatwebsite\Excel\Concerns\WithHeadings; 
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithEvents;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use Maatwebsite\Excel\Events\AfterSheet;

class FormatCustomers implements WithHeadings, ShouldAutoSize, WithEvents, WithStrictNullComparison
{

    public function _construct(InvoicesRepository $invoices)
    {
        $this->potencies = $invoices;
    }

    public function headings(): array
    {
        return [
            'NAMA PELANGGAN', 'NAMA SALES', 'JENIS PELANGGAN', 'JUMLAH SITE', 'STATUS PELANGGAN', 'KATEGORI PELANGGAN'
        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:F1';
                $cellHeader = 'A1:F1';
                $event->sheet->getDelegate()->getStyle($cellHeader)->applyFromArray([
                    'font' => [
                        'bold' => true
                    ],
                ]);

                $event->sheet->getDelegate()->getStyle($cellRange)->applyFromArray([
                    'borders' => [
                        'allBorders' => [
                            'borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN,
                            'color' => ['argb' => '00000000'],
                        ],
                    ]
                ]);
            },
        ];
    }
}
