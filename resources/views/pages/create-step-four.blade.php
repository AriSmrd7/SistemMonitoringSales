@extends('layout.master')
@section('title', 'Data Customers | Tambah')
@section('content')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script  type="text/javascript">
$(document).ready(function() {
    $('#warna_potensi').on("change", function(){
    	var warna = $("#warna_potensi option:selected").attr("value");
    	var revenue = $('#revenue').val();

    	if (warna=="HIJAU"){
   		var test = 0.099 * revenue / 100;
		} else {
   		var test = 0 * revenue;
		}

		if(test<100000){
			var anggaran_pra_penjualan = 0;
		} else {
			var anggaran_pra_penjualan = test;
		}

		var b1 = Math.ceil(anggaran_pra_penjualan);

        $("#anggaran_pra_penjualan").val(b1);
    });
});
</script>
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data Potensi</h4>
								<hr>
								<h6 class="text-muted">Step 4</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <form action="{{ route('create.step.four.post') }}" method="POST">
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
											<label for="target_quote">Target Quote</label>
											<input  class="form-control" name="target_quote" type="date" value="{{ $quote }}" readonly>
									    </div>
										
										<div class="form-group">
											<label for="target_nego">Target Nego</label>
											<input  class="form-control" name="target_nego" type="date"  value="{{ $nego }}" readonly>
										</div>
										
										<div class="form-group">								
											<label for="target_po">Target PO</label>
											<input  class="form-control" name="target_po" type="date"  value="{{ $po }}" readonly>
										</div>
										
										<div class="form-group">
										  <label for="warna_potensi">Warna Potensi</label>								  
										  <select name="warna_potensi" class="custom-select" id="warna_potensi">
											<option>-- Pilih Warna --</option>
											<option value="HIJAU" {{{ (isset($potencies->warna_potensi) && $potencies->warna_potensi == 'HIJAU') ? "selected" : "" }}}>HIJAU</option>
											<option value="KUNING" {{{ (isset($potencies->warna_potensi) && $potencies->warna_potensi == 'KUNING') ? "selected" : "" }}} >KUNING</option>
											<option value="MERAH" {{{ (isset($potencies->warna_potensi) && $potencies->warna_potensi == 'MERAH') ? "selected" : "" }}}>MERAH</option>
										  </select>
										</div>
										
										<div class="form-group">
											<label for="anggaran_pra_penjualan">Anggaran Pra Penjualan</label>
											<input  class="form-control" name="anggaran_pra_penjualan" value="{{ $potencies->anggaran_pra_penjualan ?? ''}}" id="anggaran_pra_penjualan" type="number" readonly>
										</div>

										<div class="form-group" hidden>
											<input  class="form-control" name="revenue" id="revenue" type="number" value="{{$potencies->revenue_formula}}" readonly>
										</div>

								<div class="card-body text-right">
									 <div class="row">
										<div class="col-md-6 text-left">
											<a href="{{ route('create.step.three') }}" class="btn btn-lg btn-danger pull-right">Previous</a>
										</div>
										<div class="col-md-6 text-right">
											<button type="submit" class="btn btn-lg btn-primary">Next</button>
										</div>
									</div>
								</div>
						</form>

                    </div>
                </div>
            </div>
        </div>
@endsection