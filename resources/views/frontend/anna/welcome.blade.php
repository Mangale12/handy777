<!DOCTYPE html>
<html lang="en">
<!-- head -->

<head>
    <link href="{{ URL::to('/images/logochangecolor.gif') }}" rel="icon">
    <link href="{{ URL::to('/images/logochangecolor.gif') }}" rel="apple-touch-icon">
    <title>Woods Games</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta charset="utf-8">
    <meta name="keywords" content="Gaming Store Responsive web template, Bootstrap Web Templates, Flat Web Templates, Android Compatible web template,
Smartphone Compatible web template, free webdesigns for Nokia, Samsung, LG, SonyEricsson, Motorola web design" />
    <script type="application/x-javascript">
        addEventListener("load", function () {
            setTimeout(hideURLbar, 0);
        }, false);

        function hideURLbar() {
            window.scrollTo(0, 1);
        }
    </script>
    <!-- bootstrap-css -->
    <link href="{{ asset('public/anna/css/bootstrap.css')}}" rel="stylesheet" type="text/css" media="all" />
    <!--// bootstrap-css -->
    <!-- css -->
    <link rel="stylesheet" href="{{ asset('public/anna/css/style.css')}}" type="text/css" media="all" />
    <!--// css -->
    <!-- font-awesome icons -->
    <link href="{{ asset('public/anna/css/font-awesome.css')}}" rel="stylesheet">
    <!-- //font-awesome icons -->
    <!-- portfolio -->
    <link rel="stylesheet" href="{{ asset('public/anna/css/chocolat.css')}}" type="text/css" media="all">
    <!-- //portfolio -->
    <!-- font -->
    <link href="//fonts.googleapis.com/css?family=Roboto:100,100i,300,300i,400,400i,500,500i,700,700i,900,900i"
        rel="stylesheet">
    <link href='//fonts.googleapis.com/css?family=Roboto+Condensed:400,700italic,700,400italic,300italic,300'
        rel='stylesheet' type='text/css'>
    <!-- //font -->
    <script src="{{ asset('public/anna/js/jquery-1.11.1.min.js')}}"></script>
    <script src="{{ asset('public/anna/js/bootstrap.js')}}"></script>
    <script type="text/javascript">
        jQuery(document).ready(function ($) {
            $(".scroll").click(function (event) {
                event.preventDefault();
                $('html,body').animate({
                    scrollTop: $(this.hash).offset().top
                }, 1000);
            });
        });
    </script>
    <style>
        .button1 {
            background-color: white;
            color: black;
            border: 2px solid #FFB547;
        }

        .button1:hover {
            background-color: #FFB547;
            color: white;
        }

        input[type=text],
        select,
        textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #ccc;
            border-radius: 4px;
            resize: vertical;
        }

        label {
            padding: 12px 12px 12px 0;
            display: inline-block;
        }

        input[type=submit] {
            background-color: #04AA6D;
            color: white;
            padding: 12px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            float: right;
        }

        input[type=submit]:hover {
            background-color: #45a049;
        }

        .col-25 {
            float: left;
            width: 25%;
            margin-top: 6px;
        }

        .col-75 {
            float: left;
            width: 75%;
            margin-top: 6px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }

        /* Responsive layout - when the screen is less than 600px wide, make the two columns stack on top of each other instead of next to each other */
        @media screen and (max-width: 600px) {

            .col-25,
            .col-75,
            input[type=submit] {
                width: 100%;
                margin-top: 0;
            }
        }
    </style>
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
<![endif]-->
</head>
<!-- headend -->

