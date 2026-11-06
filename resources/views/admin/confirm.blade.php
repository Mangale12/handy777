@extends('admin.login')
@section('content')
<style>
.main-verification-input {
    background: #fff;
    padding: 0 120px 0 0;
    border-radius: 1px;
    margin-top: 6px;
}

.fl-wrap {
    float: left;
    width: 100%;
    position: relative;
        border-radius: 4px;
}

.main-verification-input:before {
    content: '';
    position: absolute;
    bottom: -40px;
    width: 50px;
    height: 1px;
    background: rgba(255, 255, 255, 0.41);
    left: 50%;
    margin-left: -25px
}

.main-verification-input-item {
    float: left;
    width: 100%;
    box-sizing: border-box;
    border-right: 1px solid #eee;
    height: 50px;
    position: relative
}

.main-verification-input-item input:first-child {
    border-radius: 100%
}

.main-verification-input-item input {
    float: left;
    border: none;
    width: 100%;
    height: 50px;
    padding-left: 20px
}

.main-verification-button {
    background: #4DB7FE
}

.main-verification-button {
    position: absolute;
    right: 0px;
    height: 50px;
    width: 120px;
    color: #fff;
    top: 0;
    border: none;
        border-top-right-radius: 4px;
    border-bottom-right-radius: 4px;
    cursor: pointer
}

.main-verification-input-wrap {
    max-width: 500px;
    margin: 20px auto;
    position: relative;
        margin-top: 129px;
}

.main-verification-input-wrap ul{

           background-color: #fff;
    padding: 27px;
    color: #757575;
    border-radius: 4px;
}

a{
    text-decoration: none !important;
    color: #9C27B0;
}

:focus {
    outline: 0
}

@media only screen and (max-width: 768px) {
    .main-verification-input {
        background: rgba(255, 255, 255, 0.2);
        padding: 14px 20px 10px;
        border-radius: 10px;
        box-shadow: 0px 0px 0px 10px rgba(255, 255, 255, 0.0)
    }

    .main-verification-input-item {
        width: 100%;
        border: 1px solid #eee;
        height: 50px;
        border: none;
        margin-bottom: 10px
    }

    .main-verification-input-item input {
        border-radius: 6px !important;
        background: #fff
    }

    .main-verification-button {
        position: relative;
        float: left;
        width: 100%;
        border-radius: 6px;
        margin-bottom: 2rem;
    }
}
</style>
<section id="login-page-wrapper">
    @php
    $settings = App\Models\GeneralSetting::first();
    $active_theme = App\Models\Theme::where('name',$settings->theme)->first();
@endphp
    <!-- Login Us -->
    <section id="login-register-wrapper" class="p-lg-5 p-md-4 p-3 d-flex justify-content-center align-items-center">
        <div class="container">
            <div class="login-register-form p-xl-5 p-lg-5 p-md-2 p-0">
                <div class="position-relative p-lg-3 p-md-3 p-sm-2 p-2">
                    <div class=" mx-auto form-wrapper mt-4">
                        <div class="p-2">
                            <div class="row">
                                <div class="col-md-12">

                                   <div class="main-verification-input-wrap">
                                     <ul>
                                    <li>You will recieve a verification code on your mail after you registered. Enter that code below.</li>
                                    <li>If somehow, you did not recieve the verification email then <a href="{{ route('login.email_verification') }}" style="color:blue;">resend the verification email</a></li>
                                  </ul>
                                  <form action="{{ route('admin.login.confirm_otp.check') }}" method="POST">
                                    @csrf
                                    <div class="main-verification-input fl-wrap mb-5">
                                       <div class="main-verification-input-item">
                                            <input type="text" value="" placeholder="Enter the verification code" name="confirm_otp">
                                            @if(session('message'))
                                                <div class="text-danger warning">{{ session('message') }}</div>
                                            @endif
                                        </div>
                                        <button class="main-verification-button" type="submit">Verify Now</button>
                                    </div>
                                </form>
                                   </div>
                                </div>
                              </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Login Us Ends -->


</section>
@endsection
