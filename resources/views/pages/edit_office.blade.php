@extends('layout.master')
@section('title', 'Data Offices | Edit')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Edit Data Office</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                         @foreach($kantor as $data)
                        <form method="post" action="/admin/office/update" class="form-horizontal">
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
                                    <label class="form-control-label" for="input-name">{{ __('ID Kantor') }}</label>
                                   <input class="form-control" name="id" id="input-id" type="text" value="{{$data->id_kantor}}"
                      readonly>
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Kantor') }}</label>
                                    <input class="form-control" name="nama_kantor" id="nama_kantor" type="text" placeholder="{{ __('Nama Kantor') }}" value="{{$data->nama_kantor}}">
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
@endsection
