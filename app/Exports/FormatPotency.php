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

class FormatPotency implements WithHeadings, ShouldAutoSize, WithEvents, WithStrictNullComparison
{

    public function _construct(InvoicesRepository $invoices)
    {
        $this->potencies = $invoices;
    }

    public function headings(): array
    {
        return [
            'SBU REGION', 'NAMA PELANGGAN', 'SALES', 'STATUS PELANGGAN', 'SEGMEN', 'SERVICE', 'KAPASITAS', 'SATUAN KAPASITAS', 'ORIGINATING', 'TERMINATING', 'SBU ORIGINATING', 'SBU TERMINATING', 'INSTALASI (OTC)', 'SEWA (MONTHLY)', 'QTY', 'TARGET AKTIVASI (BULAN AKTIVASI)', 'UPDATE ACTION PLAN', 'TARGET QUOTE', 'REAL QUOTE', 'QUOTE LATE', 'TARGET NEGO', 'REAL NEGO', 'NEGO LATE', 'TARGET PO', 'REAL PO', 'PO LATE', 'WARNA STATUS POTENSI', 'REVENUE FORMULA', 'KATEGORI', 'JARINGAN/NON JARINGAN', 'PLN/PUBLIK', 'KANTOR', 'ANGGARAN PRA PENJUALAN'

        ];
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:AG1';
                $cellHeader = 'A1:AG1';
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
