@extends('layout.master')
@section('title', 'Dashboard')

@push('plugin-styles')
  <link href="{{ asset('assets') }}/plugins/plugin.css" rel="stylesheet">
@endpush

@section('content')

<div class="row">

  <div class="col-md-6 col-xl-6 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Total Potensi</h4>
        </div>
                <div class="float-right">
                      <select name="filter_action_total_potensi" id="filter_action_total_potensi"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  <option value="Potensi">Potensi</option>
                                  <option value="Revenue">Revenue</option>
                      </select>                  
                      <select name="filter_tahun_di_total_potensi" id="filter_tahun_di_total_potensi"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                      <option value="all">ALL</option>
                                  @foreach($tahun as $row)
                                      <option value="{{$row->years}}">{{$row->years}}</option>
                                  @endforeach
                      </select>
                      </div>       
      </div>
      <div class="card-body">        
          <div id="chart_total_potensi"></div>
      </div>
    </div>
  </div>

<div class="col-xl-6">

  <div class="row mb-3">
    <div class="col">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-cube text-danger icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Revenue</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0">Rp.<?php echo number_format($total_revenue) ?></h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <?php if($kenaikan > 0){ ?>
          <i class="mdi mdi-arrow-up mr-1" aria-hidden="true"></i> <?php echo number_format($kenaikan) ?>% Since Last Month
          <?php } else { ?>
          <i class="mdi mdi-arrow-down mr-1" aria-hidden="true"></i> <?php echo number_format($kenaikan) ?>% Since Last Month
            <?php } ?>
             </p>
      </div>
    </div>
  </div>
</div>
  <div class="row mb-3">
   <div class="col">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-receipt text-warning icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Total Potensi</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0"><?php echo number_format($total_potensi) ?> Potensi</h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
                    <?php if($kenaikan_potensi > 0){ ?>
          <i class="mdi mdi-arrow-up mr-1" aria-hidden="true"></i> <?php echo number_format($kenaikan_potensi) ?>% Since Last Month
          <?php } else { ?>
          <i class="mdi mdi-arrow-down mr-1" aria-hidden="true"></i> <?php echo number_format($kenaikan_potensi) ?>% Since Last Month
            <?php } ?> </p>
      </div>
    </div>
  </div>
</div>
  <div class="row mb-3">
    <div class="col">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-account-card-details text-info icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Customers</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0"><?php echo $total_pelanggan ?></h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-reload mr-1" aria-hidden="true"></i>Total Pelanggan</p>
      </div>
    </div>
  </div>

   <div class="col">
    <div class="card card-statistics">
      <div class="card-body">
        <div class="d-flex flex-md-column flex-xl-row flex-wrap justify-content-between align-items-md-center justify-content-xl-between">
          <div class="float-left">
            <i class="mdi mdi-airplay text-success icon-lg"></i>
          </div>
          <div class="float-right">
            <p class="mb-0 text-right">Service</p>
            <div class="fluid-container">
              <h3 class="font-weight-medium text-right mb-0"><?php echo $total_service?></h3>
            </div>
          </div>
        </div>
        <p class="text-muted mt-3 mb-0 text-left text-md-center text-xl-left">
          <i class="mdi mdi-calendar mr-1" aria-hidden="true"></i> Total Service </p>
      </div>
    </div>
  </div>
</div>

