@extends('frontend.cloud.main')
@section('content')
<div class="page-wrapper font-robo">
    {{-- <video autoplay muted loop id="myVideo">
    <source src="{{url('images/fin.mp4')}}" type="video/mp4">
    Your browser does not support HTML5 video.
    </video> --}}
    <div class="page-wrapper font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1 py-5">
                <!--<div class="card-heading">-->

                <!--</div>-->
                <div>
                    <style>
                       @import url('https://fonts.cdnfonts.com/css/bring-race');
                        @import url('https://fonts.cdnfonts.com/css/games');
                        .new-text{
                        font-family: 'Games', sans-serif !important;
                         }

                        @media screen and (max-width: 600px) {
                            .new-text{
                                
                            }
                          #cloud1, #cloud2 {
                            display: none;
                          }
                        }
                        </style>
                    <h2 class="font-weight-bold text-center main-header-text new-text" >
                        WELCOME TO THE AB Gaming
                    </h2>
                </div>
                <div class="mt-5 mx-5 text-center">
                    <h3 style="line-height:2rem;">
                        <span class="neon-text font-weight-bold blink new-text" >Unlock exclusive benefits by registering today. Don't wait, seize the opportunity now.</span>.
                    </h3>
                    <h4 class="mt-4">
                        <span class="font-weight-bold neon-text neon-text-danger blink-danger new-text">You are only a few steps away</span>.
                    </h4>
                    <h3 class="mt-4">
                        <span class="font-weight-bold neon-text blink new-text" >Be the owner of your luck</span>.
                    </h3>

                </div>
                {{-- <div class = "text-center logo">
                      <img src="{{ URL::to('/images/welcome_logo.gif') }}" width="220" height="250" class="w-auto">
                </div> --}}

                <div class="card-body p-5">
                    <!--<h1 style="color:yellow; text-align:center" class="title">Welcome to Noor Games! :-D </br>Fill out the following form to get registered into our room. We will send you the <b>Monthly Match</b> based on the date you joined us as a loyal customer. </br> All the best!!!</h1>-->


                        @if ($errors->any())
                        <div class="alert alert-danger neon-text-danger mt-3">
                            <ul>
                                @foreach ($errors->all() as $error)

                                    <h3><li>{{ $error }}</li></h3>
                                @endforeach
                            </ul>
                        </div>
                        </br>
                        @endif

                    <form id="regForm" action="{{ route('forms.stores') }}" method="POST" >
                        @csrf
                        <div class="row row-space">
                            <div class="col-md-6 col-sm-12 mt-6">
                                <div class="input-group">
                                    <div class = "text-center">
                                        <h4><b><span class="neon-text new-text">Full Name</span>*</b></h4>
                                    </div>
                                    <input class="input--style-1 transparent-input neon-text-danger new-text" type="text" value="{{old('full_name')}}" autocomplete="off" placeholder="Eve Adam" name="full_name" maxlength="20" required>
                                </div>
                            </div>

                            <div class="col-md-6 col-sm-12 mt-6">
                                <div class="input-group">
                                     <div>
                                   <h4><b><span class="neon-text new-text">Phone Number</span>*</b></h4></div>
                                    <input class="input--style-1 transparent-input neon-text-danger phone-text new-text" type="tel" value="{{old('number')}}" autocomplete="off" placeholder="XXX XXX XXXX" name="number" maxlength="10" required>
                                </div>
                                <span class="phone-text-display new-text">The number must be 10 characters.</span>
                            </div>


                            <div class="col-md-6 col-sm-12 mt-6 text-left mt-4">
                                <div class="input-group">
                                     <div>
                                   <h4><b><span class="neon-text new-text">State</span>*</b></h4>
                                </div>
                                <div class="custom-select-neon my-2 w-100 new-text">
                                    <select class="w-100" name="mail" id="state" required>
                                          <option value="" selected="selected">Select a State</option>
                                          <option value="AL">Alabama</option>
                                          <option value="AK">Alaska</option>
                                          <option value="AZ">Arizona</option>
                                          <option value="AR">Arkansas</option>
                                          <option value="CA">California</option>
                                          <option value="CO">Colorado</option>
                                          <option value="CT">Connecticut</option>
                                          <option value="DE">Delaware</option>
                                          <option value="DC">District Of Columbia</option>
                                          <option value="FL">Florida</option>
                                          <option value="GA">Georgia</option>
                                          <option value="HI">Hawaii</option>
                                          <option value="ID">Idaho</option>
                                          <option value="IL">Illinois</option>
                                          <option value="IN">Indiana</option>
                                          <option value="IA">Iowa</option>
                                          <option value="KS">Kansas</option>
                                          <option value="KY">Kentucky</option>
                                          <option value="LA">Louisiana</option>
                                          <option value="ME">Maine</option>
                                          <option value="MD">Maryland</option>
                                          <option value="MA">Massachusetts</option>
                                          <option value="MI">Michigan</option>
                                          <option value="MN">Minnesota</option>
                                          <option value="MS">Mississippi</option>
                                          <option value="MO">Missouri</option>
                                          <option value="MT">Montana</option>
                                          <option value="NE">Nebraska</option>
                                          <option value="NV">Nevada</option>
                                          <option value="NH">New Hampshire</option>
                                          <option value="NJ">New Jersey</option>
                                          <option value="NM">New Mexico</option>
                                          <option value="NY">New York</option>
                                          <option value="NC">North Carolina</option>
                                          <option value="ND">North Dakota</option>
                                          <option value="OH">Ohio</option>
                                          <option value="OK">Oklahoma</option>
                                          <option value="OR">Oregon</option>
                                          <option value="PA">Pennsylvania</option>
                                          <option value="RI">Rhode Island</option>
                                          <option value="SC">South Carolina</option>
                                          <option value="SD">South Dakota</option>
                                          <option value="TN">Tennessee</option>
                                          <option value="TX">Texas</option>
                                          <option value="UT">Utah</option>
                                          <option value="VT">Vermont</option>
                                          <option value="VA">Virginia</option>
                                          <option value="WA">Washington</option>
                                          <option value="WV">West Virginia</option>
                                          <option value="WI">Wisconsin</option>
                                          <option value="WY">Wyoming</option>
                                    </select>
                                    <!--<input class="input--style-1 transparent-input neon-text-danger" type="text" value="{{old('mail')}}" autocomplete="off" placeholder="Alaska" name="mail" maxlength="30" required>-->
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-12 mt-4">
                                <div class="input-group">
                                    <div class = "text-center">
                                        <h4><b><span class="neon-text new-text">Referred By (If Applies)</span></b></h4>
                                    </div>
                                    <input class="input--style-1 transparent-input neon-text-danger new-text" type="text" value="{{old('r_id')}}" autocomplete="off" placeholder="S_XXxXX" name="r_id" maxlength="15" >
                                </div>
                            </div>


                            <div class="col-md-6 col-sm-12 mt-4">
                                <div class="input-group">
                                     <div>
                                   <h4><b><span class="neon-text new-text">Email <span style="color:red">*</span></span></b></h4>
                                </div>
                                    <input required class="input--style-1 transparent-input neon-text-danger new-text" type="email" value="{{old('email')}}" autocomplete="off" placeholder="name@xyz.com" name="email">
                                </div>
                            </div>

                             <div class="col-md-6 col-sm-12 mt-4">
                              <div class="input-group">
                                 <div class = "text-center">
                                    <h4><b><span class="neon-text new-text">Facebook Name</span></b></h4>
                                 </div>
                                 <input class="input--style-1 transparent-input neon-text-danger new-text" type="text" value="{{old('facebook_name')}}" autocomplete="off" placeholder="Your Facebook Name" name="facebook_name" maxlength="20" required>
                              </div>
                           </div>
                             <div class="col-md-6 col-sm-12 mt-4 text-left">
                                <div class="input-group">
                                    <div>
                                        <h4><b><span class="neon-text new-text">Game</span>*</b></h4>
                                   </div>
                                <style>
                                    .account-choose .select-items{
                                        position: absolute;
                                        background-color: #000000e8;
                                    }
                                    .account-select{
                                        font-size: 1.3rem!important;
                                        color: #b4cfb8ad!important;
                                        /*text-shadow:*/
                                        /*            0 0 2px #e4e0e0,*/
                                        /*            0 0 4px #31cc4b,*/
                                        /*            0 0 6px #361ebf,*/
                                        /*            0 0 8px rgb(22, 20, 20),*/
                                        /*            0 0 10px #584547,*/
                                        /*            0 0 12px #139b55,*/
                                        /*            0 0 14px #0c8716,*/
                                        /*            0 0 16px #0f8b51;*/
                                        /* text-shadow: 0 0 2px #b7e0ed, 0 0 4px #b7e0ed, 0 0 6px #b7e0ed, 0 0 8px #b7e0ed, 0 0 10px #b7e0ed, 0 0 12px #b7e0ed, 0 0 14px #b7e0ed, 0 0 16px #b7e0ed!important; */
                                        border: 1px solid transparent!important;
                                        border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent!important;
                                        cursor: pointer!important;
                                        background: none!important;
                                    }
                                    .account-select option{
                                            color: #fff!important;
                                            text-shadow:
                                                    0 0 2px #e4e0e0,
                                                    0 0 4px #31cc4b,
                                                    0 0 6px #361ebf,
                                                    0 0 8px rgb(22, 20, 20),
                                                    0 0 10px #584547,
                                                    0 0 12px #139b55,
                                                    0 0 14px #0c8716,
                                                    0 0 16px #0f8b51;
                                        /* text-shadow: 0 0 2px #b7e0ed, 0 0 4px #b7e0ed, 0 0 6px #b7e0ed, 0 0 8px #b7e0ed, 0 0 10px #b7e0ed, 0 0 12px #b7e0ed, 0 0 14px #b7e0ed, 0 0 16px #b7e0ed!important; */
                                            border: 1px solid transparent!important;
                                            border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent!important;
                                            cursor: pointer!important;
                                        background: black!important;
                                    }
                                </style>
                                <!--custom-select-neon-->
                                <div class="new-select my-2 w-100 account-choose">
                                    <select class="w-100 account-select new-text" name="account" required>
                                          <option value="" disabled selected="selected">Select Game</option>
                                        @foreach(\App\Models\Account::get() as $a => $b)
                                          <option value="{{$b->id}}" data-title="{{$b->title}}">{{$b->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                </div>
                            </div>
                           <div class="col-md-6 col-sm-12 mt-4">
                              <div class="input-group">
                                 <div>
                                    <h4><b><span class="neon-text new-text">Game Id</span></b></h4>
                                 </div>
                                 <input class="input--style-1 transparent-input neon-text-danger game-id-text new-text" type="text" value="{{old('game_id')}}" autocomplete="off" placeholder="SXXXX" name="game_id" maxlength="15" minlength="8" required>
                              </div>
                              <span class="game-id-text-display">The game id must be at least 7 characters.</span>

                           </div>
                        </div>



                        <div class="p-t-20 text-center">
                            <img id="captcha_image" src="https://ak.picdn.net/shutterstock/videos/1020997729/thumb/10.jpg" style="width:200px"> <text id="refresh-captcha" title="Refresh"  class="button ml-2" style="border-radius:8px !important; font-size:13px;"><i class="fa fa-undo" aria-hidden="true"></i></text> <br><br>
                            <div class="input-group justify-content-center border-custom">
                                <div class="m-auto">
                                    <h4><b><span class="neon-text new-text">Enter characters as shown above</span></b></h4>
                                </div><br><br>
                                <input class="input--style-1 transparent-input neon-text-danger captcha-input new-text" type="text" value="" autocomplete="off" placeholder="XXXX" name="captcha_token" maxlength="4" minlength="4" style="text-transform:uppercase;text-align:center">

                            </div><br><br>
                            <button type="submit" class="button px-4 submit-btn"><span class="neon-text new-text">Submit</span></button><br>
                            <p class="alert alert-danger captcha-error hidden" style="background:red;margin-top:10px;" role="alert">Captcha Invalid</p>
                        </div>
                    </form>
                    </br>

           <script>
                document.getElementById("captcha_image").src="https://test99.caandv.com/captcha_image.php?"+Math.random();
                var captchaImage = document.getElementById("captcha_image");
                
                var refreshButton = document.getElementById("refresh-captcha");
                refreshButton.onclick = function(event) {
                    event.preventDefault();
                    captchaImage.src = "https://test99.caandv.com/captcha_image.php?"+Math.random();
                }
            </script>


                    <div class="text-center pt-3">
                        <h4><b><span class="neon-text font-weight-bold">Copyright Cloudgames</span> <span class="just-neon">© 2021</span> <span class="neon-text"> All Rights Reserved</span><b></h4>
                    </div>
                   </div>
                </div>
            </div>
        </div>
</div>
@endsection



    <!-- Jquery JS-->

