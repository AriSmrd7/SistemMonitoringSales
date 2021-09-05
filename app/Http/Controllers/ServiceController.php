<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services;
use DB;
use Session;
use Illuminate\Support\Facades\Cache;
use DataTables;

class ServiceController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function json(){
			$data = Services::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="service/'.$row->id_service.'/edit" class="edit btn btn-primary btn-sm"> <i class="mdi mdi-border-color"></i></a>';

                           $btn = $btn.'<a href="service/delete/'.$row->id_service.'"class="btn btn-danger btn-sm" onclick="return ConfirmDelete();")> <i class="mdi mdi-delete-forever "></i></a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function index(){
        return view('pages.service');
    }


    public function create()
    {
        return view('pages.add_service');
    }

    public function store(Request $request)
    {
        // insert data ke table service
        DB::table('services')->insert([
            'id_service' => $request->id_service,
            'segmen_service' => $request->segmen_service,
            'jenis_service' => $request->jenis_service,
            'kategori_service' => $request->kategori_service
        ]);

        Session::flash('admin_service_add','Data Service Berhasil Ditambahkan');
        // alihkan halaman ke halaman pelanggan
        return redirect('/admin/service');
    }

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
        $service = DB::table('services')->where('id_service',$id)->get();
    // passing data pegawai yang didapat ke view edit.blade.php
        return view('pages.edit_service',['service' => $service]);
    }

    public function update(Request $request)
    {
        DB::table('services')->where('id_service',$request->id)->update([
        'segmen_service' => $request->segmen_service,
        'jenis_service' => $request->jenis_service,
        'kategori_service' => $request->kategori_service
    ]);

    Session::flash('admin_service_edit','Data Service Berhasil Diedit');
    // alihkan halaman ke halaman pegawai
    return redirect('/admin/service');
    }

	public function delete($id)
	{
		DB::table('services')->where('id_service',$id)->delete();
        Session::flash('admin_service_delete','Data Service Berhasil Dihapus');
		return redirect('/admin/service');
	}


        // method untuk menampilkan view form tambah pegawai
    public function tambah()
    {

        // memanggil view tambah
        return view('tambah_pegawai');

    }

}
