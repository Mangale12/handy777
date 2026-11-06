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
                        NOOR GAMES
                    </h2>
                </div>
                <div class="mt-5 mx-5 text-center">
                    <h3 style="line-height:2rem;">
                        <span class="neon-text font-weight-bold blink">We are sorry for your inconvinience</span>. 
                    </h3>
                    <h4 class="mt-4">
                        <span class="font-weight-bold neon-text neon-text-danger blink-danger">It will never be the same without you</span>. 
                    </h4>
                    {{-- <h3 class="mt-4">    
                        <span class="font-weight-bold neon-text blink">Be the owner of your luck</span>.
                    </h3> --}}
                   
                </div> 
                <div class = "text-center logo">
                      <img src="{{ URL::to('/images/dragonnn.gif') }}" width="220" height="250" class="w-auto">
                </div>

                <div class="card-body p-5" style="text-align: center">
                    <div class="text-center pt-3">
                        <h4><b><span class="neon-text font-weight-bold">Copyright Noorgames</span> <span class="just-neon">© 2022</span> <span class="neon-text"> All Rights Reserved</span><b></h4>
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
                    if($('input[name="email"]').val() == ''){
                        toastr.error('Error','Enter Email');
                        return;
                    }
                    form.submit();
                    
                    $.ajaxSetup({
                        headers: {
                            'X-CSRF-TOKEN': jQuery('meta[name="csrf-token"]').attr('content')
                        }
                    });
                    // $.ajax({
                    //         type: "POST",
                    //         url: '/checkCaptcha',
                    //         data: {
                    //             "captcha": $('.captcha-input').val(),
                    //         },
                    //         dataType: 'json',
                    //         success: function (data) {
                    //             if(data == 'true'){
                    //                 form.submit();
                    //             }else{
                    //                 toastr.error('Error','Captcha Incorrect');
                    //             }
                                
                    //         },
                    //         error: function (data) {
                    //             toastr.error('Error','Something went wrong. Please Try again.');
                    //         }
                    //     });
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

