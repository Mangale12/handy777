<!DOCTYPE html>
<html lang="en">

<head>
 
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=yes">
    <meta name="description" content="Noor-games">
    <meta name="author" content="Noor-games">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="keywords" content="Noor-games">
    <meta content="" name="Noor-games">
    <meta content="" name="Noor-games">

    <!-- Favicons -->
    <link href="{{ URL::to('/images/logochangecolor.gif') }}" rel="icon">
    <link href="{{ URL::to('/images/logochangecolor.gif') }}" rel="apple-touch-icon">
    <!-- Title Page-->
    <title>Noor-games</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Icons font CSS-->

    <!-- Font special for pages-->


    <!-- Vendor CSS-->
    <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >

    <!-- Main CSS-->
     <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all">
      <link href="{{ asset('css/my.css') }}" rel="stylesheet" media="all">
    <style>
    .hidden{
        display:none;
    }
        @media screen and (max-width: 576px) {
          #myVideo {
                position: fixed;
                right: -5%;
                top: 0;
                height: 100vh;
            }
        }
           .input-group.border-custom {
               border:0;
           }
       .input-group.border-custom::after { 
                 content:'';
                 height: 2px;
                width: 106px;
                background: #006aff;
        }
        #captcha_image {
                border: 2px solid #d36d77;
         
    animation: glowing 1300ms infinite;
        }
 
        
    </style>
</head>

