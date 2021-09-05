@extends('layout.master')
@section('title', 'Data Sales | Tambah')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data Sales</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="{{ route('sales.add') }}" class="form-horizontal">
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
                                    <label class="form-control-label" for="input-name">{{ __('ID Sales') }}</label>
                                   <input class="form-control" name="id_sales" id="input-id" type="text">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Nama Sales') }}</label>
                                    <input class="form-control" name="nama_sales" id="nama_sales" type="text" placeholder="{{ __('Nama Sales') }}" required="true">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Email') }}</label>
                                    <input class="form-control" name="email" id="email" type="email" placeholder="{{ __('Email') }}" required="true">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('Password') }}</label>
                                    <input class="form-control" name="password" id="password" type="text" minlength="6" placeholder="{{ __('Password') }}" required="true">
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
