@extends('layout.master')
@section('title', 'Data Service | Tambah')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data Service</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/admin/service/store" class="form-horizontal">
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
                                    <label class="form-control-label" for="input-name">{{ __('ID Service') }}</label>
                                    <input type="text" name="id_service" id="input-id" class="form-control "placeholder="{{ __('Segmen Service') }}">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Segmen Service') }}</label>
                                    <input type="text" name="segmen_service" id="segmen_service" class="form-control "placeholder="{{ __('Segmen Service') }}"  required autofocus>
                                </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Jenis Service') }}</label>
                                        <select name="jenis_service" id="city" class="custom-select">
                                            <option>-- Pilih Service --</option>
                                            <option value="Jaringan">Jaringan</option>
                                            <option value="Non Jaringan">Non Jaringan</option>
                                            <option value="Retail">Retail</option>
                                        </select>
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                        <label class="form-control-label" for="input-name">{{ __('Kategori Service') }}</label>
                                        <select name="kategori_service" id="city" class="custom-select">
										    <option>-- Pilih Kategori --</option>
                                            <option value="S1">S1</option>
                                            <option value="S2">S2</option>
                                            <option value="S3">S3</option>
                                            <option value="S4">S4</option>
                                        </select>
                                    </div>

                                <div class="text-center">
                                    <button type="submit" class="btn btn-success btn-lg"><i class="mdi mdi-content-save"></i>{{ __('Simpan') }}</button>
                                </div>

                            </div>
                        </form>

                    </div>
                </div>
            </div>
        </div>
@endsection
