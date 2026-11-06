@extends('admin.login')
@section('content')
<section id="login-page-wrapper">
    @php
    $settings = App\Models\GeneralSetting::first();
    $active_theme = App\Models\Theme::where('name',$settings->theme)->first();
@endphp
    <!-- Login Us -->
    <section id="login-register-wrapper" class="p-lg-5 p-md-4 p-3 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="login-register-form p-xl-5 p-lg-5 p-md-2 p-0">
                <div class="row position-relative p-lg-3 p-md-3 p-sm-2 p-2">
                    <div class="col-xl-12 col-lg-12 col-md-12  mx-auto form-wrapper mt-4">
                        <form class="p-2" method="POST" action="{{ route('admin.login.new_password_store') }}">
                            @csrf
                            <div class="text-center">
                                <!-- <h1 class="font-weight-bold my-xl-4 my-md-3 my-4">Login</h1> -->
                                {{-- <div class="logo my-xl-4 my-md-3 my-4">
                                    @if($active_theme->logo != null)
                                    <img src="{{ asset('images/'.$settings->theme.'/'.$active_theme->logo) }}" alt="logo-picture" class="img-fluid">
                                    @else
                                    <img src="{{ asset('admin/assets/images/l.png') }}" alt="logo-picture" class="img-fluid">
                                    @endif
                                </div> --}}
                                <div class="form-group position-relative mb-xl-4 mb-md-3 mt-5 mb-4">
                                    <input type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none bg-transparent" id="email" name="password" placeholder="New Password" >
                                    <i class="fa fa-user-o" aria-hidden="true"></i>
                                    @if($errors->has('password'))
                                        <div class="text-danger">{{ $errors->first('password') }}</div>
                                    @endif

                                </div>
                                <div class="form-group position-relative mb-xl-4 mb-md-3 mt-5 mb-4">
                                    <input type="password" class="form-control border-top-0 border-right-0 border-left-0 rounded-0 shadow-none bg-transparent" id="email" name="confirm_password" placeholder="Re-Enter Password" >
                                    <i class="fa fa-user-o" aria-hidden="true"></i>
                                    @if($errors->has('confirm_password'))
                                        <div class="text-danger">{{ $errors->first('confirm_password') }}</div>
                                    @endif

                                </div>
                                <button type="submit" class="btn btn-1 hover-filled-slide-up px-5 py-2 text-uppercase text-white mb-5">
                                    <span> Submit</span>
                                </button>
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
