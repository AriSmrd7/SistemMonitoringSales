<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

use Session;
use App\Potency;
use App\Sales;
use App\Customers;
use App\Services;
use App\Offices;
use App\SbuNames;
use App\Exports\PotencyExport;
use App\Imports\PotencyImport;
use App\Exports\FormatPotency;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;
use DataTables;

class PotencyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function json()
    {
		$potencies = DB::table('potencies')->JOIN('offices','potencies.id_kantor','=','offices.id_kantor')
											->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->JOIN('sales','customers.id_sales','=','sales.id_sales')
											->JOIN('services','potencies.id_service','=','services.id_service')
                                            ->JOIN('sbu_names','potencies.id_sbu','=','sbu_names.id_sbu')
                                            ->orderBy(DB::raw('!ISNULL(potencies.real_quote), potencies.real_quote'))
                                            ->orderBy(DB::raw('!ISNULL(potencies.real_nego), potencies.real_nego'))
                                            ->orderBy(DB::raw('!ISNULL(potencies.real_po), potencies.real_po'))
                                            ->orderBy(DB::raw('potencies.target_quote','<','NOW()'))
                                            ->orderBy(DB::raw('potencies.target_nego','<','NOW()'))
                                            ->orderBy(DB::raw('potencies.target_po','<','NOW()'))
                                            ->get();

        return Datatables::of($potencies)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="potensi/'.$row->id_potensi.'/edit" class="edit btn btn-primary btn-sm"> <i class="mdi mdi-border-color"></i></a>';

                           $btn = $btn.'<a href="potensi/'.$row->id_potensi.'/detail" class="btn btn-info btn-sm"> <i class="mdi mdi-eye "></i></a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

	public function index(Request $request)
	{
		$request->session()->forget('potencies');
		return view('pages.potensi');
	}


    function excel()
    {
        return Excel::download(new PotencyExport, 'Data Potensi SBU RJBB.xlsx');
    }

    public function import(Request $request)
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
        $file->move('file_potensi',$nama_file);

        // import data
        $import = new PotencyImport;
        Excel::import($import, public_path('/file_potensi/'.$nama_file));

        // notifikasi dengan session
        Session::flash('admin_potensi_import','Data Potensi Berhasil Diimport. Row count: ' . $import->getRowCount());


        // alihkan halaman kembali
        return redirect('/admin/potensi');
    }

    function format_potensi()
    {
        return Excel::download(new FormatPotency, 'Format Data Potensi.xlsx');
    }

	public function createStepOne(Request $request)
    {
		$sales = Sales::all();
		$customers = Customers::all()->sortBy('nama_pelanggan');
		$services = Services::all()->sortBy('segmen_service');
		$offices = Offices::all();
		$sbunames = SbuNames::all();

        $potencies = $request->session()->get('potencies');
        return view('pages.create-step-one',compact('potencies','sales','customers','services','offices','sbunames', $potencies));
    }

    public function postCreateStepOne(Request $request)
    {
        $validatedData = $request->validate([
            'id_sbu' => 'required',
            'id_pelanggan' => 'required',
            'id_service' => 'required',
            'kapasitas' => 'required',
            'satuan_kapasitas' => 'required',
            'update_action_plan' => 'required|max:20',
            'id_kantor' => 'required'

        ]);

        if(empty($request->session()->get('potencies'))){
            $potencies = new Potency();
            $potencies->fill($validatedData);
            $request->session()->put('potencies', $potencies);
        }else{
            $potencies = $request->session()->get('potencies');
            $potencies->fill($validatedData);
            $request->session()->put('potencies', $potencies);
        }
        return redirect()->route('create.step.two');
    }




    public function createStepTwo(Request $request)
    {
        $sbunames = SbuNames::all();
        $potencies = $request->session()->get('potencies');
        return view('pages.create-step-two',compact('potencies','sbunames', $potencies));
    }

    public function postCreateStepTwo(Request $request)
    {
        $validatedData = $request->validate([
            'originating' => 'nullable',
            'terminating' => 'nullable',
            'sbu_originating' => 'required',
            'sbu_terminating' => 'required'
        ]);
        $potencies = $request->session()->get('potencies');
        $potencies->fill($validatedData);
        $request->session()->put('potencies', $potencies);
        return redirect()->route('create.step.three');
    }


    public function createStepThree(Request $request)
    {
        $potencies = $request->session()->get('potencies');
        return view('pages.create-step-three',compact('potencies', $potencies));
    }

    public function postCreateStepThree(Request $request)
    {
        $validatedData = $request->validate([
            'instalasi_otc' => 'required',
            'sewa_bln' => 'required',
            'qty' => 'required',
            'target_aktivasi_bln' => 'required',
            'revenue_formula' => 'required'
        ]);
        $potencies = $request->session()->get('potencies');
        $potencies->fill($validatedData);
        $request->session()->put('potencies', $potencies);
        return redirect()->route('create.step.four');
    }


    public function createStepFour(Request $request)
    {

        $potencies = $request->session()->get('potencies');
        $month = $potencies->target_aktivasi_bln;
        $year = Carbon::now()->year;
        $time = $month.'-01-'.$year;
        $aktivasi = \DateTime::createFromFormat('m-d-Y', $time)->format('Y-m-d');
        $po = date('Y-m-d', strtotime($aktivasi. ' - 30 days'));
        $nego = date('Y-m-d', strtotime($po. ' - 20 days'));
        $quote = date('Y-m-d', strtotime($nego. ' - 30 days'));
        return view('pages.create-step-four',compact('potencies', $potencies),['nego' => $nego,'quote' => $quote,'po' => $po]);
    }

    public function postCreateStepFour(Request $request)
    {
        $validatedData = $request->validate([
            'target_quote' => 'required|date',
            'target_nego' => 'required|date|after:target_quote',
            'target_po' => 'required|date|after:target_nego',
            'warna_potensi' => 'required',
            'anggaran_pra_penjualan' => 'required'
        ]);
        $potencies = $request->session()->get('potencies');
        $potencies->fill($validatedData);
        $request->session()->put('potencies', $potencies);
        return redirect()->route('create.step.five');
    }



    public function createStepFive(Request $request)
    {   

        $potencies = $request->session()->get('potencies');
        $sales = $potencies->id_pelanggan;
        $service = $potencies->id_service;
        $sbu = $potencies->id_sbu;
        $nama_sales = DB::table('customers')->select('nama_pelanggan')->where('id_pelanggan','=', $sales)->get();
        $nama_service = DB::table('services')->select('segmen_service')->where('id_service','=', $service)->get();
        $nama_sbu = DB::table('sbu_names')->select('sbu_region')->where('id_sbu','=', $sbu)->get();
        return view('pages.create-step-five',compact('potencies'),['nama_sales' => $nama_sales,'nama_service' => $nama_service,'nama_sbu' => $nama_sbu]);
    }


    public function postCreateStepFive(Request $request)
    {
        $potencies = $request->session()->get('potencies');
        $potencies->save();
        $request->session()->forget('potencies');
        Session::flash('admin_potensi_add','Data Potensi Berhasil Ditambah');
        return redirect()->route('potensi');
    }

    public function detail($id)
    {
        $potencies = DB::table('potencies')->where('id_potensi',$id)
                                            ->JOIN('offices','potencies.id_kantor','=','offices.id_kantor')
                                            ->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->JOIN('sales','customers.id_sales','=','sales.id_sales')
                                            ->JOIN('services','potencies.id_service','=','services.id_service')
                                            ->JOIN('sbu_names','potencies.id_sbu','=','sbu_names.id_sbu')
                                            ->get();

        $datax = Potency::all()->where('id_potensi',$id);
        
        return view('pages.detail_potensi',['potencies' => $potencies],compact('datax'));
    }

    public function edit($id)
    {
        $potencies = DB::table('potencies')->where('id_potensi',$id)
                                            ->JOIN('offices','potencies.id_kantor','=','offices.id_kantor')
                                            ->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->JOIN('sales','customers.id_sales','=','sales.id_sales')
                                            ->JOIN('services','potencies.id_service','=','services.id_service')
                                            ->JOIN('sbu_names','potencies.id_sbu','=','sbu_names.id_sbu')
                                            ->get();

        return view('pages.edit_potensi',['potencies' => $potencies]);
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
        DB::table('potencies')->where('id_potensi',$request->id)->update([
        'target_quote' => $request->target_quote,
        'real_quote' => $request->real_quote,
        'quote_late' => $request->quote_late,
        'target_nego' => $request->target_nego,
        'real_nego' => $request->real_nego,
        'nego_late' => $request->nego_late,
        'target_po' => $request->target_po,
        'real_po' => $request->real_po,
        'po_late' => $request->po_late,
        'update_action_plan' => $request->update_action_plan
    ]);

    Session::flash('admin_potensi_edit','Data Potensi Berhasil Diedit');
    // alihkan halaman ke halaman pegawai
    return redirect('/admin/potensi');
    }

}
