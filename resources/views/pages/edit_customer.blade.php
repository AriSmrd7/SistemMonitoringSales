@extends('layout.master')
@section('title', 'Data Customers | Edit')
@section('content')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Edit Data Customer</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($customers as $data)
                        <form method="post" action="/admin/customer/update" class="form-horizontal">
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
                                     <input class="form-control" name="id" id="input-id" type="text" value="{{$data->id_pelanggan}}"
                      readonly>
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Pelanggan') }}</label>
                                    <input class="form-control" name="nama_pelanggan" id="nama_pelanggan" type="text" placeholder="{{ __('Nama Pelanggan') }}" value="{{$data->nama_pelanggan}}">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Sales') }}</label>
                                    <select name="id_sales" id="id_sales" class="custom-select">
                                        @foreach ($sales as $datay)
                                              <option value="{{ $datay->id_sales }}" {{$datay->id_sales==$data->id_sales ? 'selected' : ''}}>{{ $datay->nama_sales }}</option>
                                            @endforeach
                                    </select>
                                </div>

                                <label class="form-control-label" for="input-name">{{ __('Jenis Pelanggan') }}</label>
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                     <select name="jenis_pelanggan" id="jenis_pelanggan" class="custom-select">
                                        <option <?=($data->jenis_pelanggan =='Transportation')?'selected="selected"':''?> value="Transportation">Transportation</option>
                                        <option <?=($data->jenis_pelanggan =='Government')?'selected="selected"':''?> value="Government">Government</option>
                                        <option <?=($data->jenis_pelanggan =='Manufacture')?'selected="selected"':''?> value="Manufacture">Manufacture</option>
                                        <option <?=($data->jenis_pelanggan =='Banking & Financial')?'selected="selected"':''?> value="Banking & Financial">Banking & Financial</option>
                                        <option <?=($data->jenis_pelanggan =='Hospitality')?'selected="selected"':''?> value="Hospitality">Hospitality</option>
                                        <option <?=($data->jenis_pelanggan =='Retail Distribution')?'selected="selected"':''?> value="Retail Distribution">Retail Distribution</option>
                                        <option <?=($data->jenis_pelanggan =='Cell Oprtr Provider')?'selected="selected"':''?> value="Cell Oprtr Provider">Cell Oprtr Provider</option>
                                        <option <?=($data->jenis_pelanggan =='PLN Group')?'selected="selected"':''?> value="PLN Group">PLN Group</option>
                                        <option <?=($data->jenis_pelanggan =='Energy Utility Mining')?'selected="selected"':''?> value="Energy Utility Mining">Energy Utility Mining</option>
                                        <option <?=($data->jenis_pelanggan =='ata Comm Oprtr')?'selected="selected"':''?> value="Data Comm Oprtr">Data Comm Oprtr</option>
                                        <option <?=($data->jenis_pelanggan =='Consultant, Contract')?'selected="selected"':''?> value="Consultant, Contract">Consultant, Contract</option>
                                        <option <?=($data->jenis_pelanggan =='Telecommunication')?'selected="selected"':''?> value="Telecommunication">Telecommunication</option>
                                        <option <?=($data->jenis_pelanggan =='Natural Resources')?'selected="selected"':''?> value="Natural Resources">Natural Resources</option>
                                        <option <?=($data->jenis_pelanggan =='Healthcare')?'selected="selected"':''?> value="Healthcare">Healthcare</option>
                                        <option <?=($data->jenis_pelanggan =='Education')?'selected="selected"':''?> value="Education">Education</option>
                                        <option <?=($data->jenis_pelanggan =='Professional Association')?'selected="selected"':''?> value="Professional Association">Professional Association</option>
                                        <option <?=($data->jenis_pelanggan =='Media & Entertain')?'selected="selected"':''?> value="Media & Entertain">Media & Entertain</option>
                                        <option <?=($data->jenis_pelanggan =='Property')?'selected="selected"':''?> value="Property">Property</option>
                                        <option <?=($data->jenis_pelanggan =='UMKM & Retail')?'selected="selected"':''?> value="UMKM & Retail">UMKM & Retail</option>
                                    </select>
                                    </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Jumlah Site') }}</label>
                                    <input class="form-control" maxlength="5" type="text" name="jumlah_site" id="jumlah_site" type="text" placeholder="{{ __('Jumlah Site') }}" value="{{$data->jumlah_site}}" onkeypress="return hanyaAngka(event)">
                                </div>

                                <label class="form-control-label" for="input-name">{{ __('Status Pelanggan') }}</label>
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                     <select name="status_pelanggan" id="city" class="custom-select">
                                          <option <?=($data->status_pelanggan =='BARU')?'selected="selected"':''?> value="BARU">BARU</option>
                                          <option <?=($data->status_pelanggan =='LAMA')?'selected="selected"':''?> value="LAMA">LAMA</option>
                                      </select>
                                    </div>

                                <label class="form-control-label" for="input-name">{{ __('Kategori Pelanggan') }}</label>
                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                     <select name="kategori_pelanggan" id="city" class="custom-select">
                                        <option <?=($data->kategori_pelanggan =='PLN')?'selected="selected"':''?> value="PLN">PLN</option>
                                        <option <?=($data->kategori_pelanggan =='PUBLIK')?'selected="selected"':''?> value="PUBLIK">PUBLIK</option>
                                     </select>
                                    </div>

                                <div class="text-center">
                                     <button type="submit" class="btn btn-success btn-lg"><i class="mdi mdi-content-save"></i> {{ __('Simpan') }}</button>
                                </div>
                            </div>
                        </form>
    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection