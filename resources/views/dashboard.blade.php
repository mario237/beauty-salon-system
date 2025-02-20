@extends('layouts.master')
@section('title', 'Dashboard')
@section('css')

    <!-- apexcharts css -->
    <link rel="stylesheet" type="text/css" href="{{ asset('assets/vendor/apexcharts/apexcharts.css') }}">

    <!-- slick css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick.css')}}">
    <link rel="stylesheet" href="{{asset('assets/vendor/slick/slick-theme.css')}}">

    <!-- glight css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/glightbox/glightbox.min.css')}}">

    <!-- Data Table css -->
    <link rel="stylesheet" type="text/css" href="{{asset('assets/vendor/datatable/jquery.dataTables.min.css')}}">

    <!-- vector map css -->
    <link rel="stylesheet" href="{{asset('assets/vendor/vector-map/jquery-jvectormap.css')}}">

@endsection
@section('main-content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <div class="card eshop-cards">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-primary h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-map-pin-line"></i>
                          </span>
                            <div class="dropdown">
                                <a href="#" class="text-primary" role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    Last Month<i class="ti ti-chevron-down ms-1"></i>
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Last Month</a></li>
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                    <li><a class="dropdown-item" href="#">Last Year</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-shrink-0 align-self-end">
                                <p class="f-s-16 mb-0">Visits</p>
                                <h5>25,220k <span class="f-s-12 text-danger">-45%</span></h5>
                            </div>
                            <div class="visits-chart">
                                <div id="visitsChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card eshop-cards">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-secondary h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-shopping-cart"></i>
                          </span>
                            <div class="dropdown">
                                <a href="#" class="text-secondary " role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    Weekly<i class="ti ti-chevron-down ms-1"></i>
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Monthly</a></li>
                                    <li><a class="dropdown-item" href="#">Weekly</a></li>
                                    <li><a class="dropdown-item" href="#">Yearly</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center position-relative">
                            <div class="flex-shrink-0 align-self-end">
                                <p class="f-s-16 mb-0">Order</p>
                                <h5>45,782k <span class="f-s-12 text-success">+65%</span></h5>
                            </div>
                            <div class="order-chart">
                                <div id="orderChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card eshop-cards">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-success h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-bold  ph-pulse"></i>
                          </span>
                            <div class="dropdown">
                                <a href="#" class="text-success " role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    Today<i class="ti ti-chevron-down ms-1"></i>
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">Today</a></li>
                                    <li><a class="dropdown-item" href="#">Tomorrow</a></li>
                                    <li><a class="dropdown-item" href="#">Last Week</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-shrink-0 align-self-end">
                                <p class="f-s-16 mb-0">Activity</p>
                                <h5>45k</h5>
                            </div>
                            <div class="activity-chart">
                                <div id="activityChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="card eshop-cards">
                    <div class="card-body">
                        <div class="d-flex justify-content-between align-items-center">
                          <span class="bg-warning h-40 w-40 d-flex-center b-r-15 f-s-18">
                            <i class="ph-fill  ph-coins"></i>
                          </span>
                            <div class="dropdown">
                                <a href="#" class="text-warning " role="button" data-bs-toggle="dropdown"
                                   aria-expanded="false">
                                    February<i class="ti ti-chevron-down ms-1"></i>
                                </a>
                                <ul class="dropdown-menu  dropdown-menu-end">
                                    <li><a class="dropdown-item" href="#">January</a></li>
                                    <li><a class="dropdown-item" href="#">February</a></li>
                                    <li><a class="dropdown-item" href="#">March</a></li>
                                    <li><a class="dropdown-item" href="#">April</a></li>
                                    <li><a class="dropdown-item" href="#">...</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="flex-shrink-0 align-self-end">
                                <p class="f-s-16 mb-0">Sales</p>
                                <h5>$63,987<span class="f-s-12 text-success">+68%</span></h5>
                            </div>
                            <div class="sales-chart">
                                <div id="salesChart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('script')

    <!-- slick-file -->
    <script src="{{asset('assets/vendor/slick/slick.min.js')}}"></script>

    <!-- vector map plugin js -->
    <script src="{{asset('assets/vendor/vector-map/jquery-jvectormap-2.0.5.min.js')}}"></script>
    <script src="{{asset('assets/vendor/vector-map/jquery-jvectormap-world-mill.js')}}"></script>

    <!--cleave js  -->
    <script src="{{asset('assets/vendor/cleavejs/cleave.min.js')}}"></script>

    <!-- Glight js -->
    <script src="{{asset('assets/vendor/glightbox/glightbox.min.js')}}"></script>

    <!-- data table-->
    <script src="{{asset('assets/vendor/datatable/jquery.dataTables.min.js')}}"></script>

    <!-- apexcharts js-->
    <script src="{{asset('assets/vendor/apexcharts/apexcharts.min.js')}}"></script>

    <!-- Ecommerce js-->
    <script src="{{asset('assets/js/ecommerce_dashboard.js')}}"></script>

@endsection
