<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Dashboard;
use App\Potency;
use App\Sales;
use Illuminate\Support\Carbon;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth:admin');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $total_customers = DB::table('customers')->JOIN('sales','customers.id_sales','=','sales.id_sales')->select('nama_sales',DB::raw('count(*) as total'))->groupBy('nama_sales')->get()->toArray();

        $nama_sales = array_column($total_customers, 'nama_sales');
        $total = array_column($total_customers, 'total');

        $total_pelanggan = DB::table('customers')->count();
        $total_service = DB::table('services')->count();

        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->where('id_sales','=',11)->whereYear('target_quote','=', 2020)->groupby('update_action_plan')->get()->toArray();  

        $data['sales_list'] = $this->fetch_sales();
        $data1['segmen_list'] = $this->fetch_segmen();
  
        $segmen = DB::table('customers')->select(DB::raw('jenis_pelanggan as segmen'),DB::raw('count(id_pelanggan) as `total`'))->groupby('segmen')->get()->toArray();
        $nama_segmen = array_column($segmen, 'segmen');
        $total_segmen = array_column($segmen, 'total');


        $a = DB::table('potencies')->select(DB::raw('YEAR(target_po) years'));
        $b= DB::table('potencies')->select(DB::raw('YEAR(target_nego) years'));

        $date = \Carbon\Carbon::now();
        $current_month = $date->month;
        $last_month = $date->subMonth()->month;

        $total_revenue = DB::table('potencies')->where('update_action_plan','=','CLOSING')->whereMONTH('target_po','=',$current_month)->sum('revenue_formula');
        $total_revenue_last = DB::table('potencies')->where('update_action_plan','=','CLOSING')->whereMONTH('target_po','=',$last_month)->sum('revenue_formula');

if($total_revenue_last > 0){
    $kenaikan = ($total_revenue - $total_revenue_last)/$total_revenue_last * 100;
}else{
    $kenaikan = 100;
}
        
        $total_potensi = DB::table('potencies')->whereMONTH('target_quote','=',$current_month)->count();
        $total_potensi_last = DB::table('potencies')->whereMONTH('target_quote','=',$last_month)->count();

