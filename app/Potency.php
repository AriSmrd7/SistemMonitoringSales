<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Potency extends Model
{

	protected $table = "potencies";
	protected $dates = ['target_quote','target_nego','target_po','updated_at','created_at'];

    protected $fillable = [
        'id_sbu', 'id_pelanggan', 'id_service', 'kapasitas','satuan_kapasitas','id_kantor','originating','terminating','sbu_terminating','sbu_originating','instalasi_otc','sewa_bln','qty','target_aktivasi_bln','revenue_formula','target_quote','real_quote','quote_late','target_nego','real_nego','nego_late','target_po','real_po','po_late','warna_potensi','revenue_formula','update_action_plan','anggaran_pra_penjualan'];

    public static function whereBetween(string $string, array $array)
    {
    }

    public function parent()
	{
   		return $this->belongsTo('Potency', 'id_potensi');
	}

	public function children()
	{
   		return $this->hasMany('Potency', 'id_potensi');
	}

	public function sbu()
	{
   		return $this->belongsTo('App\Models\SbuNames','id_sbu');
	}

	public function sales()
	{
   		return $this->belongsTo('App\Models\Sales','id_sales');
	}

	public function pelanggan()
	{
   		return $this->belongsTo('App\Models\Customers','id_pelanggan');
	}

	public function service()
	{
   		return $this->belongsTo('App\Models\Services','id_service');
	}

	public function kantor()
	{
   		return $this->belongsTo('App\Models\Offices','id_kantor');
	}
}
