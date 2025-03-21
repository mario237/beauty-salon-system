<!-- Menu Navigation starts -->
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('admin.dashboard') }}">
          <span class="f-s-20"> Beauty Salon System</span>
        </a>

        <span class="bg-light-primary toggle-semi-nav">
          <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-4">
            <li>
                <a class="" data-bs-toggle="collapse" href="#dashboard" aria-expanded="true">
                    <i class="ph-duotone  ph-house-line"></i>
                    dashboard
                </a>
                <ul class="collapse show" id="dashboard">
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : ''}}"><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li class="{{ request()->routeIs('admin.customers.*') ? 'active' : ''}}"><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                    <li class="{{ request()->routeIs('admin.departments.*') ? 'active' : ''}}"><a href="{{ route('admin.departments.index') }}">Departments</a></li>
                    <li class="{{ request()->routeIs('admin.services.*') ? 'active' : ''}}"><a href="{{ route('admin.services.index') }}">Services</a></li>
                    <li class="{{ request()->routeIs('admin.employees.*') ? 'active' : ''}}"><a href="{{ route('admin.employees.index') }}">Employees</a></li>
                    <li class="{{ request()->routeIs('admin.reservations.*') ? 'active' : ''}}"><a href="{{ route('admin.reservations.index') }}">Reservations</a></li>
                    <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : ''}}"><a href="{{ route('admin.categories.index') }}">Categories</a></li>
                    <li class="{{ request()->routeIs('admin.products.*') ? 'active' : ''}}"><a href="{{ route('admin.products.index') }}">Products</a></li>
                    <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : ''}}"><a href="{{ route('admin.orders.index') }}">Order</a></li>
                </ul>
            </li>
        </ul>
    </div>

    <div class="menu-navs">
        <span class="menu-previous"><i class="ti ti-chevron-left"></i></span>
        <span class="menu-next"><i class="ti ti-chevron-right"></i></span>
    </div>

</nav>
<!-- Menu Navigation ends -->
