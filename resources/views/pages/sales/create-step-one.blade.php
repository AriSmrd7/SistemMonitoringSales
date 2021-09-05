@extends('layout.master')
@section('title', 'Data Potensi | Tambah')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data Potensi</h4>
								<hr>
								<h6 class="text-muted">Step 1</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <form action="{{ route('sales.create.step.one.post') }}" method="POST">
							@csrf
										@if ($errors->any())
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
									    <div class="form-group">
										  <label for="id_sbu">SBU Region</label>							  
										  <select name="id_sbu" class="custom-select" required>
										  <option>-- Pilih --</option>
											@foreach($sbunames as $datax)
												<option value="{{$datax->id_sbu}}" {{{ (isset($potencies->id_sbu) && $datax->id_sbu == $potencies->id_sbu) ? "selected" : "" }}}>{{$datax->sbu_region}}</option>
											@endforeach
										  </select>
									    </div>
										
										<div class="form-group">
										  <label for="id_pelanggan">Pelanggan</label>							  
										  <select name="id_pelanggan" class="custom-select">
											<option>-- Pilih Pelanggan --</option>
											@foreach($customers as $dataz)
												<option value="{{$dataz->id_pelanggan}}" {{{ (isset($potencies->id_pelanggan) && $dataz->id_pelanggan == $potencies->id_pelanggan) ? "selected" : "" }}}>{{$dataz->nama_pelanggan}}</option>
											@endforeach
										  </select>
										</div>
										
										<div class="form-group">
										  <label for="id_service">Service</label>								  
										  <select name="id_service" class="custom-select">
											<option>-- Pilih Service --</option>
											@foreach($services as $data1)
												<option value="{{$data1->id_service}}" {{{ (isset($potencies->id_service) && $data1->id_service == $potencies->id_service) ? "selected" : "" }}}>{{$data1->segmen_service}}</option>
											@endforeach
										  </select>
										</div>
										
										<div class="form-group">
											<label for="kapasitas">Kapasitas</label>
											<input class="form-control" placeholder="0" name="kapasitas" onkeypress="return hanyaAngka(event)" type="text" value="{{ $potencies->kapasitas ?? '' }}">
										</div>
										
										<div class="form-group">
										  <label for="satuan_kapasitas">Satuan</label>								  
										  <select name="satuan_kapasitas" class="custom-select">
											<option>-- Pilih Satuan --</option>
											<option value="Units" {{{ (isset($potencies->satuan_kapasitas) && $potencies->satuan_kapasitas == 'Units') ? "selected" : "" }}}>Units</option>
											<option value="Mbps" {{{ (isset($potencies->satuan_kapasitas) && $potencies->satuan_kapasitas == 'Mbps') ? "selected" : "" }}}>Mbps</option>
											<option value="Kbps" {{{ (isset($potencies->satuan_kapasitas) && $potencies->satuan_kapasitas == 'Kbps') ? "selected" : "" }}}>Kbps</option>
											<option value="Transaksi" {{{ (isset($potencies->satuan_kapasitas) && $potencies->satuan_kapasitas == 'Transaksi') ? "selected" : "" }}}>Transaksi</option>
											<option value="VM" {{{ (isset($potencies->satuan_kapasitas) && $potencies->satuan_kapasitas == 'VM') ? "selected" : "" }}}>VM</option>
											<option value="Impresi" {{{ (isset($potencies->satuan_kapasitas) && $potencies->satuan_kapasitas == 'Impresi') ? "selected" : "" }}}>Impresi</option>
										  </select>
										</div>

										<div class="form-group">
										  <label for="update_action_plan">Action Plan</label>				
										  <select name="update_action_plan" class="custom-select">
											<option>-- Pilih Action Plan --</option>
											<option value="PENAWARAN" {{{ (isset($potencies->update_action_plan) && $potencies->update_action_plan == 'PENAWARAN') ? "selected" : "" }}}>PENAWARAN</option>
											<option value="NEGOSIASI" {{{ (isset($potencies->update_action_plan) && $potencies->update_action_plan == 'NEGOSIASI') ? "selected" : "" }}}>NEGOSIASI</option>
											<option value="CLOSING" {{{ (isset($potencies->update_action_plan) && $potencies->update_action_plan == 'CLOSING') ? "selected" : "" }}}>CLOSING</option>
											<option value="LOSS" {{{ (isset($potencies->update_action_plan) && $potencies->update_action_plan == 'LOSS') ? "selected" : "" }}}>LOSS</option>
											<option value="AKTIVASI" {{{ (isset($potencies->update_action_plan) && $potencies->update_action_plan == 'AKTIVASI') ? "selected" : "" }}}>AKTIVASI</option>
										  </select>
										</div>
										
										<div class="form-group">
										  <label for="id_kantor">Kantor</label>								  
										  <select name="id_kantor" class="custom-select">
											<option>-- Pilih Kantor --</option>
											@foreach($offices as $data2)
												<option value="{{$data2->id_kantor}}" {{{ (isset($potencies->id_kantor) && $data2->id_kantor == $potencies->id_kantor) ? "selected" : "" }}}>{{$data2->nama_kantor}}</option>
											@endforeach
										  </select>
										</div>
								<div class="card-body text-right">
									<button type="submit" class="btn btn-primary btn-lg">Next</button>
								</div>
						</form>

                    </div>
                </div>
            </div>
        </div>
@endsection
