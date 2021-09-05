@extends('layout.master')
@section('title', 'Data SBU')
@section('content')

        <div class="row mt-1">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Data SBU</h4>
                            </div>
                        </div>
                    </div>
					<div class="row col-md-12">
						<div class="col col-md-12 text-right">
							<a href="sbu/add" class="btn btn-md btn-primary">Tambah SBU</a>
						</div>
					</div>

					@if($message = Session::get('admin_sbu_add'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_sbu_edit'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif
                    @if($message = Session::get('admin_sbu_delete'))
                    <div class="alert alert-success alert-block">
                    <button type="button" class="close" data-dismiss="alert">×</button>
                        <strong>{{ $message }}</strong>
                    </div>
                    @endif

                    <div class="card-body table-responsive">
						<table class="table table-striped table-bordered" id="sbu-table">
								<thead>
									<tr>
										<th width="2%">No</th>
										<th>SBU Region</th>
										<th>SBU Originating</th>
										<th>SBU Terminating</th>
										<th width="5%">Action</th>
									</tr>
								</thead>
							</table>

						@push('plugin-scripts')
						<script>
						$(function() {
							$('#sbu-table').DataTable({
								processing: true,
								serverSide: true,
								ajax: 'sbu/json',
								columns: [
									{ data: 'DT_RowIndex', name: 'DT_RowIndex' },
									{ data: 'sbu_region', name: 'sbu_region' },
									{ data: 'sbu_originating', name: 'sbu_originating' },
									{ data: 'sbu_terminating', name: 'sbu_terminating' },
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