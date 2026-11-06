@extends('admin/login')
@section('content')
<section id="login-page-wrapper">

    <!-- Login Us -->
    <section id="login-register-wrapper" class="p-lg-5 p-md-4 p-3 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="login-register-form p-xl-5 p-lg-5 p-md-2 p-0">
                <div class="row position-relative p-lg-3 p-md-3 p-sm-2 p-2">
                    <div class="col-xl-4 col-lg-4 col-md-5  mx-auto form-wrapper">
                        
                        <form class="p-2" method="POST" action="{{ route('admin.login') }}">
                            @if ($errors->any())
                            <div class="alert alert-danger">
                                {{ $errors->first() }}
                            </div>
                        @endif
                            @csrf
                            <div class="text-center">
                                <!-- <h1 class="font-weight-bold my-xl-4 my-md-3 my-4">Login</h1> -->
                                <div class="logo my-xl-4 my-md-3 my-4">
                                   
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
                                    <a href="{{ route('admin.login.change_password') }}">Forgot Password?</a>

                                    <span>
                                        <!-- <a href="register-login.html">Register</a> -->
                                    </span>

                                </p>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Us Ends -->


</section>
@endsection