<body>
    <div class="page-wrapper font-robo">
    <video autoplay muted loop id="myVideo">
    <source src="{{url('images/fin.mp4')}}" type="video/mp4">
    Your browser does not support HTML5 video.
    </video>
    <div class="page-wrapper font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1 py-5">
                <!--<div class="card-heading">-->
                    
                <!--</div>-->
                <div>
                    <h2 class="font-weight-bold text-center main-header-text">
                        WELCOME TO THE NOOR GAMES
                    </h2>
                </div>
                <div class="mt-5 mx-5 text-center">
                    <h3 style="line-height:2rem;">
                        <span class="neon-text font-weight-bold blink">Complete the registration process and start getting your bonus and rewards</span>. 
                    </h3>
                    <h4 class="mt-4">
                        <span class="font-weight-bold neon-text neon-text-danger blink-danger">You are only a few steps away</span>. 
                    </h4>
                    <h3 class="mt-4">    
                        <span class="font-weight-bold neon-text blink">Be the owner of your luck</span>.
                    </h3>
                   
                </div> 
                <div class = "text-center logo">
                      <img src="{{ URL::to('/images/dragonnn.gif') }}" width="220" height="250" class="w-auto">
                </div>

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
                            <div class="col-md-4 col-sm-12 mt-4">
                                <div class="input-group">
                                    <div class = "text-center">
                                        <h4><b><span class="neon-text">Full Name</span>*</b></h4>
                                    </div>
                                    <input class="input--style-1 transparent-input neon-text-danger" type="text" value="{{old('full_name')}}" autocomplete="off" placeholder="Eve Adam" name="full_name" maxlength="20" required>
                                </div>
                            </div>
                            
                            <div class="col-md-4 col-sm-12 mt-4">
                                <div class="input-group">
                                     <div>
                                   <h4><b><span class="neon-text">Phone Number</span>*</b></h4></div>
                                    <input class="input--style-1 transparent-input neon-text-danger" type="tel" value="{{old('number')}}" autocomplete="off" placeholder="XXX XXX XXXX" name="number" maxlength="10" required>
                                </div>
                            </div>
                            
                          
                            <div class="col-md-4 col-sm-12 mt-4 text-left">
                                <div class="input-group">
                                     <div>
                                   <h4><b><span class="neon-text">State</span>*</b></h4>
                                </div> 
                                <div class="custom-select-neon my-2 w-100">
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
                                        <h4><b><span class="neon-text">Referred By (If Applies)</span></b></h4>
                                    </div>
                                    <input class="input--style-1 transparent-input neon-text-danger" type="text" value="{{old('r_id')}}" autocomplete="off" placeholder="S_XXxXX" name="r_id" maxlength="15" >
                                </div>
                            </div>
                    
                            
                            <div class="col-md-6 col-sm-12 mt-4">
                                <div class="input-group">
                                     <div>
                                   <h4><b><span class="neon-text">Email <span style="color:red">*</span></span></b></h4>
                                </div> 
                                    <input required class="input--style-1 transparent-input neon-text-danger" type="email" value="{{old('email')}}" autocomplete="off" placeholder="name@xyz.com" name="email">
                                </div>
                            </div>
                            
                             <div class="col-md-6 col-sm-12 mt-4">
                              <div class="input-group">
                                 <div class = "text-center">
                                    <h4><b><span class="neon-text">Facebook Name</span></b></h4>
                                 </div>
                                 <input class="input--style-1 transparent-input neon-text-danger" type="text" value="{{old('facebook_name')}}" autocomplete="off" placeholder="Your Facebook Name" name="facebook_name" maxlength="20" required>
                              </div>
                           </div>
                             <div class="col-md-6 col-sm-12 mt-4 text-left">
                                <div class="input-group">
                                    <div>
                                        <h4><b><span class="neon-text">Game</span>*</b></h4>
                                   </div>
                                <style>
                                    .account-choose .select-items{
                                        position: absolute;
                                        background-color: #000000e8;    
                                    }
                                    .account-select{
                                        font-size: 1.3rem!important;
                                        color: #fff!important;
                                        text-shadow: 0 0 2px #dc3545, 0 0 4px #dc3545, 0 0 6px #dc3545, 0 0 8px #dc3545, 0 0 10px #dc3545, 0 0 12px #dc3545, 0 0 14px #dc3545, 0 0 16px #dc3545!important;
                                        border: 1px solid transparent!important;
                                        border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent!important;
                                        cursor: pointer!important;
                                        background: none!important;
                                    }
                                    .account-select option{
                                            color: #fff!important;
                                        text-shadow: 0 0 2px #dc3545, 0 0 4px #dc3545, 0 0 6px #dc3545, 0 0 8px #dc3545, 0 0 10px #dc3545, 0 0 12px #dc3545, 0 0 14px #dc3545, 0 0 16px #dc3545!important;
                                            border: 1px solid transparent!important;
                                            border-color: transparent transparent rgba(0, 0, 0, 0.1) transparent!important;
                                            cursor: pointer!important;
                                        background: black!important;
                                    }
                                </style>
                                <!--custom-select-neon-->
                                <div class="new-select my-2 w-100 account-choose">
                                    <select class="w-100 account-select" name="account" required>
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
                                    <h4><b><span class="neon-text">Game Id</span></b></h4>
                                 </div>
                                 <input class="input--style-1 transparent-input neon-text-danger game-id-text" type="text" value="{{old('game_id')}}" autocomplete="off" placeholder="SXXXX" name="game_id" maxlength="15" minlength="8" required>
                              </div>
                           </div>
                        </div>
                    


                        <div class="p-t-20 text-center">
                            <img id="captcha_image" src="https://ak.picdn.net/shutterstock/videos/1020997729/thumb/10.jpg" style="width:200px"> <text id="refresh-captcha" title="Refresh"  class="button ml-2" style="border-radius:8px !important; font-size:13px;"><i class="fa fa-undo" aria-hidden="true"></i></text> <br><br>
                            <div class="input-group justify-content-center border-custom">
                                <div class="m-auto">
                                    <h4><b><span class="neon-text">Enter characters as shown above</span></b></h4>
                                </div><br><br>
                                <input class="input--style-1 transparent-input neon-text-danger captcha-input" type="text" value="" autocomplete="off" placeholder="XXXX" name="captcha_token" maxlength="4" minlength="4" style="text-transform:uppercase;text-align:center">
                                
                            </div><br><br>
                            <button type="submit" class="button px-4 submit-btn"><span class="neon-text">Submit</span></button><br>
                            <p class="alert alert-danger captcha-error hidden" style="background:red;margin-top:10px;" role="alert">Captcha Invalid</p>
                        </div>
                        <!--<img src="{{url('images/button.png')}}" type="submit" alt="submit" width="50" height="50">-->
                    </form>
                    </br>
            
            <script>
                document.getElementById("captcha_image").src="https://test.noorgames.net/captcha_image.php?"+Math.random();
                var captchaImage = document.getElementById("captcha_image");
                
                var refreshButton = document.getElementById("refresh-captcha");
                refreshButton.onclick = function(event) {
                    event.preventDefault();
                    captchaImage.src = "https://noorgames.net/captcha_image.php?"+Math.random();
                }
            </script>


                    <div class="text-center pt-3">
                        <h4><b><span class="neon-text font-weight-bold">Copyright Noorgames</span> <span class="just-neon">© 2021</span> <span class="neon-text"> All Rights Reserved</span><b></h4>
                    </div>
                   </div>
                </div>
            </div>
        </div>
    </div>
    
    

    <!-- Jquery JS-->
    
    <script src="js/jquery.min.js"></script>
    <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>

