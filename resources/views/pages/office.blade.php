@extends('layout.master')
@section('title', 'Data Office')
@section('content')

        <div class="row mt-1">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Data Office</h4>
                            </div>
                        </div>
                    </div>
					<div class="row col-md-12">
						<div class="col col-md-12 text-right">
							<a href="office/add" class="btn btn-md btn-primary">Tambah Office</a>
						</div>
					</div>

					@if($message = Session::get('admin_office_add'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_office_edit'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_office_delete'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="card-body table-responsive">
						<table class="table table-striped table-bordered" id="office-table">
								<thead>
									<tr>
										<th width="2%">No</th>
										<th>Nama Kantor</th>
										<th width="5%">Action</th>
									</tr>
								</thead>
							</table>

						@push('plugin-scripts')
						<script>
						$(function() {
							$('#office-table').DataTable({
								processing: true,
								serverSide: true,
								ajax: 'office/json',
								columns: [
									{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
									{ data: 'nama_kantor', name: 'nama_kantor' },
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