</div>
</div>

  <div class="row">

  <div class="col-md-6 col-xl-6 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Per Sales</h4>
        </div>

        <div class="float-right">
                      <select name="filter_action_total_potensi_sales" id="filter_action_total_potensi_sales"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  <option value="Potensi">Potensi</option>
                                  <option value="Revenue">Revenue</option>
                      </select>           
                      <select name="filter_tahun_di_total_potensi_sales" id="filter_tahun_di_total_potensi_sales"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                    <option value="all">ALL</option>
                                  @foreach($tahun as $row)
                                      <option value="{{$row->years}}">{{$row->years}}</option>
                                  @endforeach
                      </select>          
          <select name="filter_sales_chart_total_potensi" id="filter_sales_chart_total_potensi" class="card-title mb-0 btn-group dropdown btn-secondary">
                @foreach($sales_list as $row)
                    <option value="{{$row->id_sales}}">{{$row->nama_sales}}</option>
                 @endforeach
          </select>      
        </div>           

      </div>      
      <div class="card-body">
        <div id="chart_total_potensi_sales"></div>
      </div>
    </div>
  </div>

    <div class="col-md-6 col-xl-6 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Per Segmen</h4>
        </div>

        <div class="float-right">
                      <select name="filter_action_total_potensi_segmen" id="filter_action_total_potensi_segmen"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  <option value="Potensi">Potensi</option>
                                  <option value="Revenue">Revenue</option>
                      </select>           
                      <select name="filter_tahun_di_total_potensi_segmen" id="filter_tahun_di_total_potensi_segmen"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                    <option value="all">ALL</option>
                                  @foreach($tahun as $row)
                                      <option value="{{$row->years}}">{{$row->years}}</option>
                                  @endforeach
                      </select>          
          <select name="filter_segmen_chart_total_potensi" id="filter_segmen_chart_total_potensi" class="card-title mb-0 btn-group dropdown btn-secondary">
                    @foreach($segmen_list as $row)
                         <option value="{{$row->jenis_pelanggan}}">{{$row->jenis_pelanggan}}</option>
                    @endforeach
          </select>      
        </div>           

      </div>       
      <div class="card-body">
        <div id="chart_total_potensi_segmen"></div>
      </div>
    </div>
  </div>

</div>

<div class="row">
  <div class="col grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Total Customers Per Sales</h4>
        </div>

      </div>       
      <div class="card-body">
        <div id="chart_total_customers_sales"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Total Custoemrs Per Segmen</h4>
        </div>

      </div>       
      <div class="card-body">
        <div id="chart_total_customers_segmen"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Monitoring Target dan Real Potensi : ALL</h4>
        </div>

        <div class="float-right">
                      <select name="filter_tahun_chart_pertama" id="filter_tahun_chart_pertama"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  @foreach($tahun as $row)
                                      <option value="{{$row->years}}">{{$row->years}}</option>
                                  @endforeach
                      </select>

                      <select name="filter_jenis_data_bulanan" id="filter_jenis_data_bulanan"class="card-title mb-0 btn-group dropdown btn-secondary">
                                  <option value="Quote">Quote</option>
                                  <option value="Nego">Nego</option>
                                  <option value="PO">PO</option>
                                </select>          
        </div>

      </div>       
      <div class="card-body">
        <div id="chart_data_bulanan_all" ></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Monitoring Target dan Real Potensi : Sales</h4>
        </div>

        <div class="float-right">
                                <select name="filter_tahun_chart_kedua" id="filter_tahun_chart_kedua"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  @foreach($tahun as $row)
                                      <option value="{{$row->years}}">{{$row->years}}</option>
                                  @endforeach
                                </select>
                               <select name="filter_sales_data_bulanan" id="filter_sales_data_bulanan" class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  @foreach($sales_list as $row)
                                      <option value="{{$row->id_sales}}">{{$row->nama_sales}}</option>
                                  @endforeach
                                </select>
                                <select name="filter_jenis_data_bulanan_sales" id="filter_jenis_data_bulanan_sales"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  <option value="Quote">Quote</option>
                                  <option value="Nego">Nego</option>
                                  <option value="PO">PO</option>
                                </select>                                                                    
        </div>

      </div>       
      <div class="card-body">
        <div id="chart_data_bulanan_sales"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Monitoring Target dan Real Potensi : Segmen</h4>
        </div>

        <div class="float-right">
                                <select name="filter_tahun_chart_ketiga" id="filter_tahun_chart_ketiga"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  @foreach($tahun as $row)
                                      <option value="{{$row->years}}">{{$row->years}}</option>
                                  @endforeach
                                </select>

                                <select name="filter_segmen_data_bulanan" id="filter_segmen_data_bulanan"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  @foreach($segmen_list as $row)
                                      <option value="{{$row->jenis_pelanggan}}">{{$row->jenis_pelanggan}}</option>
                                  @endforeach
                                </select>

                                <select name="filter_jenis_data_bulanan_segmen" id="filter_jenis_data_bulanan_segmen"class="card-title mb-0 btn-group dropdown btn-secondary mr-2">
                                  <option value="Quote">Quote</option>
                                  <option value="Nego">Nego</option>
                                  <option value="PO">PO</option>
                                </select>                                        
        </div>

      </div>       
      <div class="card-body">
        <div id="chart_data_bulanan_segmen"></div>
      </div>
    </div>
  </div>
