<!-- Menu Navigation starts -->
<nav>
    <div class="app-logo">
        <a class="logo d-inline-block" href="{{ route('admin.dashboard') }}">
            <span class="f-s-20">{{ __('general.beauty_salon_system') }}</span>
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
                    {{ __('general.dashboard') }}
                </a>
                <ul class="collapse show" id="dashboard">
                    <li class="{{ request()->routeIs('admin.dashboard') ? 'active' : ''}}"><a href="{{ route('admin.dashboard') }}">{{ __('general.home') }}</a></li>
                    <li class="{{ request()->routeIs('admin.customers.*') ? 'active' : ''}}"><a href="{{ route('admin.customers.index') }}">{{ __('general.customers') }}</a></li>
                    <li class="{{ request()->routeIs('admin.departments.*') ? 'active' : ''}}"><a href="{{ route('admin.departments.index') }}">{{ __('general.departments') }}</a></li>
                    <li class="{{ request()->routeIs('admin.services.*') ? 'active' : ''}}"><a href="{{ route('admin.services.index') }}">{{ __('general.services') }}</a></li>
                    <li class="{{ request()->routeIs('admin.employees.*') ? 'active' : ''}}"><a href="{{ route('admin.employees.index') }}">{{ __('general.employees') }}</a></li>
                    <li class="{{ request()->routeIs('admin.reservations.*') ? 'active' : ''}}"><a href="{{ route('admin.reservations.index') }}">{{ __('general.reservations') }}</a></li>
                    <li class="{{ request()->routeIs('admin.categories.*') ? 'active' : ''}}"><a href="{{ route('admin.categories.index') }}">{{ __('general.categories') }}</a></li>
                    <li class="{{ request()->routeIs('admin.products.*') ? 'active' : ''}}"><a href="{{ route('admin.products.index') }}">{{ __('general.products') }}</a></li>
                    <li class="{{ request()->routeIs('admin.orders.*') ? 'active' : ''}}"><a href="{{ route('admin.orders.index') }}">{{ __('general.orders') }}</a></li>
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
