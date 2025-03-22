@section('title', __('general.sign_in'))
@include('layout.head')

@include('layout.css')

<body class="sign-in-bg">
<div class="app-wrapper d-block">
    <div class="main-container">
        <!-- Body main section starts -->
        <div class="container">
            <div class="row sign-in-content-bg">
                <div class="col-lg-6 image-contentbox d-none d-lg-block">
                    <div class="form-container ">
                        <div class="signup-content mt-4">
                <span>
                  <img src="{{asset('../assets/images/logo/1.png')}}" alt="" class="img-fluid ">
                </span>
                        </div>

                        <div class="signup-bg-img">
                            <img src="{{asset('../assets/images/login/04.png')}}" alt="" class="img-fluid">
                        </div>
                    </div>

                </div>
                <div class="col-lg-6 form-contentbox">
                    <div class="form-container">
                        <form class="app-form" action="{{ route('admin.do-login') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-12">
                                    <div class="mb-5 text-center text-lg-start">
                                        <h2 class="text-primary f-w-600">{{ __('general.welcome_to_ra_admin') }}</h2>
                                        <p>{{ __('general.sign_in_with_data') }}</p>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="email" class="form-label">{{ __('general.email') }}</label>
                                        <input name="email" type="email" class="form-control" placeholder="{{ __('general.enter_your_email') }}" id="email">
                                        @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <label for="password" class="form-label">{{ __('general.password') }}</label>
                                        <a href="{{route('password_reset')}}" class="link-primary float-end">{{ __('general.forgot_password') }}</a>
                                        <input name="password" type="password" class="form-control" placeholder="{{ __('general.enter_your_password') }}" id="password">
                                        @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="mb-3">
                                        <button type="submit" role="button" class="btn btn-primary w-100">{{ __('general.sign_in_button') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <!-- Body main section ends -->
    </div>
</div>


</body>
@section('script')
    <!-- Bootstrap js-->
    <script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>
@endsection
