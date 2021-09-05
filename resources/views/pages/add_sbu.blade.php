@extends('layout.master')
@section('title', 'Data SBU | Tambah')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data SBU</h4>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <form method="post" action="/admin/sbu/store" class="form-horizontal">
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
                                    <label class="form-control-label" for="input-name">{{ __('ID SBU') }}</label>
                                   <input class="form-control" name="id_sbu" id="input-id" type="text">
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('SBU Region') }}</label>
                                    <input class="form-control" name="sbu_region" id="sbu_region" type="text" placeholder="{{ __('SBU Region') }}" required="true"></input>
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('SBU Originating') }}</label>
                                    <select name="sbu_originating" id="sbu_originating" class="custom-select" placeholder="{{ __('SBU Originating') }}" required>
                                          <option>-- Pilih SBU Originating --</option>
                                          <option value="RO BNR">RO BNR</option>
                                          <option value="RO JBB">RO JBB</option>
                                          <option value="RO JTG">RO JTG</option>
                                          <option value="RO JBT">RO JBT</option>
                                          <option value="RO KLM">RO KLM</option>
                                          <option value="RO SLW">RO SLW</option>
                                          <option value="RO SBS">RO SBS</option>
                                          <option value="RO SBT">RO SBT</option>
                                          <option value="RO SBU">RO SBU</option>
                                          <option value="RO JAKBAN">RO JAKBAN</option>
                                    </select>
                                </div>

                                <div class="form-group{{ $errors->has('name') ? ' has-danger' : '' }}">
                                    <label class="form-control-label" for="input-name">{{ __('SBU Terminating') }}</label>
                                    <select name="sbu_terminating" id="sbu_terminating" class="custom-select" placeholder="{{ __('SBU Terminating') }}" required>
									      <option>-- Pilih SBU Terminating --</option>
                                          <option value="RO BNR">RO BNR</option>
                                          <option value="RO JBB">RO JBB</option>
                                          <option value="RO JTG">RO JTG</option>
                                          <option value="RO JBT">RO JBT</option>
                                          <option value="RO KLM">RO KLM</option>
                                          <option value="RO SLW">RO SLW</option>
                                          <option value="RO SBS">RO SBS</option>
                                          <option value="RO SBT">RO SBT</option>
                                          <option value="RO SBU">RO SBU</option>
                                          <option value="RO JAKBAN">RO JAKBAN</option>
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
