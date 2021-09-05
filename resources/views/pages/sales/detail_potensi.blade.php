@extends('layout.master')
@section('title', 'Data Potensi | Detail')
@section('content')

    @foreach($potencies as $data)
        <div class="row">

            <div class="col-xl-8">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0 text-primary">{{ __('Detail Potensi') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <tbody>
                                <tr>
                                    <td>SBU Region</td>
                                    <td>:</td>
                                    <td><strong>{{$data->sbu_region}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Nama Sales</td>
                                    <td>:</td>
                                    <td><strong>{{$data->nama_sales}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Nama Pelanggan</td>
                                    <td>:</td>
                                    <td><strong>{{$data->nama_pelanggan}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Segmen Service</td>
                                    <td>:</td>
                                    <td><strong>{{$data->segmen_service}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Jenis Service</td>
                                    <td>:</td>
                                    <td><strong>{{$data->jenis_service}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Kategori Service</td>
                                    <td>:</td>
                                    <td><strong>{{$data->kategori_service}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Kapasitas </td>
                                    <td>:</td>
                                    <td><strong>{{$data->kapasitas}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Satuan</td>
                                    <td>:</td>
                                    <td><strong>{{$data->satuan_kapasitas}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Action Plan</td>
                                    <td>:</td>
                                    <td><strong>{{$data->update_action_plan}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Kantor</td>
                                    <td>:</td>
                                    <td><strong>{{$data->nama_kantor}}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-4">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0 text-primary">{{ __('Detail Aktivitas') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Target Quote</td>
                                    <td>:</td>
                                    <td><strong>{{$data->target_quote}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Real Quote</td>
                                    <td>:</td>
                                    <td><strong>{{$data->real_quote}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Quote Late</td>
                                    <td>:</td>
                                    <td><strong>{{$data->quote_late}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Target Nego</td>
                                    <td>:</td>
                                    <td><strong>{{$data->target_nego}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Real Nego</td>
                                    <td>:</td>
                                    <td><strong>{{$data->real_nego}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Nego Late</td>
                                    <td>:</td>
                                    <td><strong>{{$data->nego_late}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Target PO</td>
                                    <td>:</td>
                                    <td><strong>{{$data->target_po}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Real PO</td>
                                    <td>:</td>
                                    <td><strong>{{$data->real_po}}</strong></td>
                                </tr>
                                <tr>
                                    <td>PO Late</td>
                                    <td>:</td>
                                    <td><strong>{{$data->po_late}}</strong></td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <div class="row mt-4">

            <div class="col-xl-12">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0 text-primary">{{ __('Detail Revenue') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Target Aktivasi (Bulan Aktivasi)</td>
                                        <td>:</td>
                                        <td><strong>{{$data->target_aktivasi_bln}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Instalasi OTC</td>
                                        <td>:</td>
                                        <td><strong>@rupiah($data->instalasi_otc)</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Sewa (Bulan)</td>
                                        <td>:</td>
                                        <td><strong>@rupiah($data->sewa_bln)</strong></td>
                                    </tr>
                                    <tr>
                                        <td>QTY</td>
                                        <td>:</td>
                                        <td><strong>{{$data->qty}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Revenue Formula</td>
                                        <td>:</td>
                                        <td><strong>@rupiah($data->revenue_formula)</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Warna Status Potensi</td>
                                        <td>:</td>
                                        <td><strong>{{$data->warna_potensi}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Anggaran pra Penjualan</td>
                                        <td>:</td>
                                        <td><strong>Rp. {{$data->anggaran_pra_penjualan}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-4">

            <div class="col-xl-7">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0 text-primary">{{ __('Detail Lokasi') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="table-responsive">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Originating</td>
                                    <td>:</td>
                                    <td><strong>{{$data->originating}}</strong></td>
                                </tr>
                                <tr>
                                    <td>Terminating</td>
                                    <td>:</td>
                                    <td><strong>{{$data->terminating}}</strong></td>
                                </tr>
                                @foreach($datax as $data1)
                                    <tr>
                                        <td>SBU Originating</td>
                                        <td>:</td>
                                        <td><strong>{{$data1->sbu_originating}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>SBU Terminating</td>
                                        <td>:</td>
                                        <td><strong>{{$data1->sbu_terminating}}</strong></td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xl-5">
                <div class="card shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h4 class="col-12 mb-0 text-primary">{{ __('Detail Pelanggan') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        {{ csrf_field() }}
                        <div class="card">
                            <div class="table-responsive">
                                <table class="table">
                                    <tbody>
                                    <tr>
                                        <td>Status Pelanggan</td>
                                        <td>:</td>
                                        <td><strong>{{$data->status_pelanggan}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Segmen Pelanggan</td>
                                        <td>:</td>
                                        <td><strong>{{$data->jenis_pelanggan}}</strong></td>
                                    </tr>
                                    <tr>
                                        <td>Kategori Pelanggan</td>
                                        <td>:</td>
                                        <td><strong>{{$data->kategori_pelanggan}}</strong></td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
@endsection