<!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
    <!-- Vendor JS-->
    <script src="vendor/select2/select2.min.js"></script>
    <script src="vendor/datepicker/moment.min.js"></script>
    <script src="vendor/datepicker/daterangepicker.js"></script>

    <!-- Main JS-->
    <script src="js/global.js"></script>
    <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
       <script src="https://kit.fontawesome.com/a26d9146a0.js" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <script>
    
         $(document).ready( function () {
               $('.captcha-input').on('keypress',function(e) {
                  if(!($('.captcha-error').hasClass('hidden'))){
                      $('.captcha-error').addClass('hidden');
                  }
                });
                $('.account-select').on('change',function(){
                    var gameId = $(this).find(':selected').data('title');
                    $('.game-id-text').val(gameId+'_');
                    console.log(gameId);
                });
             

              $('.submit-btn').on('click',function(e) {
                    e.preventDefault();
                    var form = $('#regForm');
                    
                    if($('input[name="full_name"]').val() == ''){
                        toastr.error('Error','Enter Full Name');
                        return;
                    }
                    if($('input[name="number"]').val() == ''){
                        toastr.error('Error','Enter your number');
                        return;
                    }
                    // if($('input[name="r_id"]')){
                    //     toastr.error('Error','Enter Full Name');
                    //     return;
                    // }
                    if($('input[name="email"]').val() == ''){
                        toastr.error('Error','Enter Email');
                        return;
                    }
                    if($('input[name="facebook_name"]').val() == ''){
                        toastr.error('Error','Enter your Facebook Name');
                        return;
                    }
                    if($('input[name="game_id"]').val() == ''){
                        toastr.error('Error','Enter your Game Id');
                        return;
                    }
                    // if($('input[name="full_name"]')){
                    //     toastr.error('Error','Enter Full Name');
                    //     return;
                    // }
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    $.ajax({
                            type: "POST",
                            url: '/checkCaptcha',
                            data: {
                                "captcha": $('.captcha-input').val(),
                            },
                            dataType: 'json',
                            success: function (data) {
                                if(data == 'true'){
                                    form.submit();
                                }else{
                                    toastr.error('Error','Captcha Incorrect');
                                }
                                
                            },
                            error: function (data) {
                                toastr.error('Error','Something went wrong. Please Try again.');
                            }
                        });
                });
            } );
    
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
        //   console.log(a);
          x[i].appendChild(a);
          
          console.log(x);
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
                var y, i, k, s, h, sl, yl;
                s = this.parentNode.parentNode.getElementsByTagName("select")[0];
                console.log(s);
                sl = s.length;
                h = this.parentNode.previousSibling;
                console.log(h);
                for (i = 0; i < sl; i++) {
                  if (s.options[i].innerHTML == this.innerHTML) {
                    s.selectedIndex = i;
                    console.log(i);
                    h.innerHTML = this.innerHTML;
                    console.log(h);
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
          console.log(b);
          x[i].appendChild(b);
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
</body>

</html>

