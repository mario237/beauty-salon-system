<!DOCTYPE html>
<html lang="en">

<head>
    <title>@yield('title') | {{ config('app.name') }}</title>
    <!-- All meta and title start-->
    @include('layouts.head')
    <!-- meta and title end-->

    <!-- css start-->
    @include('layouts.css')
    <!-- css end-->
</head>

<body>
<!-- Loader start-->
<div class="app-wrapper">
    <div class="loader-wrapper">
        <div class="loader_16"></div>
    </div>
    <!-- Loader end-->

    <!-- Menu Navigation start -->
    @include('layouts.sidebar')
    <!-- Menu Navigation end -->


    <div class="app-content">
        <!-- Header Section start -->
        @include('layouts.header')
        <!-- Header Section end -->

        <!-- Main Section start -->
        <main>
            {{-- main body content --}}
            @yield('main-content')
        </main>
        <!-- Main Section end -->
    </div>

    <!-- tap on top -->
    <div class="go-top">
      <span class="progress-value">
        <i class="ti ti-arrow-up"></i>
      </span>
    </div>

    <!-- Footer Section start -->
    @include('layouts.footer')
    <!-- Footer Section end -->
</div>
</body>

<!-- scripts start-->
@include('layouts.script')
<!-- scripts end-->

</html>
