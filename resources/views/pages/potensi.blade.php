@extends('layout.master')
@section('title', 'Data Potensi')

@push('plugin-styles')
     <link href="{{ asset('assets') }}/plugins/datatables.net-fixedcolumns-bs4/fixedColumns.bootstrap4.min.css" rel="stylesheet">
@endpush

@section('content')
        <div class="row mt-1">
        <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Data Potensi</h4>
                            </div>
                        </div>
                    </div>
					<div class="row col-md-12">
						<div class="col col-md-12 text-right">
                            <a href="{{ route('format_potensi') }}" class="btn btn-md btn-primary btn-success">FORMAT POTENSI</a>
                            <button type="button" class="btn btn-md btn-primary btn-success" data-toggle="modal" data-target="#importPotencies">IMPORT EXCEL</button>
                            <!-- Import Excel -->
                            <div class="modal fade" id="importPotencies" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('import') }}" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                            </div>
                                            <div class="modal-body">
                                            {{ csrf_field() }}
                                             <label>Pilih File Excel</label>
                                                <div class="form-group">
                                                    <input type="file" class="form-control-file" name="file" required="required">
                                                </div>
                                            </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                            <button type="submit" class="btn btn-primary">Import</button>
                                        </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <a href="{{ route('excel') }}" class="btn btn-md btn-primary btn-success">EXPORT EXCEL</a>
                
                            <a href="potensi/create-step-one" class="btn btn-md btn-primary"></i>Tambah Potensi</a>
                        </div>
                    </div>
					
                    @if ($errors->any())
                    <div class="alert alert-danger">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                    @endif
                    @if($message = Session::get('admin_potensi_import'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_potensi_add'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_potensi_edit '))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    
                    <div class="card-body table-responsive">
						<table class="table table-striped table-bordered" style="width:100%" id="potensi-table">
								<thead>
									<tr>
                                    <th scope="col">No</th>
                                    <th scope="col">SBU Region</th>
                                    <th scope="col">Pelanggan</th>
                                    <th scope="col">Sales</th>
                                    <th scope="col">Service</th>
                                    <th scope="col">Kapasitas</th>
                                    <th scope="col">Satuan</th>
                                    <th scope="col">Kantor</th>
                                    <th scope="col">Action Plan</th>
                                    <th scope="col" width="2%">Action</th>
									</tr>
								</thead>
							</table>

						@push('plugin-scripts')
						<script>
						$(function() {

							$('#potensi-table').DataTable({
								processing: true,
								serverSide: true,
								ajax: 'potensi/json',
								columns: [
									{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
									{ data: 'sbu_region', name: 'sbu_region' },
									{ data: 'nama_pelanggan', name: 'nama_pelanggan' },
                                    { data: 'nama_sales', name: 'nama_sales' },
									{ data: 'segmen_service', name: 'segmen_service' },
                                    { data: 'kapasitas', name: 'kapasitas' },
                                    { data: 'satuan_kapasitas', name: 'satuan_kapasitas' },
                                    { data: 'nama_kantor', name: 'nama_kantor' },
                                    { data: 'update_action_plan', name: 'update_action_plan' },
									 {data: 'action', name: 'action', orderable: false, searchable: false},
								],
                                'rowCallback': function(row, data, index){
                                    var dateObj = new Date();
                                    var month = dateObj.getUTCMonth() + 1; //months from 1-12
                                    var day = dateObj.getUTCDate();
                                    var year = dateObj.getUTCFullYear();
                                    newdate = Date.parse(year + "-0" + month + "-" + day); 
                                    var cek_quote = Date.parse(data.target_quote);
                                    var cek_nego = Date.parse(data.target_nego);
                                    var cek_po = Date.parse(data.target_po);
                                     if(data.real_quote == null && cek_quote <= newdate){
                                     $(row).css('background-color', '#ef9a9a      ');
                                     }
                                     if(data.real_nego == null && cek_nego <= newdate){
                                     $(row).css('background-color', '#ef9a9a      ');
                                     }  
                                     if(data.real_po == null && cek_po <= newdate){
                                     $(row).css('background-color', '#ef9a9a      ');
                                     }                                                                                                                                            
                              }                                 
							});                                             
						});
						</script>
						@endpush
                    </div>
                </div>
            </div>
        </div>
@endsection