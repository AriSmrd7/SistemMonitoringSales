@extends('layout.master')
@section('title', 'Data Service | Edit')
@section('content')

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Edit Data Service</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        @foreach($service as $data)
                        <form method="post" action="/admin/service/update" class="form-horizontal">
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
                                    <input class="form-control" name="id" id="input-id" type="text" value="{{$data->id_service}}">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Segmen Service') }}</label>
                                    <input class="form-control" name="segmen_service" id="segmen_service" type="text" placeholder="{{ __('Segmen Service') }}" value="{{$data->segmen_service}}">
                                </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Jenis Service') }}</label>
                                     <select name="jenis_service" id="city" class="custom-select">
                                        <option <?=($data->jenis_service =='Jaringan')?'selected="selected"':''?> value="Jaringan">Jaringan</option>
                                        <option <?=($data->jenis_service =='Non jaringan')?'selected="selected"':''?> value="Non jaringan">Non Jaringan</option>
                                        <option <?=($data->jenis_service =='Retail')?'selected="selected"':''?> value="Retail">Retail</option>
                                     </select>
                                    </div>

                                    <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Kategori Service') }}</label>
                                     <select name="kategori_service" id="city" class="custom-select">
                                        <option <?=($data->kategori_service =='S1')?'selected="selected"':''?> value="S1">S1</option>
                                        <option <?=($data->kategori_service =='S2')?'selected="selected"':''?> value="S2">S2</option>
                                        <option <?=($data->kategori_service =='S3')?'selected="selected"':''?> value="S3">S3</option>
                                        <option <?=($data->kategori_service =='S4')?'selected="selected"':''?> value="S4">S4</option>
                                     </select>
                                    </div>

                                <div class="text-center">
                                     <button type="submit" class="btn btn-success btn-lg"><i class="mdi mdi-content-save"></i>{{ __('Simpan') }}</button>
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