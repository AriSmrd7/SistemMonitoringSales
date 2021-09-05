<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Customers;
use App\Sales;
use Session;
use DB;
use Illuminate\Support\Facades\Cache;
use DataTables;
use App\Imports\CustomersImport;
use App\Exports\FormatCustomers;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;

class CustomerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function json()
    {

        $customers = DB::table('customers')->JOIN('sales','customers.id_sales','=','sales.id_sales')->get();

            return Datatables::of($customers)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="customer/'.$row->id_pelanggan.'/edit" class="edit btn btn-primary btn-sm"> <i class="mdi mdi-border-color"></i></a>';

                           $btn = $btn.'<a href="customer/delete/'.$row->id_pelanggan.'" class="btn btn-danger btn-sm" onclick="return ConfirmDelete();")> <i class="mdi mdi-delete-forever "></i></a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function index(){
        return view('pages.customer');
    }

    public function create()
    {
        $sales = Sales::all();

        return view('pages.add_customer',compact('sales'));
    }

    public function store(Request $request)
    {
        // insert data ke table pelanggan
        DB::table('customers')->insert([
            'id_pelanggan' => $request->id_pelanggan,
            'nama_pelanggan' => $request->nama_pelanggan,
            'id_sales' => $request->id_sales,
            'jenis_pelanggan' => $request->jenis_pelanggan,
            'jumlah_site' => $request->jumlah_site,
            'status_pelanggan' => $request->status_pelanggan,
            'kategori_pelanggan' => $request->kategori_pelanggan
        ]);

        Session::flash('admin_customer_add','Data Customer Berhasil Ditambah');
        // alihkan halaman ke halaman pelanggan
        return redirect('/admin/customer');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
		$data = Customers::all();
        $sales = Sales::all();

        $customers = DB::table('customers')->where('id_pelanggan',$id)->get();
    // passing data pegawai yang didapat ke view edit.blade.php
        return view('pages.edit_customer',['customers' => $customers],compact('sales'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
       DB::table('customers')->where('id_pelanggan',$request->id)->update([
        'nama_pelanggan' => $request->nama_pelanggan,
        'id_sales' => $request->id_sales,
        'jenis_pelanggan' => $request->jenis_pelanggan,
        'jumlah_site' => $request->jumlah_site,
        'status_pelanggan' => $request->status_pelanggan,
        'kategori_pelanggan' => $request->kategori_pelanggan
    ]);

       Session::flash('admin_customer_edit','Data Customer Berhasil Diedit');
        return redirect('/admin/customer');
    }

	public function delete($id)
	{
		DB::table('customers')->where('id_pelanggan',$id)->delete();
        Session::flash('admin_customer_delete','Data Customer Berhasil Dihapus');
		return redirect('/admin/customer');
	}

    public function import_excel(Request $request)
    {
        // validasi
        $this->validate($request, [
            'file' => 'required|mimes:csv,xls,xlsx'
        ]);

        // menangkap file excel
        $file = $request->file('file');

        // membuat nama file unik
        $nama_file = rand().$file->getClientOriginalName();

        // upload ke folder file_siswa di dalam folder public
        $file->move('file_customers',$nama_file);

        // import data
        $import = new CustomersImport;
        Excel::import($import, public_path('/file_customers/'.$nama_file));

        // notifikasi dengan session
        Session::flash('admin_customer_import','Data Customer Berhasil Diimport. Row count: ' . $import->getRowCount());

        // alihkan halaman kembali
        return redirect('/admin/customer');
    }

    function format_customer()
    {
        return Excel::download(new FormatCustomers, 'Format Data Customers.xlsx');
    }

}
