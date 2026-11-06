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
        .w3layouts img{
            min-height: 200px;
            max-height: 200px;
            object-fit: cover;
        }
    </style>
    <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js')}}"></script>
<![endif]-->
</head>
<!-- headend -->

<body>
    <!-- banner -->
    <div class="banner">
        <div class="agileinfo-dot">
            <div class="agileits-logo">
                <h1><a href="index.html">Registration <span>Completed</span></a></h1>
            </div>
            <!--<div class="header-top">-->
            <!--    <div class="container">-->
            <!--        <div class="header-top-info">-->
            <!--            <nav class="navbar navbar-default">-->
                            <!-- Brand and toggle get grouped for better mobile display -->
            <!--                <div class="navbar-header">-->
            <!--                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse"-->
            <!--                        data-target="#bs-example-navbar-collapse-1">-->
            <!--                        <span class="sr-only">Toggle navigation</span>-->
            <!--                        <span class="icon-bar"></span>-->
            <!--                        <span class="icon-bar"></span>-->
            <!--                        <span class="icon-bar"></span>-->
            <!--                    </button>-->
            <!--                </div>-->
                            <!-- Collect the nav links, forms, and other content for toggling -->
            <!--                <div class="collapse navbar-collapse nav-wil" id="bs-example-navbar-collapse-1">-->
            <!--                    <nav>-->
            <!--                        <ul class="nav navbar-nav">-->
            <!--                            <li class="active"><a href="index.html">Home</a></li>-->
            <!--                            <li><a href="#about" class="scroll">About</a></li>-->
            <!--                            <li><a href="#gallery" class="scroll">Our Games</a></li>-->
            <!--                            <li><a href="#reward" class="scroll">Rewards</a></li>-->
                                        <!-- <li><a href="#mail" class="scroll">Mail Us</a></li> -->
            <!--                        </ul>-->
            <!--                    </nav>-->
            <!--                </div>-->
                            <!-- /.navbar-collapse -->
            <!--            </nav>-->
            <!--        </div>-->
            <!--    </div>-->
            <!--</div>-->
            <div class="w3layouts-banner-info">
                <div class="container">
                    <div class="w3layouts-banner-slider">
                        <div class="w3layouts-banner-top-slider">
                            <div class="slider">
                                <div class="callbacks_container">
                                    <ul class="rslides callbacks callbacks1" id="slider4">
                                        <li>
                                            <div class="banner_text">
                                                <h3 style="font-size:35px;">Stay connected with WOODS Games for much exciting bonus & reward</h3>
                                                <p>You should be receiving the confirmation text on the number that you registered</p>
                                                <p style="font-size:25px; font-weight:bold;">Happy Playing</p>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="clearfix"> </div>
                                <!--banner Slider starts Here-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- //banner -->

    <div class="portfolio" id="gallery">
        <div class="container">
            <div class="agileits-title">
                <h3>Our Popular Games</h3>
            </div>
            <ul class="simplefilter w3layouts agileits">
                <li class="active w3layouts agileits" data-filter="1111">All</li>
                @foreach (\App\Models\Account::get(); as $key => $item)
                    <li class="w3layouts agileits" data-filter="{{$key+1}}">{{$item->name}}</li>                    
                @endforeach
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
                    <h4 class="modal-title">Gaming <span>Store</span></h4>
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