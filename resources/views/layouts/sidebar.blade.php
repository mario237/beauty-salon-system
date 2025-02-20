<!-- Menu Navigation starts -->
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('index') }}">
            <img src="{{asset('../assets/images/logo/1.png')}}" alt="#">
        </a>

        <span class="bg-light-primary toggle-semi-nav">
          <i class="ti ti-chevrons-right f-s-20"></i>
        </span>
    </div>
    <div class="app-nav" id="app-simple-bar">
        <ul class="main-nav p-0 mt-2">
            <li class="menu-title">
                <span>Dashboard</span>
            </li>
            <li>
                <a class="" data-bs-toggle="collapse" href="#dashboard" aria-expanded="false">
                    <i class="ph-duotone  ph-house-line"></i>
                    dashboard
                    <span class="badge text-bg-success badge-notification ms-2">4</span>
                </a>
                <ul class="collapse" id="dashboard">
                    <li><a href="{{ route('admin.dashboard') }}">Home</a></li>
                    <li><a href="{{ route('admin.customers.index') }}">Customers</a></li>
                    <li><a href="{{ route('admin.departments.index') }}">Departments</a></li>
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
