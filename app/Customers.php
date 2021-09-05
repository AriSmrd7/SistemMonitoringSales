<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customers extends Model
{
    protected $table = "customers";

    protected $fillable = ['nama_pelanggan','id_sales','jenis_pelanggan','jumlah_site','status_pelanggan','kategori_pelanggan'];

    public function parent()
	{
   		return $this->belongsTo('Customers', 'id_pelanggan');
	}

	public function children()
	{
   		return $this->hasMany('Customers', 'id_pelanggan');
	}

	public function sales()
	{
   		return $this->belongsTo('App\Models\Sales','id_sales');
	}
}
