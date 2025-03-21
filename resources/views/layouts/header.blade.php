<!-- Header Section starts -->
<header class="header-main">
    <div class="container-fluid">
        <div class="row">
            <div class="col-6 col-sm-4 d-flex align-items-center header-left p-0">
                <span class="header-toggle me-3">
                  <i class="ph ph-circles-four"></i>
                </span>
            </div>

            <div class="col-6 col-sm-8 d-flex align-items-center justify-content-end header-right p-0">

                <ul class="d-flex align-items-center">

                    <li class="header-language">
                        <div id="lang_selector" class="flex-shrink-0 dropdown">
                            <a href="#" class="d-block head-icon ps-0" data-bs-toggle="dropdown" aria-expanded="false">
                                <div class="lang-flag {{ LaravelLocalization::getCurrentLocale() == 'en' ? 'lang-en' : 'lang-ar' }}">
                                    <span class="flag rounded-circle overflow-hidden">
                                        @if(LaravelLocalization::getCurrentLocale() == 'en')
                                            <i class="flag-icon flag-icon-usa flag-icon-squared b-r-10 f-s-22"></i>
                                        @else
                                            <i class="flag-icon flag-icon-egy flag-icon-squared b-r-10 f-s-22"></i>
                                        @endif
                                    </span>
                                </div>
                            </a>
                            <ul class="dropdown-menu language-dropdown header-card border-0">
                                <li class="lang lang-en {{ LaravelLocalization::getCurrentLocale() == 'en' ? 'selected' : '' }} dropdown-item p-2"
                                    data-bs-toggle="tooltip" data-bs-placement="top" title="US">
                                    <a href="{{ LaravelLocalization::getLocalizedURL('en') }}" class="d-flex align-items-center">
                                        <i class="flag-icon flag-icon-usa flag-icon-squared b-r-10 f-s-22"></i>
                                        <span class="ps-2">US</span>
                                    </a>
                                </li>
                                <li class="lang lang-ar {{ LaravelLocalization::getCurrentLocale() == 'ar' ? 'selected' : '' }} dropdown-item p-2"
                                    title="AR" data-bs-toggle="tooltip" data-bs-placement="top">
                                    <a href="{{ LaravelLocalization::getLocalizedURL('ar') }}" class="d-flex align-items-center">
                                        <i class="flag-icon flag-icon-egy flag-icon-squared b-r-10 f-s-22"></i>
                                        <span class="ps-2">Arabic</span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </li>

                    <li class="header-dark">
                        <div class="sun-logo head-icon">
                            <i class="ph ph-moon-stars"></i>
                        </div>
                        <div class="moon-logo head-icon">
                            <i class="ph ph-sun-dim"></i>
                        </div>
                    </li>

                    <li class="header-notification">
                        <a href="#" class="d-block head-icon position-relative" role="button" data-bs-toggle="offcanvas"
                           data-bs-target="#notificationcanvasRight" aria-controls="notificationcanvasRight">
                            <i class="ph ph-bell"></i>
                            <span
                                class="position-absolute translate-middle p-1 bg-success border border-light rounded-circle animate__animated animate__fadeIn animate__infinite animate__slower"></span>
                        </a>
                    </li>

                    <li class="header-profile">
                        <a href="#" class="d-block head-icon" role="button" data-bs-toggle="offcanvas"
                           data-bs-target="#profilecanvasRight" aria-controls="profilecanvasRight">
                            <img src="{{asset('../assets/images/avtar/woman.jpg')}}" alt="avtar"
                                 class="b-r-10 h-35 w-35">
                        </a>

                        <div class="offcanvas offcanvas-end header-profile-canvas" tabindex="-1" id="profilecanvasRight"
                             aria-labelledby="profilecanvasRight" style="height: fit-content !important;">
                            <div class="offcanvas-body app-scroll">
                                <ul class="">
                                    <li>
                                        <div class="d-flex-center">
                                            <span class="h-45 w-45 d-flex-center b-r-10 position-relative">
                                                <img src="{{asset('../assets/images/avtar/woman.jpg')}}" alt=""
                                                     class="img-fluid b-r-10">
                                            </span>
                                        </div>
                                        <div class="text-center mt-2">
                                            <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                                            <p class="f-s-12 mb-0 text-secondary">{{ auth()->user()->email }}</p>
                                        </div>
                                    </li>

                                    <li class="app-divider-v dotted py-1"></li>

                                    <li>
                                        <a class="mb-0 text-danger" href="#"
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                            <i class="ph-duotone ph-sign-out pe-1 f-s-20"></i> {{ __('messages.logout') }}
                                        </a>
                                        <form method="POST" id="logout-form" action="{{ route('admin.logout') }}">
                                            @csrf
                                        </form>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>
</header>
<!-- Header Section ends -->
