<?php

namespace App\Imports;

use App\Potency;
use App\Sales;
use App\Customers;
use App\Services;
use App\Offices;
use App\SbuNames;
use DB;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\WithCalculatedFormulas;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class PotencyImport implements ToCollection, WithHeadingRow, WithCalculatedFormulas
{
    private $baris = 0;
    use Importable;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {

        foreach ($rows as $row) {

        $row['id_sbu'] = SbuNames::where("sbu_region", "like", "%".$row['sbu_region']."%")->first()->id_sbu;
        //$row['id_sales'] = Sales::where("nama_sales", "like", "%".$row['sales']."%")->first()->id_sales;
        $row['id_pelanggan'] = Customers::where("nama_pelanggan", "like", "%".$row['nama_pelanggan']."%")->first()->id_pelanggan;
        $row['id_service'] = Services::where("segmen_service", "like", "%".$row['service']."%")->first()->id_service;
        $row['id_kantor'] = Offices::where("nama_kantor", "like", "%".$row['kantor']."%")->first()->id_kantor;
		
		$real_quote1 = $row['real_quote'];
		if ($real_quote1 == '') {
			$real_quote2 = empty($row['real_quote']) ? NULL : date("Y-m-d", strtotime($row['real_quote']));
		} else if ($real_quote1 != '') {
			$real_quote2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['real_quote']);
		} 

		$real_nego1 = $row['real_nego'];
		if ($real_nego1 == '') {
			$real_nego2 = empty($row['real_nego']) ? NULL : date("Y-m-d", strtotime($row['real_nego']));
		} else if ($real_nego1 != '') {
			$real_nego2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['real_nego']);
		} 
		
		$real_po1 = $row['real_po'];
		//$real_quote = empty($row['real_quote']) ? NULL : date("Y-m-d", strtotime($row['real_quote']));
		if ($real_po1 == '') {
			$real_po2 = empty($row['real_po']) ? NULL : date("Y-m-d", strtotime($row['real_po']));
		} else if ($real_po1 != '') {
			$real_po2 = \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['real_po']);
		} 

            if (DB::table('potencies')->select('id_pelanggan','id_service','kapasitas','satuan_kapasitas','terminating','qty')
                ->where("id_pelanggan",$row['id_pelanggan'])
                ->where("id_service",$row['id_service'])
                ->where("kapasitas",$row['kapasitas'])
                ->where("satuan_kapasitas",$row['satuan_kapasitas'])
                ->where("terminating",$row['terminating'])
                ->where("qty",$row['qty'])->first()){
                //++$this->baris;
            } else {
                ++$this->baris;
            Potency::firstOrCreate([
            'id_pelanggan' => $row['id_pelanggan'],
            'id_service' => $row['id_service'],
            'kapasitas' => $row['kapasitas'], 
            'satuan_kapasitas' => $row['satuan_kapasitas'],
            'terminating' => $row['terminating'],
            'qty' => $row['qty'],
            ],
            [
            'id_sbu' => $row['id_sbu'],
            //'id_sales' => $row['id_sales'], 
            'id_pelanggan' => $row['id_pelanggan'],
            //'id_pelanggan' => $row['id_pelanggan'],
            //'id_pelanggan' => $row['id_pelanggan'],
            'id_service' => $row['id_service'],
            'kapasitas' => $row['kapasitas'], 
            'satuan_kapasitas' => $row['satuan_kapasitas'],
            'originating' => $row['originating'],
            'terminating' => $row['terminating'],
            'sbu_originating' => $row['sbu_originating'],
            'sbu_terminating' => $row['sbu_terminating'], 
            'instalasi_otc' => $row['instalasi_otc'],
            'sewa_bln' => $row['sewa_monthly'],
            'qty' => $row['qty'],
            'target_aktivasi_bln' => $row['target_aktivasi_bulan_aktivasi'],
            'update_action_plan' => $row['update_action_plan'], 
            'target_quote' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['target_quote']),
            'real_quote' => $real_quote2,
            'quote_late' => $row['quote_late'],
            'target_nego' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['target_nego']),
            'real_nego' => $real_nego2, 
            'nego_late' => $row['nego_late'],
            'target_po' => \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($row['target_po']),
            'real_po' => $real_po2,
            'po_late' => $row['po_late'],
            'warna_potensi' => $row['warna_status_potensi'], 
            'revenue_formula' => $row['revenue_formula'],
            //'id_service' => $row['id_service'],
            //'id_service' => $row['id_service'],
            //'id_pelanggan' => $row['id_pelanggan'],
            'id_kantor' => $row['id_kantor'], 
            'anggaran_pra_penjualan' => $row['anggaran_pra_penjualan']
            ]);
            }
        }
    }

    public function getRowCount(): int
    {
        return $this->baris;
    }
}