if($total_potensi_last > 0){
    $kenaikan_potensi = ($total_potensi - $total_potensi_last)/$total_potensi_last * 100;
}else{
    $kenaikan_potensi = 100;
}

        $tahun = DB::table('potencies')->select(DB::raw('YEAR(target_quote) years'))->union($a)->union($b)->groupby('years')->orderBy('years', 'desc')->get();

        return view('dashboard',['total_customers' =>$total_customers,'kenaikan' => $kenaikan,'kenaikan_potensi' => $kenaikan_potensi,'total_revenue' => $total_revenue ,'total_potensi' => $total_potensi,'nama_segmen' => $nama_segmen,'total_segmen' => $total_segmen,'tahun' => $tahun,'potensi' => $potensi,'nama_sales' => $nama_sales,'total' => $total,'total_pelanggan' => $total_pelanggan,'total_service' => $total_service])->with($data)->with($data1);;
    }

    public function fetch_sales() {
        $data = DB::table('sales')->select(DB::raw('id_sales,nama_sales'))->get();
        return $data;
    }

    public function fetch_segmen() {
        $data1 = DB::table('customers')->select(DB::raw('jenis_pelanggan'))->groupBy('jenis_pelanggan')->orderBy('jenis_pelanggan', 'DESC')->get();
        return $data1;
    }

    public function fetch_data(Request $request){
        $tahun = $request->input('tahun');
        $action = $request->input('action');
        if($tahun == 'all'){
          if ($action == 'Potensi') {
             $potensi = DB::table('potencies')->select('update_action_plan',DB::raw('count(*) as `total`'))->groupby('update_action_plan')->get()->toArray();
        }elseif ($action == 'Revenue') {
             $potensi = DB::table('potencies')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->groupby('update_action_plan')->get()->toArray();            
        }
        }else{
          if ($action == 'Potensi') {
             $potensi = DB::table('potencies')->select('update_action_plan',DB::raw('count(*) as `total`'))->whereYear('target_quote','=', $tahun)->groupby('update_action_plan')->get()->toArray();
        }elseif ($action == 'Revenue') {
             $potensi = DB::table('potencies')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->whereYear('target_quote','=', $tahun)->groupby('update_action_plan')->get()->toArray();            
        }  
        }

        
       

         $a1 = array_column($potensi, 'update_action_plan');
         $a2 = array_column($potensi, 'total');
         $numArray = array_map('intval', $a2);   
        $response = [
            'action' => $a1,
            'total' => $numArray
        ];


        return response()->json($response);
    }

    public function fetch_data_sales(Request $request){

        $sales = $request->input('sales');
        $tahun = $request->input('tahun');
        $action = $request->input('action');
if($tahun == 'all'){
            if ($action == 'Potensi') {        
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('count(*) as `total`'))->where('id_sales','=',$sales)->groupby('update_action_plan')->get()->toArray();
         }elseif ($action == 'Revenue') {
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->where('id_sales','=',$sales)->groupby('update_action_plan')->get()->toArray();
         }
}
else{
        if ($action == 'Potensi') {        
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('count(*) as `total`'))->where('id_sales','=',$sales)->whereYear('target_quote','=', $tahun)->groupby('update_action_plan')->get()->toArray();
         }elseif ($action == 'Revenue') {
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->where('id_sales','=',$sales)->whereYear('target_quote','=', $tahun)->groupby('update_action_plan')->get()->toArray();
         }

}
         $a1 = array_column($potensi, 'update_action_plan');
         $a2 = array_column($potensi, 'total');
         $numArray = array_map('intval', $a2);   
        $response = [
            'action' => $a1,
            'total' => $numArray
        ];


        return response()->json($response); 

    }

    public function fetch_data_segmen(Request $request){
        $segmen = $request->input('segmen');
        $tahun = $request->input('tahun');
        $action = $request->input('action');
if($tahun == 'all'){  
            if ($action == 'Potensi') {        
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('count(*) as `total`'))->where('jenis_pelanggan','=',$segmen)->groupby('update_action_plan')->get()->toArray();
         }elseif ($action == 'Revenue') {
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->where('jenis_pelanggan','=',$segmen)->groupby('update_action_plan')->get()->toArray();
         }
}
else{
            if ($action == 'Potensi') {        
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('count(*) as `total`'))->where('jenis_pelanggan','=',$segmen)->whereYear('target_quote','=', $tahun)->groupby('update_action_plan')->get()->toArray();
         }elseif ($action == 'Revenue') {
        $potensi = DB::table('potencies')->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->select('update_action_plan',DB::raw('sum(revenue_formula) as `total`'))->where('jenis_pelanggan','=',$segmen)->whereYear('target_quote','=', $tahun)->groupby('update_action_plan')->get()->toArray();
         }
}      


         $a1 = array_column($potensi, 'update_action_plan');
         $a2 = array_column($potensi, 'total');
         $numArray = array_map('intval', $a2);   
        $response = [
            'action' => $a1,
            'total' => $numArray
        ];


        return response()->json($response); 
    }

    public function fetch_potency_month(Request $request){
        $jenis = $request->input('jenis');
        $tahun = $request->input('tahun');

        if ($jenis == 'Quote') {
                $jan = DB::table('potencies')->select()->whereMONTH('target_quote','=', '01')->whereYear('target_quote','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->whereMONTH('target_quote','=', '02')->whereYear('target_quote','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->whereMONTH('target_quote','=', '03')->whereYear('target_quote','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->whereMONTH('target_quote','=', '04')->whereYear('target_quote','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->whereMONTH('target_quote','=', '05')->whereYear('target_quote','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->whereMONTH('target_quote','=', '06')->whereYear('target_quote','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->whereMONTH('target_quote','=', '07')->whereYear('target_quote','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->whereMONTH('target_quote','=', '08')->whereYear('target_quote','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->whereMONTH('target_quote','=', '09')->whereYear('target_quote','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->whereMONTH('target_quote','=', '10')->whereYear('target_quote','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->whereMONTH('target_quote','=', '11')->whereYear('target_quote','=', $tahun)->count();
                $des = DB::table('potencies')->select()->whereMONTH('target_quote','=', '12')->whereYear('target_quote','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->whereMONTH('real_quote','=', '01')->whereYear('real_quote','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->whereMONTH('real_quote','=', '02')->whereYear('real_quote','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->whereMONTH('real_quote','=', '03')->whereYear('real_quote','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->whereMONTH('real_quote','=', '04')->whereYear('real_quote','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->whereMONTH('real_quote','=', '05')->whereYear('real_quote','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->whereMONTH('real_quote','=', '06')->whereYear('real_quote','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->whereMONTH('real_quote','=', '07')->whereYear('real_quote','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->whereMONTH('real_quote','=', '08')->whereYear('real_quote','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->whereMONTH('real_quote','=', '09')->whereYear('real_quote','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->whereMONTH('real_quote','=', '10')->whereYear('real_quote','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->whereMONTH('real_quote','=', '11')->whereYear('real_quote','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->whereMONTH('real_quote','=', '12')->whereYear('real_quote','=', $tahun)->count();
        }elseif ($jenis == 'Nego') {
                $jan = DB::table('potencies')->select()->whereMONTH('target_nego','=', '01')->whereYear('target_nego','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->whereMONTH('target_nego','=', '02')->whereYear('target_nego','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->whereMONTH('target_nego','=', '03')->whereYear('target_nego','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->whereMONTH('target_nego','=', '04')->whereYear('target_nego','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->whereMONTH('target_nego','=', '05')->whereYear('target_nego','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->whereMONTH('target_nego','=', '06')->whereYear('target_nego','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->whereMONTH('target_nego','=', '07')->whereYear('target_nego','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->whereMONTH('target_nego','=', '08')->whereYear('target_nego','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->whereMONTH('target_nego','=', '09')->whereYear('target_nego','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->whereMONTH('target_nego','=', '10')->whereYear('target_nego','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->whereMONTH('target_nego','=', '11')->whereYear('target_nego','=', $tahun)->count();
                $des = DB::table('potencies')->select()->whereMONTH('target_nego','=', '12')->whereYear('target_nego','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->whereMONTH('real_nego','=', '01')->whereYear('real_nego','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->whereMONTH('real_nego','=', '02')->whereYear('real_nego','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->whereMONTH('real_nego','=', '03')->whereYear('real_nego','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->whereMONTH('real_nego','=', '04')->whereYear('real_nego','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->whereMONTH('real_nego','=', '05')->whereYear('real_nego','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->whereMONTH('real_nego','=', '06')->whereYear('real_nego','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->whereMONTH('real_nego','=', '07')->whereYear('real_nego','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->whereMONTH('real_nego','=', '08')->whereYear('real_nego','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->whereMONTH('real_nego','=', '09')->whereYear('real_nego','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->whereMONTH('real_nego','=', '10')->whereYear('real_nego','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->whereMONTH('real_nego','=', '11')->whereYear('real_nego','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->whereMONTH('real_nego','=', '12')->whereYear('real_nego','=', $tahun)->count();
        }elseif ($jenis == 'PO') {
                $jan = DB::table('potencies')->select()->whereMONTH('target_po','=', '01')->whereYear('target_po','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->whereMONTH('target_po','=', '02')->whereYear('target_po','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->whereMONTH('target_po','=', '03')->whereYear('target_po','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->whereMONTH('target_po','=', '04')->whereYear('target_po','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->whereMONTH('target_po','=', '05')->whereYear('target_po','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->whereMONTH('target_po','=', '06')->whereYear('target_po','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->whereMONTH('target_po','=', '07')->whereYear('target_po','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->whereMONTH('target_po','=', '08')->whereYear('target_po','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->whereMONTH('target_po','=', '09')->whereYear('target_po','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->whereMONTH('target_po','=', '10')->whereYear('target_po','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->whereMONTH('target_po','=', '11')->whereYear('target_po','=', $tahun)->count();
                $des = DB::table('potencies')->select()->whereMONTH('target_po','=', '12')->whereYear('target_po','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->whereMONTH('real_po','=', '01')->whereYear('real_po','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->whereMONTH('real_po','=', '02')->whereYear('real_po','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->whereMONTH('real_po','=', '03')->whereYear('real_po','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->whereMONTH('real_po','=', '04')->whereYear('real_po','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->whereMONTH('real_po','=', '05')->whereYear('real_po','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->whereMONTH('real_po','=', '06')->whereYear('real_po','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->whereMONTH('real_po','=', '07')->whereYear('real_po','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->whereMONTH('real_po','=', '08')->whereYear('real_po','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->whereMONTH('real_po','=', '09')->whereYear('real_po','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->whereMONTH('real_po','=', '10')->whereYear('real_po','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->whereMONTH('real_po','=', '11')->whereYear('real_po','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->whereMONTH('real_po','=', '12')->whereYear('real_po','=', $tahun)->count();
        }

        $a1 = [$jan,$feb,$mar,$apr,$mei,$jun,$jul,$agu,$sep,$okt,$nov,$des];
        $a2 = [$rjan,$rfeb,$rmar,$rapr,$rmei,$rjun,$rjul,$ragu,$rsep,$rokt,$rnov,$rdes];
        $response = [
            'Target' => $a1,
            'Real' => $a2
        ];


        return response()->json($response); 
    }


    public function fetch_potency_month_sales(Request $request){
        $jenis = $request->input('jenis');
        $id_sales = $request->input('id_sales');
        $tahun = $request->input('tahun');

        if ($jenis == 'Quote') {
                $jan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '01')->whereYear('target_quote','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '02')->whereYear('target_quote','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '03')->whereYear('target_quote','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '04')->whereYear('target_quote','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '05')->whereYear('target_quote','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '06')->whereYear('target_quote','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '07')->whereYear('target_quote','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '08')->whereYear('target_quote','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '09')->whereYear('target_quote','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '10')->whereYear('target_quote','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '11')->whereYear('target_quote','=', $tahun)->count();
                $des = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_quote','=', '12')->whereYear('target_quote','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '01')->whereYear('real_quote','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '02')->whereYear('real_quote','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '03')->whereYear('real_quote','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '04')->whereYear('real_quote','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '05')->whereYear('real_quote','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '06')->whereYear('real_quote','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '07')->whereYear('real_quote','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '08')->whereYear('real_quote','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '09')->whereYear('real_quote','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '10')->whereYear('real_quote','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '11')->whereYear('real_quote','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_quote','=', '12')->whereYear('real_quote','=', $tahun)->count();
        }elseif ($jenis == 'Nego') {
                $jan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '01')->whereYear('target_nego','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '02')->whereYear('target_nego','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '03')->whereYear('target_nego','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '04')->whereYear('target_nego','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '05')->whereYear('target_nego','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '06')->whereYear('target_nego','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '07')->whereYear('target_nego','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '08')->whereYear('target_nego','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '09')->whereYear('target_nego','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '10')->whereYear('target_nego','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '11')->whereYear('target_nego','=', $tahun)->count();
                $des = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_nego','=', '12')->whereYear('target_nego','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '01')->whereYear('real_nego','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '02')->whereYear('real_nego','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '03')->whereYear('real_nego','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '04')->whereYear('real_nego','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '05')->whereYear('real_nego','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '06')->whereYear('real_nego','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '07')->whereYear('real_nego','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '08')->whereYear('real_nego','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '09')->whereYear('real_nego','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '10')->whereYear('real_nego','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '11')->whereYear('real_nego','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_nego','=', '12')->whereYear('real_nego','=', $tahun)->count();
        }elseif ($jenis == 'PO') {
                $jan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '01')->whereYear('target_po','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '02')->whereYear('target_po','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '03')->whereYear('target_po','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '04')->whereYear('target_po','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '05')->whereYear('target_po','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '06')->whereYear('target_po','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '07')->whereYear('target_po','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '08')->whereYear('target_po','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '09')->whereYear('target_po','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '10')->whereYear('target_po','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '11')->whereYear('target_po','=', $tahun)->count();
                $des = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('target_po','=', '12')->whereYear('target_po','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '01')->whereYear('real_po','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '02')->whereYear('real_po','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '03')->whereYear('real_po','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '04')->whereYear('real_po','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '05')->whereYear('real_po','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '06')->whereYear('real_po','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '07')->whereYear('real_po','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '08')->whereYear('real_po','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '09')->whereYear('real_po','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '10')->whereYear('real_po','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '11')->whereYear('real_po','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('id_sales','=',$id_sales)->whereMONTH('real_po','=', '12')->whereYear('real_po','=', $tahun)->count();
        }
        $a1 = [$jan,$feb,$mar,$apr,$mei,$jun,$jul,$agu,$sep,$okt,$nov,$des];
        $a2 = [$rjan,$rfeb,$rmar,$rapr,$rmei,$rjun,$rjul,$ragu,$rsep,$rokt,$rnov,$rdes];
        $response = [
            'Target' => $a1,
            'Real' => $a2
        ];


        return response()->json($response); 
    }

        public function fetch_potency_month_segmen(Request $request){
        $jenis = $request->input('jenis');
        $segmen = $request->input('segmen');
        $tahun = $request->input('tahun');

        if ($jenis == 'Quote') {
                $jan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '01')->whereYear('target_quote','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '02')->whereYear('target_quote','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '03')->whereYear('target_quote','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '04')->whereYear('target_quote','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '05')->whereYear('target_quote','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '06')->whereYear('target_quote','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '07')->whereYear('target_quote','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '08')->whereYear('target_quote','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '09')->whereYear('target_quote','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '10')->whereYear('target_quote','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '11')->whereYear('target_quote','=', $tahun)->count();
                $des = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_quote','=', '12')->whereYear('target_quote','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '01')->whereYear('real_quote','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '02')->whereYear('real_quote','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '03')->whereYear('real_quote','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '04')->whereYear('real_quote','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '05')->whereYear('real_quote','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '06')->whereYear('real_quote','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '07')->whereYear('real_quote','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '08')->whereYear('real_quote','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '09')->whereYear('real_quote','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '10')->whereYear('real_quote','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '11')->whereYear('real_quote','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_quote','=', '12')->whereYear('real_quote','=', $tahun)->count();
        }elseif ($jenis == 'Nego') {
                $jan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '01')->whereYear('target_nego','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '02')->whereYear('target_nego','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '03')->whereYear('target_nego','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '04')->whereYear('target_nego','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '05')->whereYear('target_nego','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '06')->whereYear('target_nego','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '07')->whereYear('target_nego','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '08')->whereYear('target_nego','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '09')->whereYear('target_nego','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '10')->whereYear('target_nego','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '11')->whereYear('target_nego','=', $tahun)->count();
                $des = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_nego','=', '12')->whereYear('target_nego','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '01')->whereYear('real_nego','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '02')->whereYear('real_nego','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '03')->whereYear('real_nego','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '04')->whereYear('real_nego','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '05')->whereYear('real_nego','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '06')->whereYear('real_nego','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '07')->whereYear('real_nego','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '08')->whereYear('real_nego','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '09')->whereYear('real_nego','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '10')->whereYear('real_nego','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '11')->whereYear('real_nego','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_nego','=', '12')->whereYear('real_nego','=', $tahun)->count();
        }elseif ($jenis == 'PO') {
                $jan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '01')->whereYear('target_po','=', $tahun)->count();
                $feb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '02')->whereYear('target_po','=', $tahun)->count();
                $mar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '03')->whereYear('target_po','=', $tahun)->count();
                $apr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '04')->whereYear('target_po','=', $tahun)->count();
                $mei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '05')->whereYear('target_po','=', $tahun)->count();
                $jun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '06')->whereYear('target_po','=', $tahun)->count();
                $jul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '07')->whereYear('target_po','=', $tahun)->count();
                $agu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '08')->whereYear('target_po','=', $tahun)->count();
                $sep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '09')->whereYear('target_po','=', $tahun)->count();
                $okt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '10')->whereYear('target_po','=', $tahun)->count();
                $nov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '11')->whereYear('target_po','=', $tahun)->count();
                $des = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('target_po','=', '12')->whereYear('target_po','=', $tahun)->count();

                $rjan = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '01')->whereYear('real_po','=', $tahun)->count();
                $rfeb = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '02')->whereYear('real_po','=', $tahun)->count();
                $rmar = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '03')->whereYear('real_po','=', $tahun)->count();
                $rapr = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '04')->whereYear('real_po','=', $tahun)->count();
                $rmei = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '05')->whereYear('real_po','=', $tahun)->count();
                $rjun = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '06')->whereYear('real_po','=', $tahun)->count();
                $rjul = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '07')->whereYear('real_po','=', $tahun)->count();
                $ragu = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '08')->whereYear('real_po','=', $tahun)->count();
                $rsep = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '09')->whereYear('real_po','=', $tahun)->count();
                $rokt = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '10')->whereYear('real_po','=', $tahun)->count();
                $rnov = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '11')->whereYear('real_po','=', $tahun)->count();
                $rdes = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')->where('jenis_pelanggan','=',$segmen)->whereMONTH('real_po','=', '12')->whereYear('real_po','=', $tahun)->count();
        }
        $a1 = [$jan,$feb,$mar,$apr,$mei,$jun,$jul,$agu,$sep,$okt,$nov,$des];
        $a2 = [$rjan,$rfeb,$rmar,$rapr,$rmei,$rjun,$rjul,$ragu,$rsep,$rokt,$rnov,$rdes];
        $response = [
            'Target' => $a1,
            'Real' => $a2
        ];


        return response()->json($response); 
    }

    public function fetch_closing(Request $request)
    {
         $cek = $request->input('filter');
         $newdate = $request->input('newdate');

         $datetest = DB::table('potencies')->select()->wherenull('real_quote')->where('target_quote','>=',$newdate)->get()->count();
         if ($request->input('filter'))
         {
                if($cek == 'Quote')
                {
                    $date = DB::table('potencies')->select()->whereRAW('real_quote <= target_quote')->count();            

                    $date_10 = DB::table('potencies')->select()->whereRAW('real_quote > target_quote')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 10 DAY)')
                                                        ->count();

                    $date_17 = DB::table('potencies')->select()
                                                        ->whereRAW('real_quote >= DATE_ADD(target_quote, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 17 DAY)')
                                                        ->count();

                    $date_18 = DB::table('potencies')->select()
                                                        ->whereRAW('real_quote >= DATE_ADD(target_quote, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 22 DAY)')
                                                        ->get()->count();

                    $date_22 = DB::table('potencies')->select()
                                                        ->whereRAW('real_quote > DATE_ADD(target_quote, INTERVAL 22 DAY)')
                                                        ->count();
                    
                    $datenull = DB::table('potencies')->select()->wherenull('real_quote')->where('target_quote','>=',$newdate)->count();                        
                     $date10null = DB::table('potencies')->select()->wherenull('real_quote')->where('target_quote','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 22 DAY)'),'<=',$newdate)->count();                    
                }elseif($cek == 'Nego')
                {
                    $date = DB::table('potencies')->select()->whereRAW('real_nego <= target_nego')->get()->count();
                    $date_10 = DB::table('potencies')->select()->whereRAW('real_nego > target_nego')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()
                                                        ->whereRAW('real_nego >= DATE_ADD(target_nego, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18= DB::table('potencies')->select()
                                                        ->whereRAW('real_nego >= DATE_ADD(target_nego, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()
                                                        ->whereRAW('real_nego > DATE_ADD(target_nego, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $datenull = DB::table('potencies')->select()->wherenull('real_quote')->where('target_nego','>=',$newdate)->count();     
                     $date10null = DB::table('potencies')->select()->wherenull('real_nego')->where('target_nego','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                           
                }elseif($cek == 'PO'){
                    $date = DB::table('potencies')->select()->whereRAW('real_po <= target_po')->get()->count();
                    $date_10 = DB::table('potencies')->select()->whereRAW('real_po > target_po')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17= DB::table('potencies')->select()
                                                        ->whereRAW('real_po >= DATE_ADD(target_po, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18= DB::table('potencies')->select()
                                                        ->whereRAW('real_po >= DATE_ADD(target_po, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()
                                                        ->whereRAW('real_po > DATE_ADD(target_po, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    
                    $datenull = DB::table('potencies')->select()->wherenull('real_quote')->where('target_quote','>=',$newdate)->count();                                                             
                     $date10null = DB::table('potencies')->select()->wherenull('real_po')->where('target_po','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                           
                }
                $tdate = $datenull + $date;
                $tdate_10 = $date10null + $date_10;
                $tdate_17 = $date17null + $date_17;
                $tdate_18 = $date18null + $date_18;
                $tdate_22 = $date22null + $date_22;

                $a1 = ['Hari : < 0','Hari : 1 s/d 10','Hari : 11 s/d 17','Hari : 18 s/d 22','Hari : > 22'];
                $a2 = [$tdate,$tdate_10,$tdate_17,$tdate_18,$tdate_22,];
                $response = [
                    'detail' => $a1,
                    'closing' => $a2
                ];


                return response()->json($response); 
        }
    }

        public function fetch_closing_sales(Request $request)
    {
            $cek = $request->input('filter');
            $id_sales = $request->input('id_sales');
            $newdate = $request->input('newdate');


                if($cek == 'Quote')
                {
                    $date = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_quote <= target_quote')->get()->count();
                    $date_10 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_quote > target_quote')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_quote >= DATE_ADD(target_quote, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_quote >= DATE_ADD(target_quote, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_quote > DATE_ADD(target_quote, INTERVAL 22 DAY)')
                                                        ->get()->count();

                    $datenull = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where('target_quote','>=',$newdate)->count();                        
                     $date10null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where('target_quote','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                          
                }elseif($cek == 'Nego')
                {
                    $date = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_nego <= target_nego')->get()->count();
                    $date_10 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->whereRAW('real_nego > target_nego')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_nego >= DATE_ADD(target_nego, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_nego >= DATE_ADD(target_nego, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_nego > DATE_ADD(target_nego, INTERVAL 22 DAY)')
                                                        ->get()->count();

                    $datenull = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where('target_nego','>=',$newdate)->count();     
                     $date10null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_nego')->where('target_nego','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                        
                }elseif($cek == 'PO'){
                    $date = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_po <= target_po')->get()->count();
                    $date_10 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->whereRAW('real_po > target_po')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_po >= DATE_ADD(target_po, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_po >= DATE_ADD(target_po, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)
                                                        ->whereRAW('real_po > DATE_ADD(target_po, INTERVAL 22 DAY)')
                                                        ->get()->count();
                                                        
                    $datenull = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_quote')->where('target_quote','>=',$newdate)->count();                                                             
                     $date10null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_po')->where('target_po','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('id_sales','=',$id_sales)->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                        
                }

                $tdate = $datenull + $date;
                $tdate_10 = $date10null + $date_10;
                $tdate_17 = $date17null + $date_17;
                $tdate_18 = $date18null + $date_18;
                $tdate_22 = $date22null + $date_22;

                $a1 = ['Hari : < 0','Hari : 1 s/d 10','Hari : 11 s/d 17','Hari : 18 s/d 22','Hari : > 22'];
                $a2 = [$tdate,$tdate_10,$tdate_17,$tdate_18,$tdate_22,];
                $response = [
                    'detail' => $a1,
                    'closing' => $a2
                ];


                return response()->json($response); 

    }

    public function fetch_closing_segmen(Request $request)
    {
            $cek = $request->input('filter');
            $jenis_pelanggan = $request->input('jenis_pelanggan');
            $newdate = $request->input('newdate');


                if($cek == 'Quote')
                {   $date = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_quote <= target_quote')
                                                        ->get()->count();
                    $date_10 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_quote > target_quote')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_quote >= DATE_ADD(target_quote, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_quote >= DATE_ADD(target_quote, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_quote <= DATE_ADD(target_quote, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_quote > DATE_ADD(target_quote, INTERVAL 22 DAY)')
                                                        ->get()->count();

                    $datenull = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where('target_quote','>=',$newdate)->count();                        
                     $date10null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where('target_quote','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_quote, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where(DB::raw('DATE_ADD(target_quote, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                          
                }elseif($cek == 'Nego')
                {   $date = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_nego <= target_nego')
                                                        ->get()->count();
                    $date_10 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->whereRAW('real_nego > target_nego')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_nego >= DATE_ADD(target_nego, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_nego >= DATE_ADD(target_nego, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_nego <= DATE_ADD(target_nego, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_nego > DATE_ADD(target_nego, INTERVAL 22 DAY)')
                                                        ->get()->count();

                    $datenull = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where('target_nego','>=',$newdate)->count();     
                     $date10null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_nego')->where('target_nego','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_nego, INTERVAL 17 DAY)'),'>=',$newdate)->count();
                    $date18null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 18 DAY)'),'<=',$newdate)->where(DB::raw('DATE_ADD(target_nego, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_nego')->where(DB::raw('DATE_ADD(target_nego, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                        
                }elseif($cek == 'PO'){
                    $date = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_po <= target_po')
                                                        ->get()->count();
                    $date_10 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->whereRAW('real_po > target_po')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 10 DAY)')
                                                        ->get()->count();
                    $date_17 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_po >= DATE_ADD(target_po, INTERVAL 11 DAY)')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 17 DAY)')
                                                        ->get()->count();
                    $date_18 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_po >= DATE_ADD(target_po, INTERVAL 18 DAY)')
                                                        ->whereRAW('real_po <= DATE_ADD(target_po, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $date_22 = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)
                                                        ->whereRAW('real_po > DATE_ADD(target_po, INTERVAL 22 DAY)')
                                                        ->get()->count();
                    $datenull = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_quote')->where('target_quote','>=',$newdate)->count();                                                             
                     $date10null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_po')->where('target_po','<',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 10 DAY)'),'>=',$newdate)
                                                        ->count();
                    $date17null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 11 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 17 DAY)'),'>=',$newdate)->count();

                    $date18null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 18 DAY)'),'<=',$newdate)
                                                        ->where(DB::raw('DATE_ADD(target_po, INTERVAL 22 DAY)'),'>=',$newdate)->count();                                                                                                                                                                        
                    $date22null = DB::table('potencies')->select()->JOIN('customers','potencies.id_pelanggan','=','customers.id_pelanggan')
                                                        ->where('jenis_pelanggan','=',$jenis_pelanggan)->wherenull('real_po')->where(DB::raw('DATE_ADD(target_po, INTERVAL 22 DAY)'),'<=',$newdate)->count();                                                        
                }
                $tdate = $datenull + $date;
                $tdate_10 = $date10null + $date_10;
                $tdate_17 = $date17null + $date_17;
                $tdate_18 = $date18null + $date_18;
                $tdate_22 = $date22null + $date_22;

                $a1 = ['Hari : < 0','Hari : 1 s/d 10','Hari : 11 s/d 17','Hari : 18 s/d 22','Hari : > 22'];
                $a2 = [$tdate,$tdate_10,$tdate_17,$tdate_18,$tdate_22,];
                $response = [
                    'detail' => $a1,
                    'closing' => $a2
                ];


                return response()->json($response); 

    }

}
