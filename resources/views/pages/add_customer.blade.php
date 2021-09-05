@extends('layout.master')
@section('title', 'Data Customers | Tambah')
@section('content')

        <div class="row mt-1">
			<div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data Customers</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/admin/customer/store" class="form-horizontal">
                        {{ csrf_field() }}

                            @if (session('status'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    {{ session('status') }}
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            <div class="pl-lg-4">
                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}" hidden="true">
                                    <label class="form-control-label" for="input-name">{{ __('ID Pelanggan') }}</label>
                                    <input class="form-control" name="id" id="input-id" type="text">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Pelanggan') }}</label>
                                    <input class="form-control" name="nama_pelanggan" id="nama_pelanggan" type="text" placeholder="{{ __('Nama Pelanggan') }}" required="required">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Sales') }}</label>
                                    <select name="id_sales" id="id_sales" class="custom-select" placeholder="-- Pilih Sales --">
                                        <option>-- Pilih Sales --</option>
                                            @foreach ($sales as $datay)
                                              <option value="{{ $datay->id_sales }}">{{ $datay->nama_sales }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                 <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Jenis Pelanggan') }}</label>
                                    <select name="jenis_pelanggan" id="jenis_pelanggan" class="custom-select">
                                        <option>-- Pilih Jenis --</option>
                                        <option value="Transportation">Transportation</option>
                                        <option value="Government">Government</option>
                                        <option value="Manufacture">Manufacture</option>
                                        <option value="Banking & Financial">Banking & Financial</option>
                                        <option value="Hospitality">Hospitality</option>
                                        <option value="Retail Distribution">Retail Distribution</option>
                                        <option value="Cell Oprtr Provider">Cell Oprtr Provider</option>
                                        <option value="PLN Group">PLN Group</option>
                                        <option value="Energy Utility Mining">Energy Utility Mining</option>
                                        <option value="Data Comm Oprtr">Data Comm Oprtr</option>
                                        <option value="Consultant, Contract">Consultant, Contract</option>
                                        <option value="Telecommunication">Telecommunication</option>
                                        <option value="Natural Resources">Natural Resources</option>
                                        <option value="Healthcare">Healthcare</option>
                                        <option value="Education">Education</option>
                                        <option value="Professional Association">Professional Association</option>
                                        <option value="Media & Entertain">Media & Entertain</option>
                                        <option value="Property">Property</option>
                                        <option value="UMKM & Retail">UMKM & Retail</option>
                                    </select>
                                </div>

                                 <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Jumlah Site') }}</label>
                                     <input class="form-control"  onkeypress="return hanyaAngka(event)" type="text" maxlength="5" name="jumlah_site" id="jumlah_site" type="text" placeholder="{{ __('Jumlah Site') }}" required="required">
                                </div>

                                 <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Status Pelanggan') }}</label>
                                    <select name="status_pelanggan" id="city" class="custom-select" required>
                                        <option>-- Pilih Status --</option>
                                        <option value="BARU">BARU</option>
                                        <option  value="LAMA">LAMA</option>
                                    </select>
                                 </div>						
									
                                 <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Kategori Pelanggan') }}</label>
                                    <select name="kategori_pelanggan" id="city" class="custom-select">
                                        <option>-- Pilih Kategori --</option>
										<option value="PLN">PLN</option>
                                        <option value="PUBLIK">PUBLIK</option>
                                    </select>
                                 </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="mdi mdi-content-save"></i> {{ __('Simpan') }}</button>
                                </div>
                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection

