<nav class="navbar default-layout col-lg-12 col-12 p-0 fixed-top d-flex flex-row">
  <div class="text-center navbar-brand-wrapper d-flex align-items-top justify-content-center">
    <a class="navbar-brand brand-logo" href="{{ url('/') }}">
      <img src="{{ url('assets/images/icon.png') }}" alt="logo" /> </a>
    <a class="navbar-brand brand-logo-mini" href="{{ url('/') }}">
      <img src="{{ url('assets/images/iconplus-mini.png') }}" width="100%" alt="logo" /> </a>
  </div>
  <div class="navbar-menu-wrapper d-flex align-items-center justify-content-end">
    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
      <span class="mdi mdi-menu"></span>
    </button>
    <ul class="navbar-nav navbar-nav-left header-links">
      <li class="nav-item dropdown d-none d-lg-flex">
        <a class="nav-link dropdown-toggle px-0 ml-3" id="quickDropdown" href="#" data-toggle="dropdown" aria-expanded="false">  <i class="mdi mdi-flash"></i>Akses Cepat </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown pt-3" aria-labelledby="quickDropdown">
		@auth("admin")
          <a href="{{ route('create.step.one') }}" class="dropdown-item"><i class="mdi mdi-plus"></i>Tambah Potensi</a>
          <a href="{{ route('admin.customer_add') }}" class="dropdown-item"><i class="mdi mdi-plus"></i>Tambah Customer</a>
		@endauth
		@auth("sales")
          <a href="{{ route('sales.create.step.one') }}" class="dropdown-item"><i class="mdi mdi-plus"></i>Tambah Potensi</a>
          <a href="{{ route('sales.customer_tambah') }}" class="dropdown-item"><i class="mdi mdi-plus"></i>Tambah Customer</a>
		@endauth
        </div>
      </li>
    </ul>
    <ul class="navbar-nav navbar-nav-right">
      <li class="nav-item dropdown">
        <a class="nav-link count-indicator dropdown-toggle" id="notificationDropdown" href="#" data-toggle="dropdown">
          <i class="mdi mdi-bell-outline"></i>
          <span class="count bg-danger">4</span>
        </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list pb-0" aria-labelledby="notificationDropdown">
          <a class="dropdown-item py-3 border-bottom">
            <p class="mb-0 font-weight-medium float-left">4 new notifications </p>
            <span class="badge badge-pill badge-primary float-right">View all</span>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-alert m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal text-dark mb-1">Application Error</h6>
              <p class="font-weight-light small-text mb-0"> Just now </p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-settings m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal text-dark mb-1">Settings</h6>
              <p class="font-weight-light small-text mb-0"> Private message </p>
            </div>
          </a>
          <a class="dropdown-item preview-item py-3">
            <div class="preview-thumbnail">
              <i class="mdi mdi-airballoon m-auto text-primary"></i>
            </div>
            <div class="preview-item-content">
              <h6 class="preview-subject font-weight-normal text-dark mb-1">New user registration</h6>
              <p class="font-weight-light small-text mb-0"> 2 days ago </p>
            </div>
          </a>
        </div>
      </li>
      <li class="nav-item dropdown d-none d-xl-inline-block">
        <a class="nav-link dropdown-toggle" id="UserDropdown" href="#" data-toggle="dropdown" aria-expanded="false">
		@auth("admin")
          <span class="profile-text d-none d-md-inline-flex">{{ auth()->user()->name }}</span>
		@endauth
		@auth("sales")
          <span class="profile-text d-none d-md-inline-flex">{{ Auth::guard('sales')->user()->nama_sales }}</span>
		@endauth
          <img class="img-xs rounded-circle" src="{{ url('assets/images/faces/face8.jpg') }}" alt="Profile image"> </a>
        <div class="dropdown-menu dropdown-menu-right navbar-dropdown" aria-labelledby="UserDropdown">
          <a class="dropdown-item mt-2">{{ __('Kelola Akun') }}</a>
            @auth("admin")
             <a href="{{ route('AdminChangePassword') }}" class="dropdown-item"> {{ __('Ubah Password') }} </a>
            @endauth
            @auth("sales")
             <a href="{{ route('SalesChangePassword') }}" class="dropdown-item"> {{ __('Ubah Password') }} </a>
            @endauth
          <a class="dropdown-item" href="{{ url('/logout') }}"> {{ __('Logout') }} </a>
          </a>
        </div>
      </li>
    </ul>
    <button class="navbar-toggler navbar-toggler-right d-lg-none align-self-center" type="button" data-toggle="offcanvas">
      <span class="mdi mdi-menu icon-menu"></span>
    </button>
  </div>
</nav>