</div>

<div class="row">

  <div class="col-md-6 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="float-left">
          <h4 class="card-title mb-0">Closing to Target</h4>
        </div>

        <div class="float-right">
                                <select name="filter_jumlah_closing_action" id="filter_jumlah_closing_action"class="card-title mb-0 btn-group dropdown btn-secondary">
                                  <option value="Quote">Quote</option>
                                  <option value="Nego">Nego</option>
                                  <option value="PO">PO</option>
                                </select>    
        </div>                 
      </div>
      <div class="card-body">        
          <div id="chart_closing_all"></div>
      </div>
    </div>
  </div>

  <div class="col-md-6 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="row mb-1">
              <div class="col float-left">
                <h4 class="card-title mb-0">Closing to Target Sales</h4>
              </div>
              <div class="col">
                <div class="float-right">
                                <select name="filter_jumlah_closing_sales_action" id="filter_jumlah_closing_sales_action" class="card-title mb-0 btn-group dropdown btn-secondary">
                                  <option value="Quote">Quote</option>
                                  <option value="Nego">Nego</option>
                                  <option value="PO">PO</option>
                                </select>
                              </div>
                                </div>               
        </div>

       <div class="row">
              <div class="col">
                <div class="float-right">
                              <select name="filter_jumlah_closing_sales" id="filter_jumlah_closing_sales" class="card-title mb-0 btn-group dropdown btn-secondary">
                                  @foreach($sales_list as $row)
                                      <option value="{{$row->id_sales}}">{{$row->nama_sales}}</option>
                                  @endforeach
                                </select>


                </div>               
              </div>
        </div>

      </div>
      <div class="card-body">
        <div id="chart_closing_sales"></div>
      </div>
    </div>

    </div>

  <div class="col-md-6 col-xl-4 grid-margin stretch-card">
    <div class="card">
      <div class="p-4 border-bottom bg-light">
        <div class="row mb-1">
              <div class="col float-left">
                <h4 class="card-title mb-0">Closing to Target Segmen</h4>
              </div>
              <div class="col">
                <div class="float-right">
                                <select name="filter_jumlah_closing_segmen_action" id="filter_jumlah_closing_segmen_action" class="card-title mb-0 btn-group dropdown btn-secondary">
                                  <option value="Quote">Quote</option>
                                  <option value="Nego">Nego</option>
                                  <option value="PO">PO</option>
                                </select>                                  
                              </div>
                                </div>               
        </div>
       <div class="row">
              <div class="col">
                <div class="float-right"> 
                                <select name="filter_jumlah_closing_segmen" id="filter_jumlah_closing_segmen" class="card-title mb-0 btn-group dropdown btn-secondary">
                                  @foreach($segmen_list as $row)
                                      <option value="{{$row->jenis_pelanggan}}">{{$row->jenis_pelanggan}}</option>
                                  @endforeach
                                </select>     
                </div>               
              </div>
        </div>
</div>
      <div class="card-body">
        <div id="chart_closing_segmen"></div>
      </div>
    </div>

</div>

</div>

@endsection

@push('plugin-scripts')
    <script src="{{ asset('assets') }}/plugins/chartjs/chart.min.js"></script>
  <script src="{{ asset('assets') }}/plugins/jquery-sparkline/jquery.sparkline.min.js"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets') }}/js/dashboard.js"></script>
  <script src="https://code.highcharts.com/highcharts.js"></script>
