<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 
    <meta name="description" content="Noor-games">
    <meta name="author" content="Noor-games">
    <meta name="keywords" content="Noor-games">
<meta content="" name="Noor-games">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="{{ URL::to('/images/logochangecolor.gif') }}" rel="icon">
    <link href="{{ URL::to('/images/logochangecolor.gif') }}" rel="apple-touch-icon">
    <!-- Title Page-->
    <title>Noor-games</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    <!-- Icons font CSS-->
    <link href="{{ asset('vendor/mdi-font/css/material-design-iconic-font.min.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('vendor/font-awesome-4.7/css/font-awesome.min.css') }}" rel="stylesheet" media="all">
    <!-- Font special for pages-->
<link rel="preconnect" href="https://fonts.gstatic.com">
<link href="https://fonts.googleapis.com/css2?family=Bangers&display=swap" rel="stylesheet">

    <!-- Vendor CSS-->
     <link href="{{ asset('vendor/select2/select2.min.css') }}" rel="stylesheet" media="all">
 <link href="{{ asset('vendor/datepicker/daterangepicker.css') }}" rel="stylesheet" media="all">

    <!-- Main CSS-->
     <script src="{{ asset('js/app.js') }}" defer></script>

    <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all">
    <link href="{{ asset('css/my.css') }}" rel="stylesheet" media="all">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<style>
    * {
      box-sizing: border-box;
    }
    #myVideo {
      position: fixed;
      right: 0;
      bottom: 0;
      min-width: 100%; 
      min-height: 100%;
    }
    
    @media screen and (max-width: 576px) {
          #myVideo {
                position: fixed;
                left: -55%;
                top: 0;
                height: 100vh;
            }
        }
</style>
</head>
<body>
    <video autoplay muted loop id="myVideo">
    <source src="{{url('images/fin.mp4')}}" type="video/mp4">
    Your browser does not support HTML5 video.
    </video>
    
    <div class="page-wrapper font-robo">
        <div class="wrapper wrapper--w680">
            <div class="card card-1 py-5">
                <!--<div class="card-heading">  -->
                <!--</div>-->
              <div>
                    <h2 class="font-weight-bold text-center main-header-text">
                       WELCOME TO THE PART OF THE NOOR GAME FAMILY
                    </h2>
                </div>
                <div class="card-body p-5">
                    <div class = "text-left">
                        <h3 style="line-height:2rem;">
                                <span class="neon-text font-weight-bold blink"> </span><span class="just-neon"></span><span class="neon-text font-weight-bold"></span>.
                        </h3>
                        <h4 class="mt-4">
                            <span class="neon-text neon-text-danger font-weight-bold blink-danger">Someone will reach out to you soon</span>.
                        </h4>
                        <h3 class="mt-4">
                            <span class="neon-text font-weight-bold blink">Thank you</span>
                        </h3>
                    </div> 
                    <!--<img src="{{ URL::to('/images/polacy.png') }}" width="500" height="600">-->
                  
                    
                    <div class = "text-center logo">
                      <img src="{{ URL::to('/images/dragonnn.gif') }}" width="220" height="250" class="w-auto">
                </div>
                </div>
      
                <div class="text-center mt-4">
                      <strong><h2><b><span class="neon-text font-weight-bold">Popular Games</span></b></h2></strong>
                      
                        <div id="image-carousel" class="carousel slide" data-ride="carousel">
                            <ol class="carousel-indicators">
                                <li data-target="#image-carousel" data-slide-to="0" class="active"></li>
                                <li data-target="#image-carousel" data-slide-to="1"></li>
                                <li data-target="#image-carousel" data-slide-to="2"></li>
                                <li data-target="#image-carousel" data-slide-to="3"></li>
                                <li data-target="#image-carousel" data-slide-to="4"></li>
                                <li data-target="#image-carousel" data-slide-to="5"></li>
                            </ol>
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                  <img class="d-block m-auto" src="{{ URL::to('/images/icon.gif') }}" width="400" height="500" alt="First slide">
                                </div>
                                <div class="carousel-item">
                                  <img class="d-block m-auto" src="{{ URL::to('/images/icon2.gif') }}" width="400" height="500" alt="Second slide">
                                </div>
                                <div class="carousel-item">
                                  <img class="d-block m-auto" src="{{ URL::to('/images/iconss3.gif') }}" width="400" height="500" alt="Third slide">
                                </div>
                                <div class="carousel-item">
                                  <img class="d-block m-auto" src="{{ URL::to('/images/icon4.gif') }}" width="400" height="500" alt="Fourth slide">
                                </div>
                                <div class="carousel-item">
                                  <img class="d-block m-auto" src="{{ URL::to('/images/mainicons.gif') }}" width="400" height="500" alt="Fifth slide">
                                </div>
                                 <div class="carousel-item">
                                  <img class="d-block m-auto" src="{{ URL::to('/images/pureicons.gif') }}" width="400" height="500" alt="Sixth slide">
                                </div>
                            </div>
                            <!--<a class="carousel-control-prev" href="#image-carousel" role="button" data-slide="prev">-->
                            <!--    <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                            <!--    <span class="sr-only">Previous</span>-->
                            <!--</a>-->
                            <!--<a class="carousel-control-next" href="#image-carousel" role="button" data-slide="next">-->
                            <!--    <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                            <!--    <span class="sr-only">Next</span>-->
                            <!--</a>-->
                        </div>
                      
                        <!--<img src="{{ URL::to('/images/popular.gif') }}" width="400" height="500">-->
                    </div>
                    
                    <div class="text-center pt-3">
                        <h4><b><span class="neon-text font-weight-bold">Copyright Noorgames</span> <span class="just-neon">© 2021</span> <span class="neon-text"> All Rights Reserved</span><b></h4>
                    </div>
            </div>
        </div>
    </div>
    
    
<!--     <div class="page-wrapper bg-blue p-t-100 p-b-100 font-robo">-->
<!--<audio src="{{URL::asset("/images/initial.mp3")}}" autoplay loop></audio>-->
<!--<video width="100%" autoplay muted loop id="myVideo" >-->
<!--  <source src="{{URL::asset("/images/v2.mp4")}}" type="video/mp4" autoplay loop>-->
<!--  Your browser does not support HTML5 video.-->
<!--</video>-->
<!--</div>-->

<script src="vendor/jquery/jquery.min.js"></script>
<!-- Vendor JS-->
<script src="vendor/select2/select2.min.js"></script>
<script src="vendor/datepicker/moment.min.js"></script>
<script src="vendor/datepicker/daterangepicker.js"></script>

<!-- Main JS-->
<script src="js/global.js"></script>
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
<script>

var video = document.getElementById("myVideo");
var btn = document.getElementById("myBtn");

function myFunction() {
  if (video.paused) {
    video.play();
    btn.innerHTML = "Pause";
  } else {
    video.pause();
    btn.innerHTML = "Play";
  }
}

$('.carousel').carousel({
  interval: 3000
})
</script>

</body>
</html>
