@extends('layout.master')
@section('title', 'Data Service')
@section('content')
        <div class="row mt-1">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Data Service</h4>
                            </div>
                        </div>
                    </div>
					<div class="row col-md-12">
						<div class="col col-md-12 text-right">
							<a href="service/add" class="btn btn-md btn-primary">Tambah Service</a>
						</div>
					</div>

					@if($message = Session::get('admin_service_add'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_service_edit'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_service_delete'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="card-body table-responsive">
						<table class="table table-striped table-bordered" id="service-table">
								<thead>
									<tr>
                                    <th>No</th>
                                    <th>Segmen Service</th>
                                    <th>Jenis Service</th>
                                    <th>Kategori Service</th>
                                    <th>Action</th>
									</tr>
								</thead>
							</table>

						@push('plugin-scripts')
						<script>
						$(function() {
							$('#service-table').DataTable({
								processing: true,
								serverSide: true,
								ajax: 'service/json',
								columns: [
									{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
									{ data: 'segmen_service', name: 'segmen_service' },
									{ data: 'jenis_service', name: 'jenis_service' },
									{ data: 'kategori_service', name: 'kategori_service' },
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
@endsection
