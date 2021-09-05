@extends('layout.master')
@section('title', 'Data Potensi | Tambah')
@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script  type="text/javascript">
$(document).ready(function() {

    $('#target_aktivasi_bln').keyup(function(ev){
        var target_bln = 13 - $('#target_aktivasi_bln').val();
        var sewa = target_bln * $('#sewa_bln').val();
        var qty = sewa * $('#qty').val();
       	var n1 = parseInt($('#instalasi_otc').val());
	    var n2 = qty;
	    var revenue_formula = n1 + n2;
        $("#revenue_formula").val(revenue_formula);
    });

    $('#instalasi_otc').keyup(function(ev){
        var target_bln = 13 - $('#target_aktivasi_bln').val();
        var sewa = target_bln * $('#sewa_bln').val();
        var qty = sewa * $('#qty').val();
       	var n1 = parseInt($('#instalasi_otc').val());
	    var n2 = qty;
	    var revenue_formula = n1 + n2;
        $("#revenue_formula").val(revenue_formula);
    });

    $('#sewa').keyup(function(ev){
        var target_bln = 13 - $('#target_aktivasi_bln').val();
        var sewa = target_bln * $('#sewa_bln').val();
        var qty = sewa * $('#qty').val();
       	var n1 = parseInt($('#instalasi_otc').val());
	    var n2 = qty;
	    var revenue_formula = n1 + n2;
        $("#revenue_formula").val(revenue_formula);
    });

    $('#qty').keyup(function(ev){
        var target_bln = 13 - $('#target_aktivasi_bln').val();
        var sewa = target_bln * $('#sewa_bln').val();
        var qty = sewa * $('#qty').val();
       	var n1 = parseInt($('#instalasi_otc').val());
	    var n2 = qty;
	    var revenue_formula = n1 + n2;
        $("#revenue_formula").val(revenue_formula);
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
								<h6 class="text-muted">Step 3</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <form action="{{ route('sales.create.step.three.post') }}" method="POST">
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
											<label for="instalasi_otc">Instalasi OTC</label>
											<input  class="form-control" name="instalasi_otc" id="instalasi_otc" onkeypress="return hanyaAngka(event)" type="text" value="{{ $potencies->instalasi_otc ?? ''}}">
									    </div>
										
										<div class="form-group">
											<label for="sewa_bln">Sewa</label>
											<input  class="form-control" name="sewa_bln" id="sewa_bln" onkeypress="return hanyaAngka(event)" type="text" value="{{ $potencies->sewa_bln ?? ''}}">
										</div>
										
										<div class="form-group">								
											<label for="qty">QTY</label>
											<input  class="form-control" name="qty" id="qty" onkeypress="return hanyaAngka(event)" type="text" maxlength="6" value="{{ $potencies->qty ?? ''}}">
										</div>
										
										<div class="form-group">
											<label for="target_aktivasi_bln">Target Aktivasi</label>
											<input  class="form-control" name="target_aktivasi_bln" onkeypress="return hanyaAngka(event)" maxlength="2" id="target_aktivasi_bln" type="text" value="{{ $potencies->target_aktivasi_bln ?? ''}}">
										</div>
										
										<div class="form-group">
											<label for="revenue_formula">Revenue Formula</label>
											<input class="form-control" value="{{ $potencies->revenue_formula ?? ''}}" type="number" name="revenue_formula" id="revenue_formula" readonly></input>
										</div>
								<div class="card-body text-right">
									 <div class="row">
										<div class="col-md-6 text-left">
											<a href="{{ route('sales.create.step.two') }}"  class="btn btn-lg btn-danger pull-right">Previous</a>
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
