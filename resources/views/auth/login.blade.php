@extends('layout.master-mini')
@section('title', 'Login ICON+'.' | '.ucwords($url))
@section('content')

<div class="content-wrapper d-flex align-items-center justify-content-center auth theme-one" style="background-image: url({{ url('assets/images/auth/login_1.jpg') }}); background-size: cover;">
  <div class="row w-100">

    <div class="container mt--8 pb-5">
        <div class="row justify-content-center">
            <div class="col-lg-5 col-md-7">
                <div class="card shadow border-0">
                    <div class="card-body px-lg-8 py-lg-8">
                        <div class="card-header bg-white"><h3 class="text-primary"> {{ __('Login') }} {{ isset($url) ? ucwords($url) : ""}} </h3></div>
                        @isset($url)
                            <form method="POST" action='{{ url("login/$url") }}' aria-label="{{ __('Login') }}">
                                @else
                                    <form method="POST" action="{{ route('login') }}" aria-label="{{ __('Login') }}">
                                        @endisset
                                        @csrf
                                        @foreach ($errors->all() as $error)
                                            <div class="alert alert-danger alert-block">
                                                <button type="button" class="close" data-dismiss="alert">×</button>
                                                <strong>{{ $error }}</strong>
                                            </div>
                                        @endforeach
                            <div class="form-group{{ $errors->has('email') ? ' has-danger' : '' }} mb-3">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                                    </div>
                                    <input class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="{{ __('Email') }}" type="email" name="email" value="{{ old('email') }}" value="admin@argon.com" required autofocus>
                                </div>
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="form-group{{ $errors->has('password') ? ' has-danger' : '' }}">
                                <div class="input-group input-group-alternative">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                                    </div>
                                    <input class="form-control {{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" placeholder="{{ __('Password') }}" type="password" required>
                                </div>
                                @if ($errors->has('password'))
                                    <span class="invalid-feedback" style="display: block;" role="alert">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </span>
                                @endif
                            </div>
                            <div class="custom-control custom-control-alternative custom-checkbox">
                                <input class="custom-control-input" name="remember" id="customCheckLogin" type="checkbox" {{ old('remember') ? 'checked' : '' }}>
                                <label class="custom-control-label" for="customCheckLogin">
                                    <span class="text-muted">{{ __('Remember me') }}</span>
                                </label>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-primary btn-lg my-4">{{ __('Sign in') }}</button>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row mt-3">
                    <div class="col-6">
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-light">
                                <small>{{ __('Forgot password?') }}</small>
                            </a>
                        @endif
                    </div>
                    <div class="col-6 text-right">
                        <a href="{{ route('register') }}" class="text-light">
                            <small>{{ __('Create new account') }}</small>
                        </a>
                    </div>
                </div>

                <div class="row col-lg-12">
                <div class="card-body bg-white">
                    <div class="text-center text-danger"><h5>Informasi Login Admin dan Sales</h5></div>
                    <table class="table table-responsive table-condensed table-hover">
                      <tr>
                        <td colspan="3" class="text-primary"><b>Admin</b></td>
                      </tr>
                      <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td class="text-success">admin@admin.com</td>
                      </tr>
                      <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td class="text-success">tester123</td>
                      </tr>
                      <tr>
                        <td colspan="3" class="text-primary"><b>Sales</b></td>
                      </tr>
                      <tr>
                        <td>Username</td>
                        <td>:</td>
                        <td class="text-success">ari.sales@sales.com</td>
                      </tr>
                      <tr>
                        <td>Password</td>
                        <td>:</td>
                        <td class="text-success">tester123</td>
                      </tr>
                    </table>
                </div>
                </div>

            </div>
        </div>
    </div>

  </div>
</div>

@endsection
