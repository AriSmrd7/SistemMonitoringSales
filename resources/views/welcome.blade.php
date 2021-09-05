@extends('layout.master-mini')
@section('title', 'Login ICON+')
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
  <div class="row w-100">

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card">
                    <div class="card-body">
						<div class="form-group">
							<div class="text-center"><h2 class="text-primary">{{ __('Selamat Datang') }}</h2></div>
						</div>
						<br>
						<div class="form-group">
							<a href="{{route('admin.login')}}" class="btn btn-block btn-outline-primary btn-rounded btn-lg">Login Admin</a>		
						</div>
						<div class="form-group">
							<a href="{{route('sales.login')}}" class="btn btn-block btn-outline-primary btn-rounded btn-lg">Login Sales</a>		
						</div>
						<br>

                    </div>
                </div>
            </div>
        </div>
    </div>

  </div>
</div>

@endsection