<script>

            $('#filter_tahun_di_total_potensi').change(function() {
                var tahun = $(this).val();
                var action_potensi = $(filter_action_total_potensi).val();
                if(tahun != '') {
                     load_total_potensi(tahun,action_potensi);  
                }
            });


            $('#filter_action_total_potensi').change(function() {
                var tahun = $(filter_tahun_di_total_potensi).val();
                var action_potensi = $(this).val();
                if(action_potensi != '') {
                     load_total_potensi(tahun,action_potensi);  
                }
            });

            $('#filter_action_total_potensi_sales').change(function() {
                var id_sales = $(filter_sales_chart_total_potensi).val();
                var tahun_potensi_sales = $(filter_tahun_di_total_potensi_sales).val();
                var action = $(this).val();
                if(id_sales != '') {
                    load_sales_total_potensi(id_sales, tahun_potensi_sales,action);
                }
            });

            $('#filter_sales_chart_total_potensi').change(function() {
                var id_sales = $(this).val();
                var tahun_potensi_sales = $(filter_tahun_di_total_potensi_sales).val();
                var action = $(filter_action_total_potensi_sales).val();
                if(id_sales != '') {
                    load_sales_total_potensi(id_sales, tahun_potensi_sales,action);
                }
            });

            $('#filter_tahun_di_total_potensi_sales').change(function() {
                var id_sales = $(filter_sales_chart_total_potensi).val();
                var tahun_potensi_sales = $(this).val();
                var action = $(filter_action_total_potensi_sales).val();
                if(tahun_potensi_sales != '') {
                    load_sales_total_potensi(id_sales, tahun_potensi_sales,action);
                }
            });            

            $('#filter_action_total_potensi_segmen').change(function() {
                var action = $(this).val();
                var tahun_potensi_segmen = $(filter_tahun_di_total_potensi_segmen).val();
                var segmen = $(filter_segmen_chart_total_potensi).val();   
                if(segmen != '') {
                    load_segmen_total_potensi(segmen, tahun_potensi_segmen,action);
                }
            });

            $('#filter_segmen_chart_total_potensi').change(function() {
                var segmen = $(this).val();
                var tahun_potensi_segmen = $(filter_tahun_di_total_potensi_segmen).val(); 
                var action = $(filter_action_total_potensi_segmen).val();  
                if(segmen != '') {
                    load_segmen_total_potensi(segmen, tahun_potensi_segmen,action);
                }
            });

            $('#filter_tahun_di_total_potensi_segmen').change(function() {
                var segmen = $(filter_segmen_chart_total_potensi).val();
                var tahun_potensi_segmen = $(this).val();
                var action = $(filter_action_total_potensi_segmen).val();  
                if(tahun_potensi_segmen != '') {
                    load_segmen_total_potensi(segmen, tahun_potensi_segmen,action);
                }
            });

            $('#filter_tahun_chart_pertama').change(function() {          
                var jenis = $(filter_jenis_data_bulanan).val();
                var tahun = $(this).val();
                if(tahun != '') {
                    load_data_bulanan(jenis,tahun, 'Tahun :');

                }
            });

            $('#filter_jenis_data_bulanan').change(function() {
                var jenis = $(this).val();
                var tahun = $(filter_tahun_chart_pertama).val();
                if(jenis != '') {
                    load_data_bulanan(jenis,tahun, 'Tahun:');
                }
            });

            $('#filter_tahun_chart_kedua').change(function() {
                var tahun = $(this).val();
                var id_sales = $(filter_sales_data_bulanan).val();
                var jenis = $(filter_jenis_data_bulanan_sales).val();
                if(tahun != '') {
                    load_data_bulanan_sales(id_sales,jenis,tahun, 'Tahun:');
                }
            });

            $('#filter_sales_data_bulanan').change(function() {
                var id_sales = $(this).val();
                var jenis = $(filter_jenis_data_bulanan_sales).val();
                var tahun = $(filter_tahun_chart_kedua).val();
                if(id_sales != '') {
                    load_data_bulanan_sales(id_sales,jenis,tahun, 'Tahun:');
                }
            });

            $('#filter_jenis_data_bulanan_sales').change(function() {
                var jenis = $(this).val();
                var id_sales = $(filter_sales_data_bulanan).val();
                var tahun = $(filter_tahun_chart_kedua).val();
                if(jenis != '') {
                    load_data_bulanan_sales(id_sales,jenis,tahun, 'Tahun:');
                }
            });

            $('#filter_tahun_chart_ketiga').change(function() {
                var tahun = $(this).val();
                var segmen = $(filter_segmen_data_bulanan).val();
                var jenis = $(filter_jenis_data_bulanan_segmen).val();
                if(tahun != '') {
                    load_data_bulanan_segmen(segmen,jenis,tahun, 'Tahun:');
                }
            });

             $('#filter_segmen_data_bulanan').change(function() {
                var segmen = $(this).val();
                var jenis = $(filter_jenis_data_bulanan_segmen).val();
                var tahun = $(filter_tahun_chart_ketiga).val();
                if(segmen != '') {
                    load_data_bulanan_segmen(segmen,jenis,tahun, 'Tahun:');
                }
            });

            $('#filter_jenis_data_bulanan_segmen').change(function() {
                var jenis = $(this).val();
                var segmen = $(filter_segmen_data_bulanan).val();
                var tahun = $(filter_tahun_chart_ketiga).val();
                if(jenis != '') {
                    load_data_bulanan_segmen(segmen,jenis,tahun, 'Tahun:');
                }
            });

            $('#filter_jumlah_closing_action').change(function() {
var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getDate();
var year = dateObj.getUTCFullYear();
var newdate = year + "-0" + month + "-" + day;

                var closing = $(this).val();
                if(closing != '') {
                    load_closing(closing,newdate, 'SBU Jabar:');
                }
            });

            $('#filter_jumlah_closing_sales').change(function() {
var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getDate();
var year = dateObj.getUTCFullYear();
var newdate = year + "-0" + month + "-" + day;              
                var closing_sales = $(this).val();
                var closing_sales_action = $(filter_jumlah_closing_sales_action).val();
                
                    load_closing_sales(closing_sales,closing_sales_action,newdate, 'SBU Jabar:');               
            });

            $('#filter_jumlah_closing_sales_action').change(function() {
var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getDate();
var year = dateObj.getUTCFullYear();
var newdate = year + "-0" + month + "-" + day;              
                var closing_sales = $(filter_jumlah_closing_sales).val();
                var closing_sales_action = $(this).val();
                    load_closing_sales(closing_sales,closing_sales_action,newdate, 'SBU Jabar:');              
            });

            $('#filter_jumlah_closing_segmen').change(function() {
var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getDate();
var year = dateObj.getUTCFullYear();
var newdate = year + "-0" + month + "-" + day;              
                var closing_segmen = $(this).val();
                var closing_segmen_action = $(filter_jumlah_closing_segmen_action).val();
 load_closing_segmen(closing_segmen,closing_segmen_action,newdate, 'SBU Jabar:');   

               
            });

            $('#filter_jumlah_closing_segmen_action').change(function() {
var dateObj = new Date();
var month = dateObj.getUTCMonth() + 1; //months from 1-12
var day = dateObj.getDate();
var year = dateObj.getUTCFullYear();
var newdate = year + "-0" + month + "-" + day;              
                var closing_segmen = $(filter_jumlah_closing_segmen).val();
                var closing_segmen_action = $(this).val();
 load_closing_segmen(closing_segmen,closing_segmen_action,newdate, 'SBU Jabar:');               
            });             


 function load_total_potensi(tahun,action) {

        $.ajax({
                url: '/admin/fetch_data',
                method:"POST",
                data: {
                "_token": "{{ csrf_token() }}",
                'tahun':tahun,
                'action':action
                },

            success: function (data) {
    
  Highcharts.chart('chart_total_potensi', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data.action
    },
    yAxis: {
           
      labels: {
        formatter: function() {
          if (action == 'Revenue'){ 
          return 'Rp.' + this.axis.defaultLabelFormatter.call(this);
        }else{
          return this.axis.defaultLabelFormatter.call(this);
        }

        }
      },
//    labels: {
//       formatter: function() {
//         if (this.value >= 0) {
//            return 'Rp' + this.value
//          } else {
//            return '-Rp' + (-this.value)
//          }
//        }
//      },
        min: 0,
        title: {
            text: 'Total '+action
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },    tooltip: {
      pointFormatter: function() {
        var value;
         if (action == 'Revenue'){ 
        if (this.y >= 0) {
          value = 'Rp ' + this.y
        } else {
          value = '-Rp ' + (-this.y)
        }
        return '<span style="color:' + this.series.color + '">' + 'Revenue' + '</span>: <b>' + value + '</b><br />'
      }else{
        return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + this.y + '</b><br />'
      }

    },
      shared: true
    },
        credits: {
        enabled: false
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    plotOptions: {
        column: {
            
            dataLabels: {
                enabled: true,
                formatter: function() {
        var value;
         if (action == 'Revenue'){ 
        if (this.y >= 0) {
          value = 'Rp ' + this.y
        } else {
          value = '-Rp ' + (-this.y)
        }
        return value
      }else{
        return this.y
      }

    }
            }
        }
    },
    series: [{
    	name: 'Potensi',
    	
        data: data.total
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

    function load_sales_total_potensi(sales, tahun,action) 
    {
        $.ajax({
            url: '/admin/fetch_data_sales',
            method:"POST",
            data: {
                "_token": "{{ csrf_token() }}",
                'sales':sales,
                'tahun':tahun,
                'action':action                
                },

            success: function (data) {
                
    
  Highcharts.chart('chart_total_potensi_sales', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data.action
    },
    yAxis: {
           
      labels: {
        formatter: function() {
          if (action == 'Revenue'){ 
          return 'Rp.' + this.axis.defaultLabelFormatter.call(this);
        }else{
          return this.axis.defaultLabelFormatter.call(this);
        }

        }
      },
//    labels: {
//       formatter: function() {
//         if (this.value >= 0) {
//            return 'Rp' + this.value
//          } else {
//            return '-Rp' + (-this.value)
//          }
//        }
//      },
        min: 0,
        title: {
            text: 'Total '+action
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },    tooltip: {
      pointFormatter: function() {
        var value;
         if (action == 'Revenue'){ 
        if (this.y >= 0) {
          value = 'Rp ' + this.y
        } else {
          value = '-Rp ' + (-this.y)
        }
        return '<span style="color:' + this.series.color + '">' + 'Revenue' + '</span>: <b>' + value + '</b><br />'
      }else{
        return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + this.y + '</b><br />'
      }

    },
      shared: true
    },   credits: {
        enabled: false
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                formatter: function() {
        var value;
         if (action == 'Revenue'){ 
        if (this.y >= 0) {
          value = 'Rp ' + this.y
        } else {
          value = '-Rp ' + (-this.y)
        }
        return value
      }else{
        return this.y
      }

    }
            }
        }
    },
    series: [{
        name: 'Potensi',
        data: data.total
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

   function load_segmen_total_potensi(segmen, tahun,action) 
  {
      $.ajax({
          url: '/admin/fetch_data_segmen',
          method:"POST",
          data: {
              "_token": "{{ csrf_token() }}",
              'segmen':segmen,
              'tahun':tahun,
                'action':action              
                },

            success: function (data) {
  Highcharts.chart('chart_total_potensi_segmen', {
    chart: {
        type: 'column'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data.action
    },
    yAxis: {
           
      labels: {
        formatter: function() {
          if (action == 'Revenue'){ 
          return 'Rp.' + this.axis.defaultLabelFormatter.call(this);
        }else{
          return this.axis.defaultLabelFormatter.call(this);
        }

        }
      },
//    labels: {
//       formatter: function() {
//         if (this.value >= 0) {
//            return 'Rp' + this.value
//          } else {
//            return '-Rp' + (-this.value)
//          }
//        }
//      },
        min: 0,
        title: {
            text: 'Total '+action
        },
        stackLabels: {
            enabled: true,
            style: {
                fontWeight: 'bold',
                color: ( // theme
                    Highcharts.defaultOptions.title.style &&
                    Highcharts.defaultOptions.title.style.color
                ) || 'gray'
            }
        }
    },    tooltip: {
      pointFormatter: function() {
        var value;
         if (action == 'Revenue'){ 
        if (this.y >= 0) {
          value = 'Rp ' + this.y
        } else {
          value = '-Rp ' + (-this.y)
        }
        return '<span style="color:' + this.series.color + '">' + 'Revenue' + '</span>: <b>' + value + '</b><br />'
      }else{
        return '<span style="color:' + this.series.color + '">' + this.series.name + '</span>: <b>' + this.y + '</b><br />'
      }

    },
      shared: true
    },   credits: {
        enabled: false
    },
    legend: {
        align: 'right',
        x: -30,
        verticalAlign: 'top',
        y: 25,
        floating: true,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || 'white',
        borderColor: '#CCC',
        borderWidth: 1,
        shadow: false
    },
    plotOptions: {
        column: {
            dataLabels: {
                enabled: true,
                formatter: function() {
        var value;
         if (action == 'Revenue'){ 
        if (this.y >= 0) {
          value = 'Rp ' + this.y
        } else {
          value = '-Rp ' + (-this.y)
        }
        return value
      }else{
        return this.y
      }

    }
            }
        }
    },
    series: [{
        name: 'Potensi',
        data: data.total
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    }; 

  function load_data_bulanan(jenis,tahun, title) 
    {
        const temp_title = title + ' ' + tahun
        $.ajax({
            url: '/admin/fetch_potency_month',
            method:"POST",
            data: {
                "_token": "{{ csrf_token() }}",
                'jenis':jenis,
                'tahun':tahun
                },

            success: function (data) {
    
  Highcharts.chart('chart_data_bulanan_all', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: ''
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
        categories: [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'Descember'
        ]
    },
    yAxis: {
        title: {
            text: 'Total Target dan Real'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Potensi'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'Target',
        data: data.Target
    }, {
        name: 'Real',
        data: data.Real
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

function load_data_bulanan_sales(id_sales,jenis,tahun, title) 
  {
      const temp_title = title + ' ' + tahun
      $.ajax({
          url: '/admin/fetch_potency_month_sales',
          method:"POST",
          data: {
              "_token": "{{ csrf_token() }}",
              'id_sales':id_sales,
              'jenis':jenis,
              'tahun':tahun
                },

            success: function (data) {
    
  Highcharts.chart('chart_data_bulanan_sales', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: ''
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
        categories: [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'Descember'
        ]
    },
    yAxis: {
        title: {
            text: 'Total Target dan Real'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Potensi'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'Target',
        data: data.Target
    }, {
        name: 'Real',
        data: data.Real
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

function load_data_bulanan_segmen(segmen,jenis,tahun, title) 
{
    const temp_title = title + ' ' + tahun
    $.ajax({
        url: '/admin/fetch_potency_month_segmen',
        method:"POST",
        data: {
            "_token": "{{ csrf_token() }}",
            'segmen':segmen,
            'jenis':jenis,
            'tahun':tahun
                },

            success: function (data) {
    
  Highcharts.chart('chart_data_bulanan_segmen', {
    chart: {
        type: 'areaspline'
    },
    title: {
        text: ''
    },
    legend: {
        layout: 'vertical',
        align: 'left',
        verticalAlign: 'top',
        x: 150,
        y: 100,
        floating: true,
        borderWidth: 1,
        backgroundColor:
            Highcharts.defaultOptions.legend.backgroundColor || '#FFFFFF'
    },
    xAxis: {
        categories: [
            'January',
            'February',
            'March',
            'April',
            'May',
            'June',
            'July',
            'August',
            'September',
            'October',
            'November',
            'Descember'
        ]
    },
    yAxis: {
        title: {
            text: 'Total Target dan Real'
        }
    },
    tooltip: {
        shared: true,
        valueSuffix: ' Potensi'
    },
    credits: {
        enabled: false
    },
    plotOptions: {
        areaspline: {
            fillOpacity: 0.5
        }
    },
    series: [{
        name: 'Target',
        data: data.Target
    }, {
        name: 'Real',
        data: data.Real
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

function load_closing(filter,newdate, title) {
    const temp_title = title + ' ' + filter;
    $.ajax({
        url: '/admin/fetch_closing',
        method:"POST",
        data: {
            "_token": "{{ csrf_token() }}",
            'filter':filter,
            'newdate':newdate
                },

            success: function (data) {
Highcharts.chart('chart_closing_all', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data.detail
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Potensi'
        }
    },    credits: {
        enabled: false
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Potensi',
        data: data.closing
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

 function load_closing_sales(id_sales,filter,newdate, title) {
  const temp_title = title + ' ' + id_sales;
  $.ajax({
      url: '/admin/fetch_closing_sales',
      method:"POST",
      data: {
          "_token": "{{ csrf_token() }}",
          'id_sales':id_sales,
          'filter':filter,
          'newdate':newdate
                },

            success: function (data) {
    
Highcharts.chart('chart_closing_sales', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data.detail
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Potensi'
        }
    },    credits: {
        enabled: false
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Potensi',
        data: data.closing
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };

function load_closing_segmen(jenis_pelanggan,filter,newdate, title) {
const temp_title = title + ' ' + jenis_pelanggan;
$.ajax({
    url: '/admin/fetch_closing_segmen',
    method:"POST",
    data: {
        "_token": "{{ csrf_token() }}",
        'jenis_pelanggan':jenis_pelanggan,
        'filter':filter,
        'newdate':newdate
                },

            success: function (data) {
    
Highcharts.chart('chart_closing_segmen', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories: data.detail
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Potensi'
        }
    },    credits: {
        enabled: false
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Potensi',
        data: data.closing
    }]
});
            },
            error: function (error) {
                alert(error);
            }
        });
    };
    $(document).ready(function() {
                                    var dateObj = new Date();
                                    var month = dateObj.getUTCMonth() + 1; //months from 1-12
                                    var day = dateObj.getDate();
                                    var year = dateObj.getUTCFullYear();
                                    var newdate = year + "-0" + month + "-" + day;

                var tahun_potensi = $(filter_tahun_di_total_potensi).val();
                var tahun_potensi_sales = $(filter_tahun_di_total_potensi_sales).val();
                var tahun_potensi_segmen = $(filter_tahun_di_total_potensi_segmen).val();   
                var id_sales = $(filter_sales_chart_total_potensi).val();
                var segmen = $(filter_segmen_chart_total_potensi).val();
                var action_potensi = $(filter_action_total_potensi).val();
                var action_potensi_sales = $(filter_action_total_potensi_sales).val();   
                var action_potensi_segmen = $(filter_action_total_potensi_segmen).val();                   
                    load_total_potensi(tahun_potensi,action_potensi);             
                    load_sales_total_potensi(id_sales, tahun_potensi_sales,action_potensi_sales);               
                    load_segmen_total_potensi(segmen, tahun_potensi_segmen,action_potensi_segmen);

                var tahun_pertama =  new Date().getFullYear();
                var jenis_bulanan = $(filter_jenis_data_bulanan).val();               
                  load_data_bulanan(jenis_bulanan,tahun_pertama, 'Tahun:');

                var id_sales_bulanan = $(filter_sales_data_bulanan).val();
                var jenis_sales_bulanan = $(filter_jenis_data_bulanan_sales).val();
                var tahun_kedua = new Date().getFullYear();
                  load_data_bulanan_sales(id_sales_bulanan,jenis_sales_bulanan,tahun_kedua, 'Tahun:');

                var segmen_bulanan = $(filter_segmen_data_bulanan).val();
                var jenis_segmen_bulanan = $(filter_jenis_data_bulanan_segmen).val();
                var tahun_ketiga = new Date().getFullYear();
                  load_data_bulanan_segmen(segmen_bulanan,jenis_segmen_bulanan,tahun_ketiga, 'Tahun:');

                var closing = $(filter_jumlah_closing_action).val();
                  load_closing(closing,newdate, 'SBU Jabar:');

                var closing_sales = $(filter_jumlah_closing_sales).val();
                var closing_sales_action = $(filter_jumlah_closing_sales_action).val();              
                    load_closing_sales(closing_sales,closing_sales_action,newdate, 'SBU Jabar:');

                var closing_segmen = $(filter_jumlah_closing_segmen).val();
                var closing_segmen_action = $(filter_jumlah_closing_segmen_action).val();                
                    load_closing_segmen(closing_segmen,closing_segmen_action,newdate, 'SBU Jabar:');                                                                              
});

Highcharts.chart('chart_total_customers_sales', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories:         <?php echo json_encode($nama_sales);?>
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Customers'
        }
    },    credits: {
        enabled: false
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Customers',
        data: <?php echo json_encode($total);?>
    }]
});

Highcharts.chart('chart_total_customers_segmen', {
    chart: {
        type: 'bar'
    },
    title: {
        text: ''
    },
    xAxis: {
        categories:         <?php echo json_encode($nama_segmen);?>
    },
    yAxis: {
        min: 0,
        title: {
            text: 'Total Customers'
        }
    },    credits: {
        enabled: false
    },
    legend: {
        reversed: true
    },
    plotOptions: {
        series: {
            stacking: 'normal'
        }
    },
    series: [{
        name: 'Customers',
        data: <?php echo json_encode($total_segmen);?>
    }]
});     
</script>

@endpush

<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.5/js/bootstrap.min.js"></script>
