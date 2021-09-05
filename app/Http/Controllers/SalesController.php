<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Sales;
use DB;
use Session;
use Illuminate\Support\Facades\Cache;
use DataTables;
use Illuminate\Support\Facades\Hash;

class SalesController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    public function json(){
            $data = Sales::all();
            return Datatables::of($data)
                    ->addIndexColumn()
                    ->addColumn('action', function($row){
                           $btn = '<a href="sales/'.$row->id_sales.'/edit" class="edit btn btn-primary btn-sm"> <i class="mdi mdi-border-color"></i></a>';

                           $btn = $btn.'<a href="sales/delete/'.$row->id_sales.'"class="btn btn-danger btn-sm" onclick="return ConfirmDelete();")> <i class="mdi mdi-delete-forever "></i></a>';
                           return $btn;
                    })
                    ->rawColumns(['action'])
                    ->make(true);
    }

    public function index()
    {

        return view('pages.sales');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('pages.add_sales');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
		$password = Hash::make($request->password);
        DB::table('sales')->insert([
            'id_sales' => $request->id_sales,
            'id' => Auth::guard('admin')->user()->id,
            'nama_sales' => $request->nama_sales,
            'email' => $request->email,
            'password' => $password
        ]);

        Session::flash('admin_sales_add','Data Sales Berhasil Ditambahkan');
        return redirect('/admin/sales');
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
        $data = Sales::all();
        $sales = DB::table('sales')->where('id_sales',$id)->get();
        return view('pages.edit_sales',['sales' => $sales, $data]);
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
		
        if ($request->password != '') {
         $password = Hash::make($request->password);
         DB::table('sales')->where('id_sales',$request->id)->update([
        'nama_sales' => $request->nama_sales,
        'email' => $request->email,
        'password' => $password
        ]);
        }else{
         $password = Hash::make($request->password);
         DB::table('sales')->where('id_sales',$request->id)->update([
        'nama_sales' => $request->nama_sales,
        'email' => $request->email,
        ]);            
        }
        

        Session::flash('admin_sales_edit','Data Sales Berhasil Diedit');
        return redirect('/admin/sales');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        DB::table('sales')->where('id_sales',$id)->delete();
        Session::flash('admin_sales_delete','Data Sales Berhasil Dihapus');
        return redirect('/admin/sales');
    }
}
