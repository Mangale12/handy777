<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <!-- Bootstrap link Starts -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}.map">
    <!-- Bootstrap link Ends -->
    <!-- Font Awesome Link Starts -->
    <!-- Font Awesome Link Ends -->
    <!-- Slick Css -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/slick/slick-theme.css')}}">
    <!-- Slick Css Ends-->
    <!-- Custom Links -->
    <!-- Font Link -->
    <!-- Font Link Ends -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/css/responsive.css') }}">
    <!-- Custom Links Ends -->
</head>
<style>
    .img
    {
        height: 100%;
/* Center and scale the image nicely */
background-position: center;
background-repeat: no-repeat;
background-size: cover;
    }
</style>
<body>
    
    <div class="overlay position-absolute">
        {{-- @if($active_theme->logo != null)
        <img src="{{ asset('images/'.$settings->theme.'/'.$active_theme->logo) }}" class="img">
        @else
        <img src="{{ asset('admin/assets/images/bg1.jpg') }}" class="img-fluid">
        @endif --}}
    </div>
    <!-- Whole Body Wrapper Starts -->
    @yield('content')
    <!-- Whole Body Wrapper Ends -->
    <!-- 1st Jquery Link Starts-->
    <script src="{{ asset('public/admin/assets/jquery-3.5.1/jquery-3.5.1.js ') }}"></script>
    <!-- Jquery Link Ends-->
    <!-- 2nd Popper Js Starts -->
    <!-- Popper Js Ends -->
    <!-- 3rd Bootstrap Js Link Starts -->
    <!-- Bootstrap Js Link Ends -->
    <!-- Slick Js -->
    <!-- Slick Js Ends-->
    <!-- Custom Js Starts -->
    <script src="{{ asset('public/admin/assets/js/main.js') }} "></script>
    <!-- Custom Js Ends -->


</body>

</html>
