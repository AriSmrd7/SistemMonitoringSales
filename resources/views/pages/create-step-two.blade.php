@extends('layout.master')
@section('title', 'Data Customers | Tambah')
@section('content')
        <div class="row">
            <div class="col">
                <div class="card shadow">
                    <div class="card-header border-0">
                        <div class="row align-items-center">
                            <div class="col">
                                <h4 class="text-primary mb-0">Form Data Potensi</h4>
								<hr>
								<h6 class="text-muted">Step 2</h6>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                       <form action="{{ route('create.step.two.post') }}" method="POST">
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
											<label for="originating">Originating</label>
											<input  class="form-control" name="originating" type="text" value="{{ $potencies->originating ?? '' }}">
									    </div>
										
										<div class="form-group">
											<label for="terminating">Terminating</label>
											<input  class="form-control" name="terminating" type="text" value="{{ $potencies->terminating ?? ''}}">
										</div>
										
										<div class="form-group">
										  <label for="sbu_originating">SBU Originating</label>							  
										  <select name="sbu_originating" class="custom-select">
											<option>-- Pilih SBU --</option>
											@foreach($sbunames as $sbu1)
												<option value="{{$sbu1->sbu_originating}}" {{ $sbu1->sbu_originating === $potencies->sbu_originating? 'selected' : '' }}>{{$sbu1->sbu_originating}}</option>
											@endforeach
										  </select>
									    </div>
										
										<div class="form-group">
										  <label for="sbu_terminating">SBU Terminating</label>							  
										  <select name="sbu_terminating" class="custom-select">
											<option>-- Pilih SBU --</option>
											@foreach($sbunames as $sbu2)
												<option value="{{$sbu2->sbu_terminating}}" {{ $sbu2->sbu_terminating === $potencies->sbu_terminating? 'selected' : '' }}>{{$sbu2->sbu_terminating}}</option>
											@endforeach
										  </select>
									    </div>
										
								<div class="card-body text-right">
									 <div class="row">
										<div class="col-md-6 text-left">
											<a href="{{ route('create.step.one') }}" class="btn btn-lg btn-danger pull-right">Previous</a>
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