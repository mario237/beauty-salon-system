<!-- latest jquery-->
<script src="{{asset('assets/js/jquery-3.6.3.min.js')}}"></script>

<!-- Bootstrap js-->
<script src="{{asset('assets/vendor/bootstrap/bootstrap.bundle.min.js')}}"></script>

<!-- Simple bar js-->
<script src="{{asset('assets/vendor/simplebar/simplebar.js')}}"></script>

<!-- phosphor js -->
<script src="{{asset('assets/vendor/phosphor/phosphor.js')}}"></script>



<!-- prism js-->
<script src="{{asset('assets/vendor/prism/prism.min.js')}}"></script>

<!-- App js-->
<script src="{{asset('assets/js/script.js')}}"></script>

<script>
    $(window).on("load", function () {
        setTimeout(function (){
            $('.overlay').hide();
        },1000);
    });
</script>

@stack('script')
