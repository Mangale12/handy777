<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>
    <link name="favicon" type="image/x-icon" href="" rel="shortcut icon" />
    <!-- Bootstrap link Starts -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}.map">
    <!-- Bootstrap link Ends -->
    <!-- Font Awesome Link Starts -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/font-awesome-4.7.0/css/font-awesome.min.css') }}">
    <!-- Font Awesome Link Ends -->
    <!-- Slick Css -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/slick/slick.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/slick/slick-theme.css')}}">
    <!-- Slick Css Ends-->
    <!-- Custom Links -->
    <!-- Font Link -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Orbitron:wght@400;500;600;700&family=Roboto:ital,wght@0,100;0,300;0,400;0,500;1,100;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Red+Hat+Display:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,600&display=swap" rel="stylesheet">
    <!-- Font Link Ends -->
    <link rel="stylesheet" href="https://k1ngzed.com/dist/swiper/swiper.min.css" />
    <link rel="stylesheet" href="https://k1ngzed.com/dist/EasyZoom/easyzoom.css" />
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
        @if($frontsetting->admin_background != null)
        <img src="{{ asset($frontsetting->admin_background) }}" class="img">
        @else
        <img src="{{ asset('admin/assets/images/bg1.jpg') }}" class="img-fluid">
        @endif
    </div>
    <!-- Whole Body Wrapper Starts -->
    <section id="login-page-wrapper">

        <!-- Login Us -->
        <section id="login-register-wrapper" class="p-lg-5 p-md-4 p-3 d-flex justify-content-center align-items-center">
            <div class="container">
                <div class="login-register-form p-xl-5 p-lg-5 p-md-2 p-0">
                    <div class="row position-relative p-lg-3 p-md-3 p-sm-2 p-2">
                        <div class="col-xl-4 col-lg-4 col-md-5  mx-auto form-wrapper">
                            <form class="p-2" method="POST" action="{{ route('login') }}">
                                @csrf
                                <div class="text-center">
                                    <!-- <h1 class="font-weight-bold my-xl-4 my-md-3 my-4">Login</h1> -->
                                    <div class="logo my-xl-4 my-md-3 my-4">
                                        @if($frontsetting->admin_logo != null)
                                        <img src="{{ asset($frontsetting->admin_logo) }}" alt="logo-picture" class="img-fluid">
                                        @else
                                        <img src="{{ asset('admin/assets/images/l.png') }}" alt="logo-picture" class="img-fluid">
                                        @endif
                                    </div>
                                    <div class="form-group position-relative mb-xl-4 mb-md-3 mb-2">
                                        <input type="email" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none bg-transparent" id="email" name="email" placeholder="Email" required>
                                        <i class="fa fa-user-o" aria-hidden="true"></i>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                    @enderror
                                    </div>
                                    <div class="form-group position-relative mb-xl-4 mb-md-3 mb-2">
                                        <input type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0
                                                shadow-none bg-transparent" id="password" name="password" placeholder="Password">
                                        <i class="fa fa-key" aria-hidden="true"></i>
                                        @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                @enderror
                                    </div>
                                    <div class="row mt-2 mb-3">
                                        <div class="col-md-6">
                                            <div class="form-check">
                                                <input class="form-check-input border-0 outline-0" type="checkbox" value="" id="defaultCheck1">
                                                <label class="form-check-label" for="defaultCheck1">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>
                                        <!-- <div class="col-md-6 text-xl-right text-lg-right text-center mt-xl-0 mt-lg-0 mt-2">
                                            <a href="#">Forgot Password?</a>
                                        </div> -->
                                    </div>

                                    <button type="submit" class="btn btn-1 hover-filled-slide-up px-5 py-2 text-uppercase text-white">
                                        <span> Login</span>
                                    </button>

                                    <p class="text-center mt-4">
                                        Don't have an account?
                                        <span>
                                            <!-- <a href="register-login.html">Register</a> -->
                                        </span>

                                    </p>
                                    <div class="row mb-4 px-3 justify-content-center align-items-center">
                                        <h6 class="mb-xl-0 mb-md-2 mb-2 mr-2">Sign in with</h6>
                                        <div class="social-media d-flex justify-content-center h-100">
                                            <div class="facebook text-center mr-2">
                                                <a class="fa fa-facebook" aria-hidden="true"></a>
                                            </div>
                                            <div class="twitter text-center mr-2">
                                                <a class="fa fa-twitter" aria-hidden="true"></a>
                                            </div>
                                            <div class="linkedin text-center mr-2">
                                                <a class="fa fa-linkedin" aria-hidden="true"></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <!-- Login Us Ends -->


    </section>
    <!-- Whole Body Wrapper Ends -->
    <!-- 1st Jquery Link Starts-->
    <script src="{{ asset('public/admin/assets/jquery-3.5.1/jquery-3.5.1.js ') }}"></script>
    <!-- Jquery Link Ends-->
    <!-- 2nd Popper Js Starts -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js " integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN " crossorigin="anonymous "></script>
    <!-- Popper Js Ends -->
    <!-- 3rd Bootstrap Js Link Starts -->
    <script src="{{ asset('admin/assets/bootstrap-4.3.1/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('admin/assets/bootstrap-4.3.1/js/bootstrap.min.js') }}.map "></script>
    <!-- Bootstrap Js Link Ends -->
    <!-- Slick Js -->
    <script src="{{ asset('admin/assets/slick/slick.min.js') }} "></script>
    <!-- Slick Js Ends-->
    <!-- Custom Js Starts -->
    <script src="https://k1ngzed.com/dist/swiper/swiper.min.js "></script>
    <script src="https://k1ngzed.com/dist/EasyZoom/easyzoom.js "></script>
    <script src="{{ asset('public/admin/assets/js/main.js') }} "></script>
    <!-- Custom Js Ends -->


</body>

</html>