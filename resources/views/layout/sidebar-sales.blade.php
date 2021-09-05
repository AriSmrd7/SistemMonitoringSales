<nav class="sidebar sidebar-offcanvas dynamic-active-class-disabled" id="sidebar">
  <ul class="nav">
    <li class="nav-item {{ active_class(['sales']) }}">
      <a class="nav-link" href="{{ route('sales.home') }}">
        <i class="menu-icon mdi mdi-television"></i>
        <span class="menu-title">Dashboard</span>
      </a>
    </li>
    <li class="nav-item {{ active_class(['sales/*']) }}">
      <a class="nav-link" data-toggle="collapse" href="#sales" aria-expanded="{{ is_active_route(['sales/*']) }}" aria-controls="sales">
        <i class="menu-icon mdi mdi-table-large"></i>
        <span class="menu-title">Master Data</span>
        <i class="menu-arrow"></i>
      </a>
      <div class="collapse {{ show_class(['sales/*']) }}" id="sales">
        <ul class="nav flex-column sub-menu">
          <li class="nav-item {{ active_class(['sales/potensi']) }}">
            <a class="nav-link" href="{{ route('sales.potensi') }}">Potensi</a>
          </li>
          <li class="nav-item {{ active_class(['sales/customer','sales/customer/add']) }}">
            <a class="nav-link" href="{{ route('sales.customer') }}">Customer</a>
          </li>
        </ul>
      </div>
    </li>
  </ul>
</nav>