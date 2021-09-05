<?php

namespace App\Imports;

use App\Customers;
use App\Sales;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class CustomersImport implements ToCollection, WithHeadingRow
{
    
    use Importable;
    private $baris = 0;
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function collection(Collection $rows)
    {
        foreach ($rows as $row) {

            $row['id_sales'] = Sales::where("nama_sales", "like", "%".$row['nama_sales']."%")->first()->id_sales;

            if (Customers::where("nama_pelanggan",$row['nama_pelanggan'])->first()){
                //$this->baris;
            } else {
                ++$this->baris;
                Customers::firstOrCreate([
                'nama_pelanggan' => $row['nama_pelanggan'],
            ],
            [
                'id_sales' => $row['id_sales'],
                'jenis_pelanggan' => $row['jenis_pelanggan'], 
                'jumlah_site' => $row['jumlah_site'],
                'status_pelanggan' => $row['status_pelanggan'],
                'kategori_pelanggan' => $row['kategori_pelanggan'],
            ]);

            }
        }
    }

    public function getRowCount(): int
    {
        return $this->baris;
    }
}
