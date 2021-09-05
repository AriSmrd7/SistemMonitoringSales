@extends('layout.master')
@section('title', 'Data Customers')
@push('plugin-styles')
     <link href="{{ asset('assets') }}/plugins/dragula/dragula.min.css" rel="stylesheet">
@endpush

@section('content')

    <div class="container-fluid mt--8">
        
        <div class="row mt-1">
             <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Data Customer</h4>
                            </div>
                        </div>
                    </div>
                    <div class="row col-md-12">
                        <div class="col col-md-12 text-right">
                            <a href="{{ route('sales.format_customer') }}" class="btn btn-md btn-primary btn-success">FORMAT CUSTOMER</a>
                         <button type="button" class="btn btn-md btn-primary btn-success" data-toggle="modal" data-target="#importCustomers">IMPORT EXCEL</button>
                            <!-- Import Excel -->
                            <div class="modal fade" id="importCustomers" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog" role="document">
                                    <form method="post" action="{{ route('sales.import_excel') }}" enctype="multipart/form-data">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="exampleModalLabel">Import Excel</h5>
                                            </div>
                                            <div class="modal-body">
                                            {{ csrf_field() }}
                                             <label>Pilih File Excel</label>
                                                <div class="form-group">
                                                    <input type="file" name="file" required="required">
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
                            <a href="customer/add" class="btn btn-md btn-primary">Tambah Customer</a>
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
                    @if($message = Session::get('sales_customer_add'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('sales_customer_edit'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('sales_customer_delete'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('sales_customer_import'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="card-body table-responsive">
						<table class="table table-striped table-bordered" id="customer-table">
								<thead>
									<tr>
                                    <th>No</th>
                                    <th>Nama Pelanggan</th>
                                    <th>Sales</th>
                                    <th>Jenis Pelanggan</th>
                                    <th>Jumlah Site</th>
                                    <th>Status Pelanggan</th>
                                    <th>Kategori Pelanggan</th>
                                    <th width="1%">Action</th>
									</tr>
								</thead>
							</table>

						@push('plugin-scripts')
						<script>
						$(function() {
							$('#customer-table').DataTable({
								processing: true,
								serverSide: true,
								ajax: 'customer/json',
								columns: [
									{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
									{ data: 'nama_pelanggan', name: 'nama_pelanggan' },
                                    { data: 'nama_sales', name: 'nama_sales' },
									{ data: 'jenis_pelanggan', name: 'jenis_pelanggan' },
									{ data: 'jumlah_site', name: 'jumlah_site' },
									{ data: 'status_pelanggan', name: 'status_pelanggan' },
                                    { data: 'kategori_pelanggan', name: 'kategori_pelanggan' },
									 {data: 'action', name: 'action', orderable: false, searchable: false},
								]
							});
						});
						</script>
						@endpush
                    </div>
                </div>
            </div>
        </div>
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
		<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    </div>
@endsection

@push('plugin-scripts')
   <script src="{{ asset('assets') }}/plugins/dragula/dragula.min.js"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets') }}/js/dragula.js"></script>
@endpush
