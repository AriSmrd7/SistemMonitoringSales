@extends('layout.master')
@section('title', 'Data Potensi | Tambah')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Review Data Potensi</h4>
								<hr>
								<h6 class="text-muted">Step 5 - Selesai</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       
					      <form action="{{ route('sales.create.step.five.post') }}" method="post" >
							{{ csrf_field() }}
										<table class="table table-hover">
											<tr>
												<td>SBU Region :</td>
												<td><strong>@foreach($nama_sbu as $data)
															{{$data->sbu_region}}
															@endforeach</strong></td>
											</tr>
											<tr>
												<td>Pelanggan :</td>
												<td><strong>@foreach($nama_sales as $data)
													{{$data->nama_pelanggan}}
													@endforeach</strong></td>
											</tr>
											<tr>
												<td>Service :</td>
												<td><strong>@foreach($nama_service as $data)
													{{$data->segmen_service}}
													@endforeach</strong></td>
											</tr>
											<tr>
												<td>Kapasitas :</td>
												<td><strong>{{$potencies->kapasitas}}</strong></td>
											</tr>
											<tr>
												<td>Satuan :</td>
												<td><strong>{{$potencies->satuan_kapasitas}}</strong></td>
											</tr>
											<tr>
												<td>Originating :</td>
												<td><strong>{{$potencies->originating}}</strong></td>
											</tr>
											<tr>
												<td>Terminating :</td>
												<td><strong>{{$potencies->terminating}}</strong></td>
											</tr>
											<tr>
												<td>SBU Originating :</td>
												<td><strong>{{$potencies->sbu_originating}}</strong></td>
											</tr>
											<tr>
												<td>SBU Terminating :</td>
												<td><strong>{{$potencies->sbu_terminating}}</strong></td>
											</tr>
											<tr>
												<td>Instalasi OTC :</td>
												<td><strong>{{$potencies->instalasi_otc}}</strong></td>
											</tr>
											<tr>
												<td>Sewa :</td>
												<td><strong>{{$potencies->sewa_bln}}</strong></td>
											</tr>
											<tr>
												<td>QTY :</td>
												<td><strong>{{$potencies->qty}}</strong></td>
											</tr>
											<tr>
												<td>Target Aktivasi :</td>
												<td><strong>{{$potencies->target_aktivasi_bln}}</strong></td>
											</tr>
											<tr>
												<td>Revenue :</td>
												<td><strong>{{$potencies->revenue_formula}}</strong></td>
											</tr>
											<tr>
												<td>Target Quote :</td>
												<td><strong>{{$potencies->target_quote}}</strong></td>
											</tr>
											<tr>
												<td>Target Nego :</td>
												<td><strong>{{$potencies->target_nego}}</strong></td>
											</tr>
											<tr>
												<td>Target PO :</td>
												<td><strong>{{$potencies->target_po}}</strong></td>
											</tr>
											<tr>
												<td>Warna Potensi :</td>
												<td><strong>{{$potencies->warna_potensi}}</strong></td>
											</tr>
											<tr>
												<td>Update Action Plan :</td>
												<td><strong>{{$potencies->update_action_plan}}</strong></td>
											</tr>
											<tr>
												<td>Kantor :</td>
												<td><strong>{{$potencies->id_kantor}}</strong></td>
											</tr>
											<tr>
												<td>Anggaran :</td>
												<td><strong>{{$potencies->anggaran_pra_penjualan}}</strong></td>
											</tr>
										</table>
								<div class="card-body">
									<div class="row">
										<div class="col-md-6 text-left">
											<a href="{{ route('sales.create.step.four') }}" class="btn btn-lg btn-danger pull-right">Previous</a>
										</div>
										<div class="col-md-6 text-right">
											<button type="submit" class="btn btn-lg btn-primary">Submit</button>
										</div>
									</div>
								</div>
						</form>

                    </div>
                </div>
            </div>
        </div>
@endsection