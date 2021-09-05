<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Offices;
use DB;
use Session;
use Illuminate\Support\Facades\Cache;
use DataTables;


class OfficeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }
    public function json(){
			$data = Offices::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="office/'.$row->id_kantor.'/edit" class="edit btn btn-primary btn-sm"> <i class="fa fa-edit"></i> Edit</a>';

                           $btn = $btn.'<a href="office/delete/'.$row->id_kantor.'"class="btn btn-danger btn-sm" onclick="return ConfirmDelete();")> <i class="fa fa-trash"></i> Hapus</a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function index(){
        return view('pages.office');
    }

    public function create()
    {
        return view('pages.add_office');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // insert data ke table kantor
        DB::table('offices')->insert([
            'id_kantor' => $request->id_kantor,
            'nama_kantor' => $request->nama_kantor
        ]);

        Session::flash('admin_office_add','Data Kantor Berhasil Ditambahkan');
        // alihkan halaman ke halaman kantor
        return redirect('/admin/office');
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
        $kantor = DB::table('offices')->where('id_kantor',$id)->get();
    // passing data pegawai yang didapat ke view edit.blade.php
        return view('pages.edit_office',['kantor' => $kantor]);
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
        DB::table('offices')->where('id_kantor',$request->id)->update([
        'nama_kantor' => $request->nama_kantor
    ]);

        Session::flash('admin_office_edit','Data Kantor Berhasil Diedit');
        return redirect('/admin/office');
    }


	public function delete($id)
	{
		DB::table('offices')->where('id_kantor',$id)->delete();
        Session::flash('admin_office_delete','Data Kantor Berhasil Dihapus');
		return redirect('/admin/office');
	}

}
