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

class PotencyExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithEvents, WithStrictNullComparison, WithColumnFormatting
{

    public function _construct(InvoicesRepository $invoices)
    {
        $this->potencies = $invoices;
    }

    public function collection()
    {
        return DB::table('potencies')->JOIN('offices','potencies.id_kantor','=','offices.id_kantor')
                                            ->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->JOIN('sales','customers.id_sales','=','sales.id_sales')
                                            ->JOIN('services','potencies.id_service','=','services.id_service')
                                            ->JOIN('sbu_names','potencies.id_sbu','=','sbu_names.id_sbu')
                                            ->get();
    }

    public function headings(): array
    {
        return [
            'SBU REGION', 'NAMA PELANGGAN', 'SALES', 'STATUS PELANGGAN', 'SEGMEN', 'SERVICE', 'KAPASITAS', 'SATUAN KAPASITAS', 'ORIGINATING', 'TERMINATING', 'SBU ORIGINATING', 'SBU TERMINATING', 'INSTALASI (OTC)', 'SEWA (MONTHLY)', 'QTY', 'TARGET AKTIVASI (BULAN AKTIVASI)', 'UPDATE ACTION PLAN', 'TARGET QUOTE', 'REAL QUOTE', 'QUOTE LATE', 'TARGET NEGO', 'REAL NEGO', 'NEGO LATE', 'TARGET PO', 'REAL PO', 'PO LATE', 'WARNA STATUS POTENSI', 'REVENUE FORMULA', 'KATEGORI', 'JARINGAN/NON JARINGAN', 'PLN/PUBLIK', 'KANTOR', 'ANGGARAN PRA PENJUALAN'

        ];
    }

    public function map($preflight): array
    {
        return [
            $preflight->sbu_region,
            $preflight->nama_pelanggan,
            $preflight->nama_sales,
            $preflight->status_pelanggan,
            $preflight->jenis_pelanggan,
            $preflight->segmen_service,
            $preflight->kapasitas,
            $preflight->satuan_kapasitas,
            $preflight->originating,
            $preflight->terminating,
            $preflight->sbu_originating,
            $preflight->sbu_terminating,
            $preflight->instalasi_otc,
            $preflight->sewa_bln,
            $preflight->qty,
            $preflight->target_aktivasi_bln,
            $preflight->update_action_plan,
            Date::stringToExcel($preflight->target_quote),
            Date::stringToExcel($preflight->real_quote),
            $preflight->quote_late,
            Date::stringToExcel($preflight->target_nego),
            Date::stringToExcel($preflight->real_nego),
            $preflight->nego_late,
            Date::stringToExcel($preflight->target_po),
            Date::stringToExcel($preflight->real_po),
            $preflight->po_late,
            $preflight->warna_potensi,
            $preflight->revenue_formula,
            $preflight->kategori_service,
            $preflight->jenis_service,
            $preflight->kategori_pelanggan,
            $preflight->nama_kantor,
            $preflight->anggaran_pra_penjualan,
         ]; 
    }
    
    public function columnFormats(): array
    {
        return [
            'R' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'S' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'U' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'V' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'X' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'Y' => NumberFormat::FORMAT_DATE_DDMMYYYY,
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
