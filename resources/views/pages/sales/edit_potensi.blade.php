@extends('layout.master')
@section('title', 'Data Potensi | Update')
@push('plugin-styles')
     <link href="{{ asset('assets') }}/plugins/dragula/dragula.min.css" rel="stylesheet">
@endpush

@section('content')

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js" type="text/javascript"></script>
<script  type="text/javascript">
$(document).ready(function() {
    $('#real_quote').change(function(){
        var target_quote = Date.parse($('#target_quote').val()) / 1000;
        var real_quote = Date.parse($('#real_quote').val()) / 1000;
	    var quote_late = real_quote - target_quote;

		if (quote_late > 0){
   		$( "#quote_late option:selected" ).text("LATE").val("LATE");
		} else {
   		$( "#quote_late option:selected" ).text("NO").val("NO");
		}
    });

    $('#real_nego').change(function(){
	    var target_nego = Date.parse($('#target_nego').val()) / 1000;
        var real_nego = Date.parse($('#real_nego').val()) / 1000;
	    var nego_late = real_nego - target_nego;

		if (nego_late > 0){
   		$( "#nego_late option:selected" ).text("LATE").val("LATE");
		} else {
   		$( "#nego_late option:selected" ).text("NO").val("NO");
		}
    });

    $('#real_po').change(function(){
	    var target_po = Date.parse($('#target_po').val()) / 1000;
        var real_po = Date.parse($('#real_po').val()) / 1000;
	    var po_late = real_po - target_po;

		if (po_late > 0){
   		$( "#po_late option:selected" ).text("LATE").val("LATE");
		} else {
   		$( "#po_late option:selected" ).text("NO").val("NO");
		}
    });
});
</script>

    <div class="container-fluid mt--7">
        <div class="row">
            <div class="col">
                <div class="card bg-secondary shadow">
                    <div class="card-header bg-white border-0">
                        <div class="row align-items-center">
                            <h3 class="col-12 mb-0">{{ __('Update Potensi') }}</h3>
                        </div>
                    </div>
                    <div class="card-body">
                       <form action="{{ route('sales.potensi_edit') }}" method="post">
							@csrf
							<div class="card">
								<div class="card-body">
										@if ($errors->any())
											<div class="alert alert-danger">
												<ul>
													@foreach ($errors->all() as $error)
														<li>{{ $error }}</li>
													@endforeach
												</ul>
											</div>
										@endif
										@foreach($potencies as $data)
										<div class="form-group">
											<label for="target_quote"></label>
											<input class="form-control" name="id" id="id" type="text" value="{{$data->id_potensi}}" hidden>
									    </div>
									    <div class="form-group">
											<label for="target_quote">Target Quote</label>
											<input  class="form-control" name="target_quote" id="target_quote" type="date" value="{{$data->target_quote}}" readonly>
									    </div>
									    <div class="form-group">
											<label for="real_quote">Real Quote</label>
											<input  class="form-control" name="real_quote" id="real_quote" type="date" value="{{$data->real_quote}}">
									    </div>
									    <div class="form-group">
											<label for="quote_late">Quote Late</label>
											<select name="quote_late" class="custom-select" id="quote_late">
											<option value="NO">NO</option>
											<option value="LATE">LATE</option>
										    </select>
									    </div>
									    <div class="form-group">
											<label for="target_nego">Target Nego</label>
											<input  class="form-control" name="target_nego" id="target_nego" type="date" value="{{$data->target_nego}}" readonly>
									    </div>
									    <div class="form-group">
											<label for="real_nego">Real Nego</label>
											<input  class="form-control" name="real_nego" id="real_nego" type="date" value="{{$data->real_nego}}">
									    </div>
									    <div class="form-group">
											<label for="nego_late">Nego Late</label>
											<select name="nego_late" id="nego_late" class="custom-select">
											<option value="NO">NO</option>
											<option value="LATE">LATE</option>
										    </select>
									    </div>
									    <div class="form-group">
											<label for="target_po">Target PO</label>
											<input  class="form-control" name="target_po" id="target_po" type="date" value="{{$data->target_po}}" readonly>
									    </div>
									    <div class="form-group">
											<label for="real_po">Real PO</label>
											<input  class="form-control" name="real_po" id="real_po" type="date" value="{{$data->real_po}}">
									    </div>
									    <div class="form-group">
											<label for="po_late">PO Late</label>
											<select name="po_late" id="po_late" class="custom-select">
											<option value="NO">NO</option>
											<option value="LATE">LATE</option>
										    </select>
									    </div>
										
										<div class="form-group">
										  <label for="update_action_plan">Action Plan</label>	  
										  <select name="update_action_plan" class="custom-select">
											<option <?=($data->update_action_plan =='PENAWARAN')?'selected="selected"':''?> value="PENAWARAN">PENAWARAN</option>
											<option <?=($data->update_action_plan =='NEGOSIASI')?'selected="selected"':''?> value="NEGOSIASI">NEGOSIASI</option>
											<option <?=($data->update_action_plan =='CLOSING')?'selected="selected"':''?> value="CLOSING">CLOSING</option>
											<option <?=($data->update_action_plan =='LOSS')?'selected="selected"':''?> value="LOSS">LOSS</option>
											<option <?=($data->update_action_plan =='AKTIVASI')?'selected="selected"':''?> value="AKTIVASI">AKTIVASI</option>
										  </select>
										</div>

										@endforeach
								</div>
								<div class="card-footer text-right">
									 <div class="row">
										<div class="col-md-6 text-right">
											<button type="submit" class="btn btn-primary">Submit</button>
										</div>
									</div>
								</div>
							</div>
						</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('plugin-scripts')
   <script src="{{ asset('assets') }}/plugins/dragula/dragula.min.js"></script>
@endpush

@push('custom-scripts')
  <script src="{{ asset('assets') }}/js/dragula.js"></script>
@endpush