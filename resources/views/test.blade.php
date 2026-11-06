<!DOCTYPE html>
<html lang="en">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="description" content="Noor-games">
    <meta name="author" content="Noor-games">
    <meta name="keywords" content="Noor-games">
    <meta content="" name="Noor-games">
    <meta content="" name="Noor-games">
    <!-- Favicons -->
    <link href="https://handy777.net/images/handy_fav.png" rel="icon">
    <link href="https://handy777.net/images/logochangecolor.gif" rel="apple-touch-icon">
    <!-- Title Page-->
    <title>Ohana-Handy</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Icons font CSS-->
    <!-- Font special for pages-->
    <!-- Vendor CSS-->
    {{-- <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all"> --}}
    {{-- <link href="{{ asset('vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all"> --}}
    <!-- Main CSS-->
    <script src="{{ asset('js/app.js') }}" defer></script>
    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/my.css') }}" rel="stylesheet" media="all">
    <link href="https://unpkg.com/smartwizard@5/dist/css/smart_wizard_all.min.css" rel="stylesheet" type="text/css" />
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" type="text/css" />
    <style>
        @media screen and (max-width: 576px) {
         #myVideo {
         position: fixed;
         right: -8%;
         top: 0;
         height: 100vh;
         }
         .form-image-dragon-mobile{
         position: absolute;
         top: 110px;
         left: 70px;
         }
         .card-mobile{
         height: 800px;
         }
         .new-step-wizard{
         margin-top: 150px;
         }
         .smartwizard{
         left: -30px;
         width: 120%;
         }
         .tab-content{
         padding: 10px 5px 0 10px;
         }
         .rainbow {
         left: -35px;
         width: 280px;
         }
         }
      </style>
    <style>
        * {
         box-sizing: border-box;
         }
         body {
         background-color: #f1f1f1;
         }
         .modal-backdrop-bg {
         background-image: url({{asset('images/bgStars.jpg')}});
         }
         .modal-header{
         border:none;
         }
         .modal-cross{
         font-family: 'neon_planetdisplay', Arial, sans-serif;
         animation: color-change 2s infinite;
         color: #fff;
         letter-spacing: 2px;
         font-size: 65px;
         }
         #regForm {
         /*background-color: #ffffff;*/
         /*margin: 100px auto;*/
         font-family: Raleway;
         padding: 0 40px 0px 40px;
         /*width: 70%;*/
         min-width: 300px;
         }
         h1 {
         text-align: center;  
         }
         /* Mark input boxes that gets an error on validation: */
         input.invalid {
         background-color: #ffdddd;
         }
         /* Hide all steps by default: */
         .tab {
         display: none;
         }
         .tab-pane{
            padding: 20px;
         }
         /*#prevBtn {*/
         /*  background-color: #bbbbbb;*/
         /*}*/
         /* Make circles that indicate the steps of the form: */
         .step {
         height: 15px;
         width: 15px;
         margin: 0 2px;
         background-color: #0b6bf7;
         border: none;  
         border-radius: 50%;
         display: inline-block;
         opacity: 0.5;
         }
         .step.active {
         opacity: 1;
         }
         /* Mark the steps that are finished and valid: */
         .step.finish {
         background-color: #004cbb;
         }
         .modal-header-text{
         font-family: 'neon_planetdisplay', Arial, sans-serif;
         padding: 20px;
         animation: color-change 2s infinite;
         color: #fff;
         letter-spacing: 2px;
         text-decoration: underline;
         }
         .modal-content{
         box-shadow: 0 0 2px #006aff, 0 0 4px #006aff, 0 0 6px #006aff, 0 0 8px #006aff, 0 0 10px #006aff, 0 0 12px #006aff, 0 0 14px #006aff, 0 0 16px #006aff;
         }
         .numberText{
         font-family: "NeonPlanetDisplay;!important";
         font-size: 20px;
         }
         .neon_planetdisplay{
         font-family: 'neon_planetdisplay', Arial, sans-serif;
         }
         .inline-block
         {
         display: inline-block;
         }
         .font-size-20
         {
         font-size: 20px;
         }
         button:focus
         {
         outline: none;
         }
         .overflow-hidden
         {
         overflow: hidden;
         }
         .active-tab
         {
         transform: translateX(0);
         }
         .inactive-tab
         {
         transform: translateX(120%);
         transition: transform ease-out 0.3s;
         }
         .input-form-modal{
         border: 1px solid;
         border-radius: 10px;
         padding: 10px 10px 10px 10px;
         }
         .input--style-1:focus{
         color: #fff;
         }
         .card-1{
         background-color: rgb(0 0 0 / 76%) !important;
         }
         .display-none{
         display:none!important;
         }
         /*.main-header-text{*/
         /*background-color: none!important;*/
         /*}*/
         @keyframes rotate {
         100% {
         transform: rotate(1turn);
         }
         }
         .rainbow {
         position: relative;
         z-index: 0;
         border-radius: 10px;
         overflow: hidden;
         }
         .rainbow::before {
         content: '';
         position: absolute;
         z-index: -2;
         left: -50%;
         top: -50%;
         width: 200%;
         height: 200%;
         /*background-color: #399953;*/
         background-repeat: no-repeat;
         background-size: 50% 50%, 50% 50%;
         background-position: 0 0, 100% 0, 100% 100%, 0 100%;
         background-image: 
         linear-gradient(#f11b7e, #f11b7e), 
         linear-gradient(#0032fb, #0032fb), 
         linear-gradient(#0032fb, #0032fb),
         linear-gradient(#f11b7e, #f11b7e), 
         linear-gradient(#0032fb, #0032fb),
         linear-gradient(#f11b7e, #f11b7e), 
         linear-gradient(#0032fb, #0032fb),
         linear-gradient(#f11b7e, #f11b7e);             
         animation: rotate 4s linear infinite;
         }
         .rainbow::after {
         content: '';
         position: absolute;
         z-index: -1;
         left: 6px;
         top: 6px;
         width: calc(100% - 12px);
         height: calc(100% - 12px);
         border-radius: 5px;
         background:black;
         }
         .select2-results__options{
             background:black;
         }
         .select2-selection__rendered{
                 font-family: 'neon_planetdisplay', Arial, sans-serif;
                color: #fff!important;
    text-shadow: 0 0 2px #dc3545, 0 0 4px #dc3545, 0 0 6px #dc3545, 0 0 8px #dc3545, 0 0 10px #dc3545, 0 0 12px #dc3545, 0 0 14px #dc3545, 0 0 16px #dc3545;
         
             
         }
         .select2-results__options li{
                 font-family: 'neon_planetdisplay', Arial, sans-serif;
                color: #fff;
    text-shadow: 0 0 2px #dc3545, 0 0 4px #dc3545, 0 0 6px #dc3545, 0 0 8px #dc3545, 0 0 10px #dc3545, 0 0 12px #dc3545, 0 0 14px #dc3545, 0 0 16px #dc3545;
         }
        .select2-container{
            width:100%!important;
        }
      </style>
</head>

<body>
    <div class="page-wrapper font-robo">
        <!--<video autoplay muted loop id="myVideo">-->
        <!--    <source src="{{url('images/fin.mp4')}}" type="video/mp4">-->
        <!--    Your browser does not support HTML5 video.-->
        <!--</video>-->
        <img id="myVideo" src="{{ asset('images/ohanabg.gif')}}">
        <div class="page-wrapper font-robo">
            <div class="wrapper wrapper--w680">
                <div class="card card-1 py-5 card-mobile">
                    <div>
                        <div>
                            <h2 class="font-weight-bold text-center main-header-text">
                                Career
                            </h2>
                        </div>
                        <div class="mx-5" style="text-align: center;">
                            <h3 style="line-height:2rem;" class="neon-text font-weight-bold blink">
                                Join Us
                            </h3>
                        </div>
                        <div class="card-body p-5">
                            <div class="text-center logo form-image-dragon-mobile">
                                <img src="{{ asset('/images/handy_logo.png') }}" width="220" height="250" class="w-auto">
                            </div>
                            <!--<h1 style="color:yellow; text-align:center" class="title">Welcome to Noor Games! :-D </br>Fill out the following form to get registered into our room. We will send you the <b>Monthly Match</b> based on the date you joined us as a loyal customer. </br> All the best!!!</h1>-->
                            <form method="post" id="regForm" action="{{ route('forms.saveForm') }}">
                                @csrf
                                
                                @if (session('error'))
                                    @if(is_array(session('error')))
                                        @foreach(session('error') as $error)
                                            <div class = "alert alert-danger alert-dismissible fade show" role = "alert" style=" background: red; color: white; ">
                                                {{ $error }}
                                                <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close">
                                                    <i class = "ik ik-x"></i>
                                                </button>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class = "alert alert-danger alert-dismissible fade show" role = "alert" style=" background: red; color: white; ">
                                            {{ session('error') }}
                                            <button type = "button" class = "close" data-dismiss = "alert" aria-label = "Close">
                                                <i class = "ik ik-x"></i>
                                            </button>
                                        </div>
                                    @endif
                            
                                @endif
                                <div class="rainbow new-step-wizard">
                                    <div id="smartwizard">
                                        <ul class="nav display-none">
                                            <li>
                                                <a class="nav-link" href="#step-1">
                                                    Step 1
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-2">
                                                    Step 2
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-3">
                                                    Step 3
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-4">
                                                    Step 4
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-5">
                                                    Step 5
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-6">
                                                    Step 6
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-7">
                                                    Step 7
                                                </a>
                                            </li>
                                            <li>
                                                <a class="nav-link" href="#step-8">
                                                    Step 8
                                                </a>
                                            </li>
                                        </ul>
                                        <div class="tab-content">
                                            <div class="text-center" style="padding-top: 10px;">
                                                <p class="neon-text-danger display-none error-msg">Please enter your full name</p>
                                                <p class="neon-text-danger display-none error-msg-num">Please enter your phone number</p>
                                            </div>
                                            <div id="step-1" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planetdisplay inline-block">
                                                   Your Full Name
                                                </p>
                                                </br></br>
                                                <div class="form-check">
                                                <input name="name" class="input-form-modal form-control form-control-lg input--style-1 transparent-input neon-text-danger input-name" type="text" value="{{old('name')}}" autocomplete="off" placeholder="Full Name" maxlength="30" required>
                                                <button style="margin-top: 10px;" type="button" class="button px-4 next-btn"><span class="neon-text">Next</span></button>
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            
                                            <div id="step-2" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planet display inline-block">
                                                    Is your cash-app sending limit more than
                                                </p>
                                                 <p class="numberText neon-text inline-block font-size-20">$7500</p>
                                                 <p class="neon-text neon_planet display inline-block">
                                                   per week?
                                                </p>
                                                </br></br>
                                                <div class="form-check">
                                                    <input type="hidden" name="cash_app_send_limit" class="cash_app_send_limit" required>
                                                    <button type="button" class="btn btn-success neon-text next-btn yes-btn" data-input=".cash_app_send_limit">Yes</button>
                                                    <button class="btn btn-danger neon-text neon-text-danger no-btn next-btn" data-input=".cash_app_send_limit">No</button>
                                                    <!-- <input class="form-check-input next-btn" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label neon-text" for="exampleRadios1">
                                                        Yes
                                                    </label> -->
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            <div id="step-3" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planetdisplay inline-block">
                                                    Are you US citizen?
                                                </p>
                                                </br></br>
                                                <div class="form-check">
                                                    <input type="hidden" name="us_citizen" class="us_citizen" required>
                                                    <button type="button" class="btn btn-success neon-text next-btn yes-btn" data-input=".us_citizen">Yes</button>
                                                    <button class="btn btn-danger neon-text neon-text-danger no-btn next-btn" data-input=".us_citizen">No</button>
                                                    <!-- <input class="form-check-input next-btn" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label neon-text" for="exampleRadios1">
                                                        Yes
                                                    </label> -->
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            
                                            <div id="step-4" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planetdisplay inline-block">
                                                   State
                                                </p>
                                                </br></br>
                                                <!-- custom-select-neon -->
                                                <div class="form-check">
                                                    
                                                    <!-- <input type="hidden" class="selected-state" name="state"> -->
                                                    <select class="w-100 neon-text neon_planetdisplay" id="state" name="state" required>
                                                        <option class="neon-text neon_planetdisplay" value="" selected="selected">Select a State</option>
                                                        <option class="neon-text neon_planetdisplay" value="Alabama">Alabama</option>
                                                        <option class="neon-text neon_planetdisplay" value="Alaska">Alaska</option>
                                                        <option class="neon-text neon_planetdisplay" value="Arizona">Arizona</option>
                                                        <option class="neon-text neon_planetdisplay" value="Arkansas">Arkansas</option>
                                                        <option class="neon-text neon_planetdisplay" value="California">California</option>
                                                        <option class="neon-text neon_planetdisplay" value="Colorado">Colorado</option>
                                                        <option class="neon-text neon_planetdisplay" value="Connecticut">Connecticut</option>
                                                        <option class="neon-text neon_planetdisplay" value="Delaware">Delaware</option>
                                                        <option class="neon-text neon_planetdisplay" value="District Of Columbia">District Of Columbia</option>
                                                        <option class="neon-text neon_planetdisplay" value="Florida">Florida</option>
                                                        <option class="neon-text neon_planetdisplay" value="Georgia">Georgia</option>
                                                        <option class="neon-text neon_planetdisplay" value="Hawaii">Hawaii</option>
                                                        <option class="neon-text neon_planetdisplay" value="Idaho">Idaho</option>
                                                        <option class="neon-text neon_planetdisplay" value="Illinois">Illinois</option>
                                                        <option class="neon-text neon_planetdisplay" value="Indiana">Indiana</option>
                                                        <option class="neon-text neon_planetdisplay" value="Iowa">Iowa</option>
                                                        <option class="neon-text neon_planetdisplay" value="Kansas">Kansas</option>
                                                        <option class="neon-text neon_planetdisplay" value="Kentucky">Kentucky</option>
                                                        <option class="neon-text neon_planetdisplay" value="Louisiana">Louisiana</option>
                                                        <option class="neon-text neon_planetdisplay" value="Maine">Maine</option>
                                                        <option class="neon-text neon_planetdisplay" value="Maryland">Maryland</option>
                                                        <option class="neon-text neon_planetdisplay" value="Massachusetts">Massachusetts</option>
                                                        <option class="neon-text neon_planetdisplay" value="Michigan">Michigan</option>
                                                        <option class="neon-text neon_planetdisplay" value="Minnesota">Minnesota</option>
                                                        <option class="neon-text neon_planetdisplay" value="Mississippi">Mississippi</option>
                                                        <option class="neon-text neon_planetdisplay" value="Missouri">Missouri</option>
                                                        <option class="neon-text neon_planetdisplay" value="Montana">Montana</option>
                                                        <option class="neon-text neon_planetdisplay" value="Nebraska">Nebraska</option>
                                                        <option class="neon-text neon_planetdisplay" value="Nevada">Nevada</option>
                                                        <option class="neon-text neon_planetdisplay" value="New Hampshire">New Hampshire</option>
                                                        <option class="neon-text neon_planetdisplay" value="New Jersey">New Jersey</option>
                                                        <option class="neon-text neon_planetdisplay" value="New Mexico">New Mexico</option>
                                                        <option class="neon-text neon_planetdisplay" value="New York">New York</option>
                                                        <option class="neon-text neon_planetdisplay" value="North Carolina">North Carolina</option>
                                                        <option class="neon-text neon_planetdisplay" value="North Dakota">North Dakota</option>
                                                        <option class="neon-text neon_planetdisplay" value="Ohio">Ohio</option>
                                                        <option class="neon-text neon_planetdisplay" value="Oklahoma">Oklahoma</option>
                                                        <option class="neon-text neon_planetdisplay" value="Oregon">Oregon</option>
                                                        <option class="neon-text neon_planetdisplay" value="Pennsylvania">Pennsylvania</option>
                                                        <option class="neon-text neon_planetdisplay" value="Rhode Island">Rhode Island</option>
                                                        <option class="neon-text neon_planetdisplay" value="South Carolina">South Carolina</option>
                                                        <option class="neon-text neon_planetdisplay" value="South Dakota">South Dakota</option>
                                                        <option class="neon-text neon_planetdisplay" value="Tennessee">Tennessee</option>
                                                        <option class="neon-text neon_planetdisplay" value="Texas">Texas</option>
                                                        <option class="neon-text neon_planetdisplay" value="Utah">Utah</option>
                                                        <option class="neon-text neon_planetdisplay" value="Vermont">Vermont</option>
                                                        <option class="neon-text neon_planetdisplay" value="Virginia">Virginia</option>
                                                        <option class="neon-text neon_planetdisplay" value="Washington">Washington</option>
                                                        <option class="neon-text neon_planetdisplay" value="West Virginia">West Virginia</option>
                                                        <option class="neon-text neon_planetdisplay" value="Wisconsin">Wisconsin</option>
                                                        <option class="neon-text neon_planetdisplay" value="Wyoming">Wyoming</option>
                                                    </select>
                                                <!-- <input class="input-form-modal form-control form-control-lg input--style-1 transparent-input neon-text-danger input-name" type="text" value="{{old('state')}}" name="state" id="state" autocomplete="off" placeholder="Your State" maxlength="30" required> -->
                                                <!-- <button style="margin-top: 10px;" type="button" class="button px-4 next-btn"><span class="neon-text">Next</span></button> -->
                                                
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            <div id="step-5" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planetdisplay inline-block">
                                                    Do you have valid state Id or Driving License?
                                                </p>
                                                </br></br>
                                                <div class="form-check">
                                                    <input type="hidden" name="driving_license" class="driving_license" required>
                                                    <button class="btn btn-success neon-text next-btn yes-btn" data-input=".driving_license">Yes</button>
                                                    <button class="btn btn-danger neon-text neon-text-danger no-btn next-btn" data-input=".driving_license">No</button>
                                                   <!--  <input class="form-check-input next-btn" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label neon-text" for="exampleRadios1">
                                                        Yes
                                                    </label> -->
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            <div id="step-6" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planetdisplay inline-block">IS your credit score above</p>
                                                <p class="numberText neon-text inline-block font-size-20">650?</p>
                                                </br></br>
                                                <div class="form-check">
                                                    <input type="hidden" name="extra_1" class="extra_1" required>
                                                    <button class="btn btn-success neon-text next-btn yes-btn" data-input=".extra_1">Yes</button>
                                                    <button class="btn btn-danger neon-text neon-text-danger no-btn next-btn" data-input=".extra_1">No</button>

                                                    <!-- <input class="form-check-input next-btn" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label neon-text" for="exampleRadios1">
                                                        Yes
                                                    </label> -->
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            <div id="step-7" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="neon-text neon_planetdisplay inline-block">Have you ever been charged with a felony or crime in the last five years?</p>
                                                </br></br>
                                                <div class="form-check">
                                                    <input type="hidden" name="crime" class="crime" required >
                                                    <button class="btn btn-success neon-text next-btn yes-btn" data-input=".crime">Yes</button>
                                                    <button class="btn btn-danger neon-text neon-text-danger no-btn next-btn" data-input=".crime">No</button>

                                                    <!-- <input class="form-check-input next-btn" type="radio" name="exampleRadios" id="exampleRadios1" value="option1" checked>
                                                    <label class="form-check-label neon-text" for="exampleRadios1">
                                                        Yes
                                                    </label> -->
                                                </div>
                                                </br>
                                                <!-- <div class="form-check">
                                                    <input class="form-check-input back-btn" type="radio" name="exampleRadios" id="exampleRadios2" value="option2">
                                                    <label class="form-check-label neon-text neon-text-danger" for="exampleRadios2">
                                                        No
                                                    </label>
                                                </div> -->
                                            </div>
                                            <div id="step-8" class="tab-pane" role="tabpanel" style="text-align: center;">
                                                <p class="numberText neon-text neon_planetdisplay inline-block input-name-text">
                                                    Perfect what could be the best phone number to reach out to you?
                                                </p>
                                                </br></br>
                                                <input id="phone-number" class="input-form-modal form-control form-control-lg input--style-1 transparent-input neon-text-danger" type="tel" value="" autocomplete="off" placeholder="XXX-XXX-XXXX" name="phone_number" maxlength="10" required>
                                                <button style="margin-top: 10px;margin-left: 40px;" type="submit" class="button px-4 submit-btn"><span class="neon-text">Submit</span></button>
                                                <!-- <input class="form-control form-control-lg neon-text-danger" type="tel" value="{{old('phone_number')}}" autocomplete="off" placeholder="Mobile No." name="phone_number" maxlength="20" required> -->
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            </br>
                            <div class="to-push to-push2">
                                <div class="text-center pt-3">
                                    <h4 style="line-height: 30px;"><b><span class="neon-text font-weight-bold">Copyright Handy Games</span> <span class="just-neon">© 2023</span> <span class="neon-text"> All Rights Reserved</span><b></h4>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Jquery JS-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>
    <!-- Main JS-->
    <script src="js/global.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
    <script src="https://unpkg.com/smartwizard@5/dist/js/jquery.smartWizard.min.js" type="text/javascript"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js" type="text/javascript"></script>
    <script src="js/jquery-input-mask-phone-number.min.js"></script>
    
    <!-- steps -->
    <script>
    $(document).ready(function() {
        // SmartWizard initialize
        $('#smartwizard').smartWizard({
            transition: {
                animation: 'slide-swing', // Effect on navigation, none/fade/slide-horizontal/slide-vertical/slide-swing
                speed: '400', // Transion animation speed
                easing: '' // Transition animation easing. Not supported without a jQuery easing plugin
            },
            disabledSteps: [], // Array Steps disabled
            backButtonSupport: false,
            toolbarSettings: {
                toolbarPosition: 'bottom', // none, top, bottom, both
                toolbarButtonPosition: 'right', // left, right, center
                showNextButton: false, // show/hide a Next button
                showPreviousButton: false, // show/hide a Previous button
                toolbarExtraButtons: [] // Extra buttons to show on toolbar, array of jQuery input/buttons elements
            }
        });
        $('.input-name').keyup(function(){
            // if($('.error-msg').hasClass('display-none')){
                $('.error-msg').addClass('display-none');
            // }
        });
        $(".next-btn").click(function() {
            var inputName = $('.input-name').val()
            if(inputName.length <= 0){
                $('.error-msg').removeClass('display-none');
            }else{
                $('.error-msg').addClass('display-none');
                $('#smartwizard').smartWizard("next"); 
                $('.input-name-text').html('Perfect '+$('.input-name').val()+' what could be the best phone number to reach out to you?');
            }
            
        });
        $(".yes-btn").click(function() { 
            var inputClass = $(this).data('input');
            if(inputClass != 'input'){
                $(inputClass).val('yes');
            }
            
        });
        $(".no-btn").click(function() { 
            var inputClass = $(this).data('input');
            if(inputClass != 'input'){
                $(inputClass).val('no');
            }
            
        });
        
        $(".back-btn").click(function() { $('#smartwizard').smartWizard("prev"); });
        // $("#state").change(function() { $('#smartwizard').smartWizard("next"); });
         function denyBtn() {
        $('.tab-content').html('<p style="font-size: 25px;">Thanks for considering to work with us.</p>');
    }
        

    });
    </script>
    <!-- state -->
    <script>
        $('#state').change(function(){
            $('#smartwizard').smartWizard("next"); 
        });
        
           




        var x, i, j, l, ll, selElmnt, a, b, c;
        /* Look for any elements with the class "custom-select-neon": */
        x = document.getElementsByClassName("custom-select-neon");
        l = x.length;
        for (i = 0; i < l; i++) {
          selElmnt = x[i].getElementsByTagName("select")[0];
          ll = selElmnt.length;
          /* For each element, create a new DIV that will act as the selected item: */
          a = document.createElement("DIV");
          a.setAttribute("class", "select-selected");
          a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
          x[i].appendChild(a);
          /* For each element, create a new DIV that will contain the option list: */
          b = document.createElement("DIV");
          b.setAttribute("class", "select-items select-hide");
          for (j = 1; j < ll; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                $('.selected-state').val(this.innerHTML);
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                sl = s.length;
                h = this.parentNode.previousSibling;
                for (i = 0; i < sl; i++) {
                  if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    h.innerHTML = this.innerHTML;
                    y = this.parentNode.getElementsByClassName("same-as-selected");
                    yl = y.length;
                    for (k = 0; k < yl; k++) {
                      y[k].removeAttribute("class");
                    }
                    this.setAttribute("class", "same-as-selected");
                    break;
                  }
                }
                h.click();
            });
            b.appendChild(c);
          }
          x[i].appendChild(b);
        //   <button style="margin-top: 10px;" type="button" class="button px-4 next-btn"><span class="neon-text">Next</span></button>
        // x[i].appendChild('appendasdfasdfasdfasdf');
          a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
          });
        }
        
        function closeAllSelect(elmnt) {
          /* A function that will close all select boxes in the document,
          except the current select box: */
          var x, y, i, xl, yl, arrNo = [];
          x = document.getElementsByClassName("select-items");
          y = document.getElementsByClassName("select-selected");
          xl = x.length;
          yl = y.length;
          for (i = 0; i < yl; i++) {
            if (elmnt == y[i]) {
              arrNo.push(i)
            } else {
              y[i].classList.remove("select-arrow-active");
            }
          }
          for (i = 0; i < xl; i++) {
            if (arrNo.indexOf(i)) {
              x[i].classList.add("select-hide");
            }
          }
        }
        
        /* If the user clicks anywhere outside the select box,
        then close all select boxes: */
        document.addEventListener("click", closeAllSelect);
    </script>
    <!-- phone -->
    <script>
        $(function(){
            $('#phone-number').usPhoneFormat({
                format:'xxx-xxx-xxxx'
            });
        });
    </script>
    <!-- form submit validation -->
    <script>
        $('.submit-btn').click(function(e){
            e.stopImmediatePropagation();
            var form = $('#regForm');
            var inputName = $('.input-name').val()
            if(inputName.length <= 0){
                $('.error-msg').removeClass('display-none');
            }
            else{
                if($('#phone-number').val() == ''){
                    $('.error-msg-num').removeClass('display-none');
                }else{
                    console.log($('#phone-number').length);
                    form.submit();
                }
            }

        });
        $('#state').select2();
    </script>
</body>

</html>
<!-- dy> -->

</html>