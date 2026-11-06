<!DOCTYPE html>
<html lang="en">

<head>
    @php
    $frontsetting = \App\Models\FrontSetting::first();
    @endphp
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link name="favicon" type="image/x-icon" href="{{asset($frontsetting->favicon)}}" rel="shortcut icon" />
    <!-- Bootstrap link Starts -->
    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('public/admin/assets/bootstrap-4.3.1/css/bootstrap.min.css') }}.map">
    <!-- Bootstrap link Ends -->
    <!-- Font Awesome Link Starts -->
    <link rel="stylesheet" href="{{ asset('public/public/admin/assets/font-awesome-4.7.0/css/font-awesome.min.css') }}">
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
    
    <!-- CSS -->


<!-- JS -->
    <!-- Custom Links Ends -->
    {{-- script --}}
    <script src="{{ asset('public/admin/assets/jquery-3.5.1/jquery-3.5.1.js') }}"></script>
    <!-- Jquery Link Ends-->
    <!-- 2nd Popper Js Starts -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js " integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN " crossorigin="anonymous "></script>
    <!-- Popper Js Ends -->
    <!-- 3rd Bootstrap Js Link Starts -->
    <script src="{{ asset('admin/assets/bootstrap-4.3.1/js/bootstrap.min.js') }} "></script>
    <script src="{{ asset('admin/assets/bootstrap-4.3.1/js/bootstrap.min.js') }}.map "></script>
    <!-- Bootstrap Js Link Ends -->
    <!-- Slick Js -->
    <script src="{{ asset('public/admin/assets/slick/slick.min.js') }} "></script>
    <!-- Slick Js Ends-->
    <!-- Custom Js Starts -->
    <script src="https://k1ngzed.com/dist/swiper/swiper.min.js "></script>
    <script src="https://k1ngzed.com/dist/EasyZoom/easyzoom.js "></script>
    <script src="{{ asset('admin/assets/js/main.js') }} "></script>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/css/toastr.css" rel="stylesheet" />
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/2.1.0/js/toastr.js"></script>

    <!-- Custom Js Ends -->
</head>
{{-- <div class="overlay2 position-absolute">
    <img src="{{ asset('admin/assets/images/bg1.jpg') }}" class="img-fluid">
</div> --}}
<!-- Whole Body Wrapper Starts -->
@include('admin.inc.admin-nav')
{{-- <section id="dashboard-wrapper" class="py-4 position-relative">

    <div class="container-fluid">
        <div class="row">
            @include('cashier.inc.cashier-sidenav')
            <div class="col-9">
                @yield('content')
            </div>
        </div>
    </div>
</section> --}}
<section id="dashboard-wrapper" class="py-4 position-relative">

    <div class="container-fluid">
        <div class="row">
            @include('admin.inc.admin-sidenav')
            @yield('content')
            {{-- <div class="col-lg-9 col-md-8 ml-auto">
                <button class="btn-glass text-white px-5 d-md-none d-block w-100 mb-2 border-0" data-toggle="modal" data-target="#leftsidebarfilter"> <span class="mr-2"><i class="fa fa-tachometer"
                            aria-hidden="true"></i></span><span>Dashboard Menu</span>
                </button>
                <div class="sidebar-content p-4">
                    <form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputEmail4">Email</label>
                                <input type="email" class="form-control" id="inputEmail4" placeholder="Email">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="inputPassword4">Password</label>
                                <input type="password" class="form-control" id="inputPassword4" placeholder="Password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label for="inputAddress">Address</label>
                            <input type="text" class="form-control" id="inputAddress" placeholder="1234 Main St">
                        </div>
                        <form>
                            <div class="form-group">
                                <label>Upload Image</label>
                                <input type="file" class="form-control-file p-2" id="exampleFormControlFile1">
                            </div>
                        </form>
                        <div class="form-row">
                            <div class="form-group col-md-6">
                                <label for="inputCity">City</label>
                                <input type="text" class="form-control" id="inputCity">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="inputState">State</label>
                                <select id="inputState" class="form-control">
                                    <option selected>Choose...</option>
                                    <option>...</option>
                                </select>
                            </div>
                            <div class="form-group col-md-2">
                                <label for="inputZip">Zip</label>
                                <input type="text" class="form-control" id="inputZip">
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" id="gridCheck">
                                <label class="form-check-label" for="gridCheck">
                                    Check me out
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-1 hover-filled-slide-up text-white px-5">
                            <span>Sign
                                in</span>
                        </button>
                    </form>
                </div>
            </div> --}}
        </div>
    </div>


</section>


<!-- Whole Body Wrapper Ends -->
<div class="modal fade" id="leftsidebarfilter" tabindex="-1" role="dialog" aria-labelledby="leftsidebarfilterlabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="leftsidebarfilterlabel">Dashboard Menu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                        aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="left-side-wrapper">
                    <div class="sidebar-menu">
                        <ul class="m-0 p-0">
                            <li class="px-3 py-2">

                                <div class="d-flex justify-content-center align-items-center flex-wrap py-lg-4 py-2">
                                    <img src="{{ asset('admin/assets/images/bg1.jpg') }}" class="logo img-fluid">
                                    <div class="info ml-lg-3 ml-0 mt-lg-0 mt-3">
                                        <h6 class="p-0 text-uppercase">Company Name</h6>
                                        <a class="m-0 p-0 text-light">Upload Photo</a>
                                    </div>
                                </div>

                            </li>
                            <li class="px-3 py-2 mx-3 my-2 active">
                                <a href="">
                                    <div class="d-flex"> <span class="mr-4"><i
                                                class="fa fa-dashboard"></i></span>Dashboard
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2 mx-3 my-2">
                                <a href="">
                                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-user"
                                                aria-hidden="true"></i></span>User
                                    </div>
                                </a>
                            </li>

                            <li class="px-3 py-2 mx-3 my-2">
                                <a href="">
                                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-clone"
                                                aria-hidden="true"></i></span>Text
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2 mx-3 my-2">
                                <a href="">
                                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-area-chart"
                                                aria-hidden="true"></i></span>Chart
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2 mx-3 my-2">
                                <a href="">
                                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-cog"
                                                aria-hidden="true"></i></span>Setting
                                    </div>
                                </a>
                            </li>
                            <li class="px-3 py-2 mx-3 my-2">
                                <a href="">
                                    <div class="d-flex"> <span class="mr-4"><i class="fa fa-lock"
                                                aria-hidden="true"></i></span>Log Out
                                    </div>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <!-- <div class="modal-footer">
          </div> -->
        </div>
    </div>
</div>
<body>
</body>
</html>