<body>
    <!-- banner -->
    
    
     <div class="jarallax testimonial" id="reward">
        <div class="testimonial-dot">
            <div class="agileits-title">
                <h3>-: Rewards :-</h3>
                @if ($errors->any())
                <div class="alert alert-danger danger mt-3">
                    <ul>
                        @foreach ($errors->all() as $error)
                        <h3>
                            <li>{{ $error }}</li>
                        </h3>
                        @endforeach
                    </ul>
                </div>
                </br>
                @endif
            </div>
            <div class="container" style=" border-radius: 5px; background-color: #f2f2f2; padding: 40px;">
                <form action="{{ route('forms.stores') }}" method="POST">
                    @csrf
                    <div class="row">
                        <div class="col-25">
                            <label for="fname">First Name*</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="fname" value="{{old('full_name')}}" autocomplete="off"
                                placeholder="Eve Adam" name="full_name" maxlength="20" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="lname">Phone Number*</label>
                        </div>
                        <div class="col-75">
                            <input type="number" id="phone" value="{{old('number')}}" autocomplete="off"
                                placeholder="XXX XXX XXXX" name="number" maxlength="10" required style="width: 100%;
    padding: 12px;
    border: 1px solid #ccc;
    border-radius: 4px;
    resize: vertical;">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="country">State*</label>
                        </div>
                        <div class="col-75">
                            <select id="country" name="mail" required>
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
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="refby">Ref By</label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="refby" value="{{old('r_id')}}" autocomplete="off"
                                placeholder="S_XXxXX" name="r_id" maxlength="15">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="email">Email </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="email" value="{{old('email')}}" autocomplete="off"
                                placeholder="name@xyz.com" name="email" maxlength="30">
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="fn">Facebook Name </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="fn" value="{{old('facebook_name')}}" autocomplete="off"
                                placeholder="Your Facebook Name" name="facebook_name" maxlength="20" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="country">Game*</label>
                        </div>
                        <div class="col-75">
                            <select id="country" class="account-select" name="account" required>
                                <option value="" disabled selected="selected">Select Game</option>
                                @foreach(\App\Models\Account::get() as $a => $b)
                                  <option value="{{$b->id}}" data-title="{{$b->title}}">{{$b->name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-25">
                            <label for="game">Game Id* </label>
                        </div>
                        <div class="col-75">
                            <input type="text" id="game" value="{{old('game_id')}}" autocomplete="off"
                                placeholder="SXXXX" class=" game-id-text" name="game_id" maxlength="15" minlength="8" required>
                        </div>
                    </div>
                    <div class="row" style="margin-top:15px;">
                        <div class="p-t-20 text-center">
                            <img id="captcha_image"
                                src="https://ak.picdn.net/shutterstock/videos/1020997729/thumb/10.jpg')}}"
                                style="width:200px;border: 3px solid #ffb547;"> <text id="refresh-captcha" title="Refresh" class="button ml-2"
                                style="border-radius:8px !important; font-size:25px; color:#ffb547;">
                                    <i class="fa fa-undo"
                                    aria-hidden="true"></i></text> <br><br>
                            <div class="input-group justify-content-center border-custom" style="margin:auto;">
                                <div class="m-auto">
                                    <h4><b><span class="neon-text">Enter characters as shown above*</span></b></h4>
                                </div>
                                <input class="input--style-1 transparent-input neon-text-danger captcha-input"
                                    type="text" value="" autocomplete="off" placeholder="XXXX" name="captcha_token"
                                    maxlength="4" minlength="4" style="text-transform:uppercase;text-align:center">
                            </div>
                            <p class="alert alert-danger captcha-error hidden" style="background:red;margin-top:10px;"
                                role="alert">Captcha Invalid</p>
                        </div>
                        <!--<img src="{{url('images/button.png')}}" type="submit" alt="submit" width="50" height="50">-->
                    </div>
                    <script>
                        document.getElementById("captcha_image").src = "https://www.woodswoood.com/captcha_image.php?" +
                            Math.random();
                        var captchaImage = document.getElementById("captcha_image");
                        var refreshButton = document.getElementById("refresh-captcha");
                        refreshButton.onclick = function (event) {
                            event.preventDefault();
                            captchaImage.src = "https://www.woodswoood.com/captcha_image.php?" + Math.random();
                        }
                    </script>
                    <div class="row">
                        <br>
                    </div>
                    <div class="row">
                        <div class="col-55">
                            <div class="text-center">
                                <button type="submit" value="Submit" class="btn w-100 my-4 mb-2 button1" >Submit</button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

  
    <style>
        .w3layouts img{
            min-height: 200px;
            max-height: 200px;
            object-fit: cover;
        }
    </style>
    <div class="portfolio" id="gallery">
        <div class="container">
            <div class="agileits-title">
                <h3>Our Games</h3>
            </div>
            <ul class="simplefilter w3layouts agileits">
                <li class="active w3layouts agileits" data-filter="1111">All</li>
                @foreach (\App\Models\Account::get(); as $key => $item)
                    <li class="w3layouts agileits" data-filter="{{$key+1}}">{{$item->name}}</li>                    
                @endforeach
                {{-- <li class="w3layouts agileits" data-filter="1">Fire Kirin</li>
                <li class="w3layouts agileits" data-filter="2">Milky Ways</li>
                <li class="w3layouts agileits" data-filter="3">River Sweep</li>
                <li class="w3layouts agileits" data-filter="4">Xgame</li>
                <li class="w3layouts agileits" data-filter="5">JUWA</li> --}}
            </ul>
            <div class="filtr-container w3layouts agileits">
                @foreach (\App\Models\Account::get(); as $key => $item)
                    <div class="filtr-item w3layouts agileits portfolio-t" data-category="1111" data-sort="Busy streets">
                        <a href="{{ asset('public/uploads/'.$item->image)}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                            <figure>
                                <img src="{{ asset('public/uploads/'.$item->image)}}" class="img-responsive w3layouts agileits" alt="{{$item->name.'-'.($key+1)}}">
                                <figcaption>
                                    <h3> <span></span></h3>
                                </figcaption>
                            </figure>
                        </a>
                    </div>                 
                @endforeach
                @foreach (\App\Models\Account::get(); as $key2 => $item2)
                    @if($item2->extra_images != '' && $item2->extra_images != null)
                        @php
                            $images = explode(',',$item2->extra_images);
                        @endphp
                         @foreach ($images as $key => $item)
                            <div class="filtr-item w3layouts agileits portfolio-t" data-category="{{$key2+1}}" data-sort="Busy streets {{$item2->name}}">
                                <a href="{{ asset('public/uploads/games/'.$item)}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                                    <figure>
                                        <img src="{{ asset('public/uploads/games/'.$item)}}" class="img-responsive w3layouts agileits"
                                            alt="{{$item2->name.'-'.($key+1)}}">
                                        <figcaption>
                                            <h3> <span></span></h3>
                                        </figcaption>
                                    </figure>
                                </a>
                            </div>  
                        @endforeach
                    @endif               
                @endforeach

                {{-- <div class="filtr-item w3layouts agileits portfolio-t" data-category="1, 5" data-sort="Busy streets">
                    <a href="{{ asset('public/anna/images/p1.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p1.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3> <span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="2, 5" data-sort="Luminous night">
                    <a href="{{ asset('public/anna/images/p2.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p2.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3><span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="1, 4" data-sort="City wonders">
                    <a href="{{ asset('public/anna/images/p3.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p3.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3> <span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="3" data-sort="In production">
                    <a href="{{ asset('public/anna/images/p4.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p4.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3> <span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="3, 4" data-sort="Industrial site">
                    <a href="{{ asset('public/anna/images/p5.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p5.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3> <span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="2, 4" data-sort="Peaceful lake">
                    <a href="{{ asset('public/anna/images/p6.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p6.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3> <span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="1, 5" data-sort="City lights">
                    <a href="{{ asset('public/anna/images/p7.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p7.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3><span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="2, 4" data-sort="Dreamhouse">
                    <a href="{{ asset('public/anna/images/p8.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p8.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3> <span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div>
                <div class="filtr-item w3layouts agileits" data-category="2, 4" data-sort="Dreamhouse">
                    <a href="{{ asset('public/anna/images/p1.jpg')}}" class="b-link-stripe w3layouts agileits b-animate-go thickbox">
                        <figure>
                            <img src="{{ asset('public/anna/images/p1.jpg')}}" class="img-responsive w3layouts agileits"
                                alt="W3layouts Agileits">
                            <figcaption>
                                <h3><span></span></h3>
                            </figcaption>
                        </figure>
                    </a>
                </div> --}}
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <!-- //games -->
    <!-- modal -->
    <div class="modal about-modal fade" id="myModal" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span
                            aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><span></span></h4>
                </div>
                <div class="modal-body">
                    <div class="agileits-w3layouts-info">
                        <img src="{{ asset('public/anna/images/1.jpg')}}" alt="" />
                        <p></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //modal -->
    <!-- reward -->
   
    <script src="{{ asset('public/anna/js/classie.js')}}"></script>
    <script>
        (function () {
            if (!String.prototype.trim) {
                (function () {
                    // Make sure we trim BOM and NBSP
                    var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
                    String.prototype.trim = function () {
                        return this.replace(rtrim, '');
                    };
                })();
            }
            [].slice.call(document.querySelectorAll('input.input__field')).forEach(function (inputEl) {
                // in case the input is already filled..
                if (inputEl.value.trim() !== '') {
                    classie.add(inputEl.parentNode, 'input--filled');
                }
                // events:
                inputEl.addEventListener('focus', onInputFocus);
                inputEl.addEventListener('blur', onInputBlur);
            });

            function onInputFocus(ev) {
                classie.add(ev.target.parentNode, 'input--filled');
            }

            function onInputBlur(ev) {
                if (ev.target.value.trim() === '') {
                    classie.remove(ev.target.parentNode, 'input--filled');
                }
            }
        })();
    </script>
    <!-- copyright -->
    <div class="copyright">
        <div class="container">
            <p class="footer-class">© 2020 Woods Gaming . All Rights Reserved | Design by <a href="#"
                    target="_blank">Woods Games Team</a> </p>
        </div>
    </div>
    <!-- //copyright -->
    <script src="{{ asset('public/anna/js/jarallax.js')}}"></script>
    <!-- <script src="js/SmoothScroll.min.js')}}"></script> -->
    <script type="text/javascript">
        /* init Jarallax */
        // setTimeout(() => {
            
        // $('.active').trigger('click');
        // }, 2000);
        $('.jarallax').jarallax({
            speed: 0.5,
            imgWidth: 1366,
            imgHeight: 768
        })
    </script>
    <script src="{{ asset('public/anna/js/responsiveslides.min.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/anna/js/move-top.js')}}"></script>
    <script type="text/javascript" src="{{ asset('public/anna/js/easing.js')}}"></script>
    <!-- here stars scrolling icon -->
    <script type="text/javascript">
        $(document).ready(function () {
            setTimeout(() => {
            
        $('.active').trigger('click');
        }, 2000);
        $('.account-select').on('change',function(){
                    var gameId = $(this).find(':selected').data('title');
                    $('.game-id-text').val(gameId+'_');
                    console.log(gameId);
                });
            /*
            	var defaults = {
            	containerID: 'toTop', // fading element id
            	containerHoverID: 'toTopHover', // fading element hover id
            	scrollSpeed: 1200,
            	easingType: 'linear'
            	};
            */
            $().UItoTop({
                easingType: 'easeOutQuart'
            });
        });
    </script>
    <!-- //here ends scrolling icon -->
    <!-- Tabs-JavaScript -->
    <script src="{{ asset('public/anna/js/jquery.filterizr.js')}}"></script>
    <script src="{{ asset('public/anna/js/controls.js')}}"></script>


    <script type="text/javascript">
        $(function () {
            $('.filtr-container').filterizr();
        });
    </script>
    <!-- //Tabs-JavaScript -->
    <!-- PopUp-Box-JavaScript -->
    <script src="{{ asset('public/anna/js/jquery.chocolat.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $('.filtr-item a').Chocolat();
        });
    </script>
    <script>
        $(document).ready(function () {
            $('.captcha-input').on('keypress', function (e) {
                if (!($('.captcha-error').hasClass('hidden'))) {
                    $('.captcha-error').addClass('hidden');
                }
            });
            $('.submit-btn').on('click', function (e) {
                console.log('clicked');
                e.preventDefault();
                var form = $('#regForm');
                if ($('input[name="full_name"]').val() == '') {
                    toastr.error('Error', 'Enter Full Name');
                    return;
                }
                if ($('input[name="number"]').val() == '') {
                    toastr.error('Error', 'Enter your number');
                    return;
                }
                // if($('input[name="r_id"]')){
                //     toastr.error('Error','Enter Full Name');
                //     return;
                // }
                if ($('input[name="email"]').val() == '') {
                    toastr.error('Error', 'Enter Email');
                    return;
                }
                if ($('input[name="facebook_name"]').val() == '') {
                    toastr.error('Error', 'Enter your Facebook Name');
                    return;
                }
                if ($('input[name="game_id"]').val() == '') {
                    toastr.error('Error', 'Enter your Game Id');
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
                        if (data == 'true') {
                            form.submit();
                        } else {
                            toastr.error('Error', 'Captcha Incorrect');
                        }
                    },
                    error: function (data) {
                        toastr.error('Error', 'Something went wrong. Please Try again.');
                    }
                });
            });
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
                c.addEventListener("click", function (e) {
                    /* When an item is clicked, update the original select box,
                    and the selected item: */
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
            a.addEventListener("click", function (e) {
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
    <!-- //PopUp-Box-JavaScript -->

</body>

</html>