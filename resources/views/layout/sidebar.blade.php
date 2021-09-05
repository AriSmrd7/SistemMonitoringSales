<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ active_class(['admin']) }}">
      <a class="nav-link" href="{{ route('home') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ active_class(['admin/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#admin" aria-expanded="{{ is_active_route(['admin/*']) }}" aria-controls="admin">
        <i class="menu-icon mdi mdi-table-large"></i>
        <span class="menu-title">Master Data</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['admin/*']) }}" id="admin">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['admin/potensi','admin/potensi/create-step-one','admin/potensi/create-step-two','admin/potensi/create-step-three','admin/potensi/create-step-four','admin/potensi/create-step-five']) }}">
            <a class="nav-link" href="{{ route('potensi') }}">Potensi</a>
          </li>
          <li class="nav-item {{ active_class(['admin/sales','admin/sales/add']) }}">
            <a class="nav-link" href="{{ route('sales') }}">Sales</a>
          </li>
          <li class="nav-item {{ active_class(['admin/customer','admin/customer/add']) }}">
            <a class="nav-link" href="{{ route('customer') }}">Customer</a>
          </li>
		  <li class="nav-item {{ active_class(['admin/service','admin/service/add']) }}">
            <a class="nav-link" href="{{ route('service') }}">Service</a>
          </li>		 
		  <li class="nav-item {{ active_class(['admin/office','admin/office/add']) }}">
            <a class="nav-link" href="{{ route('office') }}">Office</a>
          </li>
		  <li class="nav-item {{ active_class(['admin/sbu','admin/sbu/add']) }}">
            <a class="nav-link" href="{{ route('sbu') }}">SBU</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>