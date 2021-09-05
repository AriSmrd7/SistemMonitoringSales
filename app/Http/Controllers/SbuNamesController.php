<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SbuNames;
use DB;
use Session;
use Illuminate\Support\Facades\Cache;
use DataTables;

class SbuNamesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function json(){
			$data = SbuNames::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="sbu/'.$row->id_sbu.'/edit" class="edit btn btn-primary btn-sm"> <i class="mdi mdi-border-color"></i></a>';

                           $btn = $btn.'<a href="sbu/delete/'.$row->id_sbu.'"class="btn btn-danger btn-sm" onclick="return ConfirmDelete();")> <i class="mdi mdi-delete-forever "></i></a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function index(){
        return view('pages.sbu');
    }

    public function create()
    {
    	return view('pages.add_sbu');
    }

    public function store(Request $request)
    {
    	// insert data ke table service
        DB::table('sbu_names')->insert([
            'id_sbu' => $request->id_sbu,
            'sbu_region' => $request->sbu_region,
            'sbu_originating' => $request->sbu_originating,
            'sbu_terminating' => $request->sbu_terminating
        ]);

        Session::flash('admin_sbu_add','Data SBU Berhasil Ditambah');
        // alihkan halaman ke halaman pelanggan
        return redirect('/admin/sbu');
    }

    public function show($id)
    {
        //
    }

    public function edit($id)
    {
		$data = SbuNames::all();
    	$sbu = DB::table('sbu_names')->where('id_sbu',$id)->get();
    // passing data pegawai yang didapat ke view edit.blade.php
        return view('pages.edit_sbu',['sbunames' => $sbu, $data]);
    }

    public function update(Request $request)
    {
    	DB::table('sbu_names')->where('id_sbu',$request->id)->update([
        'sbu_region' => $request->sbu_region,
        'sbu_originating' => $request->sbu_originating,
        'sbu_terminating' => $request->sbu_terminating
    	]);

        Session::flash('admin_sbu_edit','Data SBU Berhasil Diedit');
    	// alihkan halaman ke halaman pegawai
    	return redirect('/admin/sbu');
    }

	public function delete($id)
	{
		DB::table('sbu_names')->where('id_sbu',$id)->delete();
        Session::flash('admin_sbu_delete','Data SBU Berhasil Dihapus');
		return redirect('/admin/sbu');
	}

}
