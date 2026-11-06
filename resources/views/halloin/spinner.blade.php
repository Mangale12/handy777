<?php
   $final_encoded = json_encode($final);
   
   // $settings = \App\Models\GeneralSetting::first();
   $spinner_date_new = $settings->spinner_date;
   $spinner_time_new =$settings->spinner_time;
        
//   if(!isset($final['players_list']) OR !isset($final['players_list'][0]['player_name'])) {
//       die("Players list empty. Send data to see the spinner. ");
//   }
   
   //print_r($final);die();
 
   ?>
<!DOCTYPE html>
<html lang="en">
   <head>
      <!-- Required meta tags-->
      <meta charset="UTF-8">
       <link rel="icon" href="public/anna2/assets/fav.jpeg">
     
      <meta name="viewport" content="width=device-width" content="initial-scale-1">
     
      <meta name="csrf-token" content="{{ csrf_token() }}">
      
      <!-- Favicons -->
      <link href="{{ URL::to('/images/woods/1657988847.png') }}" rel="icon">
      <link href="{{ URL::to('/images/woods/1657988847.png') }}" rel="apple-touch-icon">
      <!-- Title Page-->
      <title>Handy Games</title>
      <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
      <!-- Icons font CSS-->
      <!-- Font special for pages-->
      <link rel="stylesheet" href="../../assets/main.css" type="text/css" />
      <script type="text/javascript" src="../../assets/winwheel.js"></script>
      <script src="../../assets/tweenmax.js"></script>
      {{-- <script src="{{asset('assets/tweenmax.js')}}"></script> --}}
      <!-- Vendor CSS-->
      <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
      <!-- Main CSS-->
      <!--<script src="{{ asset('js/app.js') }}" defer></script>-->
      {{-- 
      <link href="{{ asset('css/main.css') }}" rel="stylesheet" media="all">
      --}}
      <link href="{{ asset('css/my.css') }}" rel="stylesheet" media="all">
      <!---->
      <!--     Fonts and icons     -->
      <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
      <!-- Nucleo Icons -->
      <link href="{{asset('public/newAdmin/css/nucleo-icons.css')}}" rel="stylesheet" />
      <link href="{{asset('public/newAdmin/css/nucleo-svg.css')}}" rel="stylesheet" />
      <!-- Font Awesome Icons -->
      <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
      <!-- CSS Files -->
      <link id="pagestyle" href="{{asset('public/newAdmin/css/argon-dashboard.css')}}" rel="stylesheet" />
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.css">
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.13/css/dataTables.jqueryui.css" />
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.jqueryui.css" />
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.css" >
      <link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.css" rel="stylesheet">
      <link href="https://fonts.cdnfonts.com/css/digital-7-mono" rel="stylesheet">
      <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" >
      <link href="https://fonts.cdnfonts.com/css/patrick-hand-sc" rel="stylesheet">
      <link rel="stylesheet" href="{{ asset('public/anna2/assets/css/style.css')}}" type="text/css" media="all" />
      <link href="{{asset('public/css/jquery.mCustomScrollbar.css')}}" rel="stylesheet" />
      <style>
         #preload{
         display:none;
         }
         .hidden{
         display:none;
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
         .canvas-wrap{
         background: rgba(0,0,0,0.6);
         border-radius: 50%;
         height: 50%;
         width: 100%;
         }
         #canvas{
         position: relative;
         width: 32vw;
         /*        -webkit-transition: width 1s ease-in-out;*/
         /*-moz-transition: width 0.5s ease-in-out;*/
         /*-o-transition: width 0.5s ease-in-out;*/
         /*transition: width 0.5s ease-in-out;*/
         }
         .player-list{
         position: absolute;
         height:100% !important;
         color: red;
         /* top: 0px; */
         z-index: 1;
         font-size: 18px;
         font-family: 'neon_planetdisplay', Arial, sans-serif;
         overflow:scroll;
         /*background:rgba(0,0,0,0.6) !important;*/
         width:100%;
         }
         .player-list2{
         position: absolute;
         right: 11%;
         z-index: 1;
         color: blue;
         font-size: 18px;
         height:100vh !important;
         overflow:scroll;
         /*background:rgba(0,0,0,0.6) !important;*/
         }
         .player-list,
         .player-list2 {
         -ms-overflow-style: none;  /* Internet Explorer 10+ */
         scrollbar-width: none;  /* Firefox */
         }
         .player-list::-webkit-scrollbar,
         .player-list2::-webkit-scrollbar { 
         display: none;  /* Safari and Chrome */
         }
         .mCSB_container_wrapper{
         margin: 0px;
         }
         .neon-text2{
        color: #fff;
            letter-spacing: 2px;
            text-shadow: 0 0 2px #006aff, 0 0 4px #006aff, 0 0 6px #006aff, 0 0 8px #006aff, 0 0 10px #006aff, 0 0 12px #006aff, 0 0 14px #006aff, 0 0 16px #006aff;
         }
         #countdown{
         border-radius:10px;
         padding:8px 20px;
         color: white;
         font-size: 25px;
         }
         .outer-curtain {
         display: table;
         height: 100%;
         margin: 0;
         width: 100% !important;
         background: #000000;
         }
         .tcell {
         display: table-cell;
         vertical-align: middle;
         }
         .curtain-wrapper {
         /* min-width: 40%;
         max-width: 640px;
         */
         width: 100%;
         margin: auto;
         }
         .curtain {
         position: absolute;
         top: 0;
         left: 0;
         bottom: 0;
         right: 0;
         width: 100%;
         height: 100%;
         box-sizing: border-box;
         overflow: hidden;
         background-image: url("{{asset('public/img/curt_1.gif')}}");
         background-size:cover;
         }
         @media (max-width: 768px) {
         body {
         height:auto;
         }
         }
      </style>
   </head>
   <body>
      <div id='background_static'></div>
      
      <script>
         var confetti = {
         maxCount: 150,		//set max confetti count
         speed: 2,			//set the particle animation speed
         frameInterval: 15,	//the confetti animation frame interval in milliseconds
         alpha: 1.0,			//the alpha opacity of the confetti (between 0 and 1, where 1 is opaque and 0 is invisible)
         gradient: false,	//whether to use gradients for the confetti particles
         start: null,		//call to start confetti animation (with optional timeout in milliseconds, and optional min and max random confetti count)
         stop: null,			//call to stop adding confetti
         toggle: null,		//call to start or stop the confetti animation depending on whether it's already running
         pause: null,		//call to freeze confetti animation
         resume: null,		//call to unfreeze confetti animation
         togglePause: null,	//call to toggle whether the confetti animation is paused
         remove: null,		//call to stop the confetti animation and remove all confetti immediately
         isPaused: null,		//call and returns true or false depending on whether the confetti animation is paused
         isRunning: null		//call and returns true or false depending on whether the animation is running
         };
         
         (function() {
         confetti.start = startConfetti;
         confetti.stop = stopConfetti;
         confetti.toggle = toggleConfetti;
         confetti.pause = pauseConfetti;
         confetti.resume = resumeConfetti;
         confetti.togglePause = toggleConfettiPause;
         confetti.isPaused = isConfettiPaused;
         confetti.remove = removeConfetti;
         confetti.isRunning = isConfettiRunning;
         var supportsAnimationFrame = window.requestAnimationFrame || window.webkitRequestAnimationFrame || window.mozRequestAnimationFrame || window.oRequestAnimationFrame || window.msRequestAnimationFrame;
         var colors = ["rgba(30,144,255,", "rgba(107,142,35,", "rgba(255,215,0,", "rgba(255,192,203,", "rgba(106,90,205,", "rgba(173,216,230,", "rgba(238,130,238,", "rgba(152,251,152,", "rgba(70,130,180,", "rgba(244,164,96,", "rgba(210,105,30,", "rgba(220,20,60,"];
         var streamingConfetti = false;
         var animationTimer = null;
         var pause = false;
         var lastFrameTime = Date.now();
         var particles = [];
         var waveAngle = 0;
         var context = null;
         
         function resetParticle(particle, width, height) {
         particle.color = colors[(Math.random() * colors.length) | 0] + (confetti.alpha + ")");
         particle.color2 = colors[(Math.random() * colors.length) | 0] + (confetti.alpha + ")");
         particle.x = Math.random() * width;
         particle.y = Math.random() * height - height;
         particle.diameter = Math.random() * 10 + 5;
         particle.tilt = Math.random() * 10 - 10;
         particle.tiltAngleIncrement = Math.random() * 0.07 + 0.05;
         particle.tiltAngle = Math.random() * Math.PI;
         return particle;
         }
         
         function toggleConfettiPause() {
         if (pause)
         resumeConfetti();
         else
         pauseConfetti();
         }
         
         function isConfettiPaused() {
         return pause;
         }
         
         function pauseConfetti() {
         pause = true;
         }
         
         function resumeConfetti() {
         pause = false;
         runAnimation();
         }
         
         function runAnimation() {
         if (pause)
         return;
         else if (particles.length === 0) {
         context.clearRect(0, 0, window.innerWidth, window.innerHeight);
         animationTimer = null;
         } else {
         var now = Date.now();
         var delta = now - lastFrameTime;
         if (!supportsAnimationFrame || delta > confetti.frameInterval) {
         context.clearRect(0, 0, window.innerWidth, window.innerHeight);
         updateParticles();
         drawParticles(context);
         lastFrameTime = now - (delta % confetti.frameInterval);
         }
         animationTimer = requestAnimationFrame(runAnimation);
         }
         }
         
         function startConfetti(timeout, min, max) {
         var width = window.innerWidth;
         var height = window.innerHeight;
         window.requestAnimationFrame = (function() {
         return window.requestAnimationFrame ||
         window.webkitRequestAnimationFrame ||
         window.mozRequestAnimationFrame ||
         window.oRequestAnimationFrame ||
         window.msRequestAnimationFrame ||
         function (callback) {
         return window.setTimeout(callback, confetti.frameInterval);
         };
         })();
         var canvas = document.getElementById("confetti-canvas");
         if (canvas === null) {
         canvas = document.createElement("canvas");
         canvas.setAttribute("id", "confetti-canvas");
         canvas.setAttribute("style", "display:block;z-index:11;pointer-events:none;position:fixed;top:0");
         document.body.prepend(canvas);
         canvas.width = width;
         canvas.height = height;
         window.addEventListener("resize", function() {
         canvas.width = window.innerWidth;
         canvas.height = window.innerHeight;
         }, true);
         context = canvas.getContext("2d");
         } else if (context === null)
         context = canvas.getContext("2d");
         var count = confetti.maxCount;
         if (min) {
         if (max) {
         if (min == max)
         count = particles.length + max;
         else {
         if (min > max) {
         var temp = min;
         min = max;
         max = temp;
         }
         count = particles.length + ((Math.random() * (max - min) + min) | 0);
         }
         } else
         count = particles.length + min;
         } else if (max)
         count = particles.length + max;
         while (particles.length < count)
         particles.push(resetParticle({}, width, height));
         streamingConfetti = true;
         pause = false;
         runAnimation();
         if (timeout) {
         window.setTimeout(stopConfetti, timeout);
         }
         }
         
         function stopConfetti() {
         streamingConfetti = false;
         }
         
         function removeConfetti() {
         stop();
         pause = false;
         particles = [];
         }
         
         function toggleConfetti() {
         if (streamingConfetti)
         stopConfetti();
         else
         startConfetti();
         }
         
         function isConfettiRunning() {
         return streamingConfetti;
         }
         
         function drawParticles(context) {
         var particle;
         var x, y, x2, y2;
         for (var i = 0; i < particles.length; i++) {
         particle = particles[i];
         context.beginPath();
         context.lineWidth = particle.diameter;
         x2 = particle.x + particle.tilt;
         x = x2 + particle.diameter / 2;
         y2 = particle.y + particle.tilt + particle.diameter / 2;
         if (confetti.gradient) {
         var gradient = context.createLinearGradient(x, particle.y, x2, y2);
         gradient.addColorStop("0", particle.color);
         gradient.addColorStop("1.0", particle.color2);
         context.strokeStyle = gradient;
         } else
         context.strokeStyle = particle.color;
         context.moveTo(x, particle.y);
         context.lineTo(x2, y2);
         context.stroke();
         }
         }
         
         function updateParticles() {
         var width = window.innerWidth;
         var height = window.innerHeight;
         var particle;
         waveAngle += 0.01;
         for (var i = 0; i < particles.length; i++) {
         particle = particles[i];
         if (!streamingConfetti && particle.y < -15)
         particle.y = height + 100;
         else {
         particle.tiltAngle += particle.tiltAngleIncrement;
         particle.x += Math.sin(waveAngle) - 0.5;
         particle.y += (Math.cos(waveAngle) + particle.diameter + confetti.speed) * 0.5;
         particle.tilt = Math.sin(particle.tiltAngle) * 15;
         }
         if (particle.x > width + 20 || particle.x < -20 || particle.y > height) {
         if (streamingConfetti && particles.length <= confetti.maxCount)
         resetParticle(particle, width, height);
         else {
         particles.splice(i, 1);
         i--;
         }
         }
         }
         }
         })();
         
         const start = () => {
         setTimeout(function() {
             confetti.start()
         }, 1000); // 1000 is time that after 1 second start the confetti ( 1000 = 1 sec)
         };
         
         //  for stopping the confetti 
         
         const stop = () => {
         setTimeout(function() {
             confetti.stop()
         }, 5000); // 5000 is time that after 5 second stop the confetti ( 5000 = 5 sec)
         };
         // after this here we are calling both the function so it works
         // start();
         // stop();
      </script>
      <style>
         .rainbow {
         left: -35px;
         /* width: 280px; */
         }
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
         .neon-text {
         font-family: 'neon_planetdisplay', Arial, sans-serif;
         color: #fff;
         letter-spacing: 2px;
         text-shadow: 0 0 2px #006aff, 0 0 4px #006aff, 0 0 6px #006aff, 0 0 8px #006aff, 0 0 10px #006aff, 0 0 12px #006aff, 0 0 14px #006aff, 0 0 16px #006aff;
         }
      </style>
      <!-- The Modal -->
      {{--   --}}
      
      @php
    $setting =  \App\Models\GeneralSetting::first();
    $theme = \App\Models\Theme::where('name',$setting->theme)->first();

@endphp
      <div id="myModal" class="modal">
          <div style="background-color: #d2845e; background-image: url(/images/spinnerbackground.png); width:100%; height: 195%;background-position: fixed;background-repeat: no-repeat;background-size: cover;" > 
         <!-- Modal content -->
         <div class="modal-content rainbow">
            <span class="close">&times;</span>
            <div id="modal_main_content" style="font-size:18px!important">
               <center style="font-size:18px!important">
                  <img src="{{asset('images/'.$setting->theme.'/'.$theme->logo)}}"  style="width:100px; "><br><br> 
                  <p class="next-spin animated_rainbow_1" style="font-size:18px!important">
                     Congratulations 
                     <text id='winnerinfolaters' style="font-weight:bold; font-size:16px!important" class="next-spin animated_rainbow_1"></text>
                     you have won the monthly spinner of Handy games
                  </p>
                  <p class="next-spin animated_rainbow_1" style="font-size:18px!important">
                     Please reach out to <b>Handy</b> at messenger for payout with screenshot of win 
                  </p>
                  <p class="next-spin animated_rainbow_1" style="font-size:18px!important">Sincerely</p>
                  <p class="next-spin animated_rainbow_1" style="font-size:18px!important">Handy Games</p>
                  <br>
               </center>
            </div>
         </div>
         </div>
      </div>
      <script>
         // Get the modal
         var modal = document.getElementById("myModal");
         
         // Get the button that opens the modal
         var btn = document.getElementById("myBtn");
         
         // Get the <span> element that closes the modal
         var span = document.getElementsByClassName("close")[0];
         
         // When the user clicks on <span> (x), close the modal
         span.onclick = function() {
           modal.style.display = "none";
         }
         
         //show modal window 
         document.getElementById("myModal").style.display = "none";
         
         //close the modal window when the user clicks outside of it
         window.onclick = function(event) {
           if (event.target == modal) {
             modal.style.display = "none";
           }
         }
         
      </script>
      <style>
         /* The Modal (background) */
         .modal {
         display: none; /* Hidden by default */
         position: fixed; /* Stay in place */
         z-index: 10; /* Sit on top */
         padding-top: 50px; /* Location of the box */
         left: 0;
         top: 0;
         width: 100%; /* Full width */
         height: 100%; /* Full height */
         overflow: auto; /* Enable scroll if needed */
         background-color: rgb(0,0,0); /* Fallback color */
         background-color: rgb(0 0 0 / 30%); /* Black w/ opacity */
         }
         /* Modal Content */
         .modal-content {
         background-color:#ffffff;
         margin: auto;
         padding: 20px;
         border: none;
         max-width: 400px;
         font-size:14px;
         /* color:black; */
         margin-bottom: 100px;
         padding-bottom: 30px;
         border-radius: 0px;
         }
         /* The Close Button */
         .close {
         color: #aaaaaa;
         float: right;
         font-size: 28px;
         margin-top:-10px;
         }
         .close:hover,
         .close:focus {
         color:#2a2a2a;
         text-decoration: none;
         cursor: pointer;
         }
         @import url('https://fonts.cdnfonts.com/css/patrick-hand-sc');
         .next-spin{
         font-family: 'Patrick Hand SC', sans-serif!important;
         }
      </style>
      <img src="/images/curtains.jpg" id="closed_left" />
      <img src="/images/curtains.jpg" id="closed_right" />
      <div id="welcome_container">
         <div id="timer" >
             
            
            <hr>
            <div style="background:black;     border-radius: 10px; padding: 8px 20px; color: white; font-size: 25px;"><span class="next-spin animated_rainbow_1">NEXT SPIN IN</span> <text id="countdown" class=" next-spin animated_rainbow_1" style="font-size:35px"> Loading..</text></div>
           
            <img src="{{asset('images/'.$setting->theme.'/'.$theme->logo)}}" id="mainlogo" style="margin-top: 24%;">
         </div>
      </div>
      </div>
      <script>
         // let formatter = new Intl.DateTimeFormat('en-US', { timeZone: "America/New_York" });
         function getlength(number) {
         return number.toString().length;
         }
         
         function secondsToDhms(seconds) {
         seconds = Number(seconds);
         var d = Math.floor(seconds / (3600*24));
         var h = Math.floor(seconds % (3600*24) / 3600);
         var m = Math.floor(seconds % 3600 / 60);
         var s = Math.floor(seconds % 60);
         
         var dDisplay = d > 0 ? d + (d == 1 ? "d, " : "days, ") : "";
         var hDisplay = h > 0 ? h + (h == 1 ? "h: " : "h: ") : "";
         // var mDisplay = m > 0 ? m + (m == 1 ? "m, " : "m, ") : "";
         var mDisplay = m < 10 ? "0"+m+"m: " : m+"m: ";
         var sDisplay = s > 0 ? s + (s == 1 ? "s" : "s") : "";
         var sDisplay = s < 10 ? "0"+s+"s" : s+"s";
         
         
         return dDisplay + hDisplay + mDisplay + sDisplay;
         }
         
         function convertTZ(date, tzString) {
         return new Date((typeof date === "string" ? new Date(date) : date).toLocaleString("en-US", {timeZone: tzString}));   
         }
         
         
         
             var spinner_date = "{{$spinner_date_new}}";
             var spinner_time = "{{$spinner_time_new}}";
             
             console.log("Date : "+spinner_date);
             console.log("Time : "+spinner_time);
             
             const spinner_time_array= spinner_time.split(":");
         
             
             let d=new Date();
             
             d=convertTZ(d, "America/New_York");
             
            var current_datetimems=d.getTime();
            console.log(d.getTime());
            
         //   if(d.getTime()>=)
         flag_done=false;
         
           if((d.getDate()>=spinner_date)) {
               console.log("current date greater");
               if(d.getDate()==spinner_date) {
                   current_total_seconds=((d.getHours()*3600)+(d.getMinutes()*60)+(d.getSeconds()));
                   console.log("Current : "+current_total_seconds);
                   spinner_total_seconds=((spinner_time_array[0]*3600)+parseInt((spinner_time_array[1]*60))+parseInt((spinner_time_array[2])));
                   console.log("Spinner : "+spinner_total_seconds);
                   if(current_total_seconds>=spinner_total_seconds) {
                       next = new Date(d.getFullYear(), d.getMonth()+1, 1);
                       flag_done=true;
                   }
               }else{
                   next = new Date(d.getFullYear(), d.getMonth()+1, 1);
                       flag_done=true;
               }
           }
            
            if(flag_done==false) {
                 next=new Date(d.getFullYear(), d.getMonth(), 1);
            }
            next= next.setDate(spinner_date);
            
            next_date=new Date(next);
            
            next_date= next_date.setHours(spinner_time_array[0]);
             next_date=new Date(next_date);
            next_date= next_date.setMinutes(spinner_time_array[1]);
             next_date=new Date(next_date);
            next_date= next_date.setSeconds(spinner_time_array[2]);
            
            difference=next_date-current_datetimems;
            
             difference_seconds=difference/1000;
             
         
            to_show=secondsToDhms(difference_seconds);
            
             
             function getCookie(cname) {
         var name = cname + "=";
         var decodedCookie = decodeURIComponent(document.cookie);
         var ca = decodedCookie.split(';');
         for(var i = 0; i < ca.length; i++) {
         var c = ca[i];
         while (c.charAt(0) == ' ') {
         	c = c.substring(1);
         }
         if (c.indexOf(name) == 0) {
         	return c.substring(name.length, c.length);
         }
         }
         return "";
         }
                 
             raised_curtains=false;
             
                 var timeleft = difference_seconds;
                 var downloadTimer = setInterval(function(){
                 timeleft--;
                 document.getElementById("countdown").textContent = secondsToDhms(timeleft);
                 
                 if(timeleft == 10 && raised_curtains==false){
                    raised_curtains=true;
                     setTimeout(function() {
               
                       //remove canvas_main div
                         // document.getElementById("welcome_container").remove();
         
                         //move closed left to the left
                         var closed_left = document.getElementById("closed_left");
                         var closed_left_pos = closed_left.offsetLeft;
                         var closed_left_pos_new = closed_left_pos - 1000;
                         TweenMax.to(closed_left, 3, {left:closed_left_pos_new});
         
                         //move closed right to the right
                         var closed_right = document.getElementById("closed_right");
                         var closed_right_pos = closed_right.offsetLeft;
                         var closed_right_pos_new = closed_right_pos + 1000;
                         TweenMax.to(closed_right, 3, {left:closed_right_pos_new});
               
                     }, 1500);
                     
                     document.getElementById("welcome_container").innerHTML=`
                     <div id="welcome_container">
             
         <div id="timer">
             <text id="countdown" class="next-spin animated_rainbow_1" style="font-size:35px">Get ready..</text>
            </div>
         </div>
         `;
         
         TweenMax.to("#timer", 0.5, {top:"50px"});
                 }
                 
                 if(timeleft == 0){
                     document.getElementById("welcome_container").innerHTML='';
                     document.getElementById("background_static").style.animation = 'none';
                     calculatePrize();
                 }
                 
               },1000);
                
      </script>    
      <style>
         * {
         margin:0; padding: 0; box-sizing: border-box; border: 0;
         }
         .container {
         /*padding:0;*/
         /*margin:20;*/
         display:flex;
         justify-content: center
         flex-flow: row wrap;
         }
         .aside_playing {
         background: rgba(0,0,0,0.6);
         height:100vh;
         flex:0 0 300px;
         }
         .aside_winners {
         background: rgba(0,0,0,0.6);
         height:100vh;
         flex:0 0 300px;
         }
         .center {
         flex:1 0 auto;
         /*background-color: skyblue;*/
         background: rgba(0,0,0,0.6);
         /*height:100vh;*/
         padding-top:20px;
         }
         .container::-webkit-scrollbar { 
         display: none;  /* Safari and Chrome */
         }
         #wheelContainer {
         margin: 0 auto;
         background:red;
         position: relative;
         width: 32vw;
         height: 32vw;
         background: url('https://handy777.net/images/halloin.webp');
         background-size: cover;
         background-position: center;
         background-repeat: no-repeat;
         box-shadow: 0 0 40px #000;
         border-radius: 450px;
         -webkit-transition: 1s ease-in-out;
         -moz-transition: 1s ease-in-out;
         -o-transition: 1s ease-in-out;
         transition: 1s ease-in-out;
         }
         #wheel {
         position: absolute;
         top: 0;
         left: 0;
         /*width: 450px;*/
         /*height: 450px;*/
         }
         #canvas {
         position: relative;
         top: 0;
         left: 0;
         width: 32vw;
         }
         #playing_players_list {
         box-sizing: border-box;  
         padding: 10px 10px 0 10px;
         overflow-y:auto;
         height:100vh;
         }
         #past_winners_list {
         box-sizing: border-box; 
         padding: 10px 10px 0 10px;
         overflow-y:auto;
         height:100vh;
         }
         ::-webkit-scrollbar {
         width: 10px;
         }
         /* Track */
         ::-webkit-scrollbar-track {
         background: rgb(20, 20, 20,0)
         }
         /* Handle */
         ::-webkit-scrollbar-thumb {
         background: #787878;
         border-radius:20px;
         }
         @media screen and (max-width: 600px) {
         .container {
         flex-flow: column wrap;
         }
         #wheelContainer {
         position:relative;
         width:80vw;
         height:80vw;
         }
         #canvas {
         position:relative;
         width:80vw;
         }
         .center {
         margin-top:20px;
         order:1;
         background:rgba(0,0,0,0.4) ;
         /*border:2px solid #de0000;*/
         padding:10px;
         border-radius:5px;
         }
         .aside_playing {
         margin-top:50px;
         order:2;
         background:background:rgba(0,0,0,0.6) ;
         height:initial;
         }
         #playing_players_list {
         height:initial;
         }
         .aside_winners {
         order:3;
         background:background:rgba(0,0,0,0.6) ;;
         }
         body {
         /* background:#0d0d0d; */
         animation:none;
         }
         }
         @media screen and (min-width: 601px) and (max-width: 900px) {
         body {
         /* background:#0d0d0d; */
         animation:none;
         }
         .container {
         flex-flow: column wrap;
         }
         #wheelContainer {
         position:relative;
         width:80vw;
         height:80vw;
         }
         #canvas {
         position:relative;
         width:80vw;
         }
         .center {
         margin-top:20px;
         order:1;
         background:rgba(0,0,0,0.4) ;
         /*border:2px solid #de0000;*/
         padding:10px;
         border-radius:5px;
         }
         .aside_playing {
         margin-top:20px;
         order:2;
         background:background:rgba(0,0,0,0.6) ;;
         }
         .aside_winners {
         order:3;
         background:background:rgba(0,0,0,0.6) ;;
         }
         }
      </style>
      <!--<video autoplay muted loop id="myVideo" style="display:none">-->
      <!--<source src="{{url('images/fin.mp4')}}" type="video/mp4">-->
      <!--    Your browser does not support HTML5 video.-->
      <!--</video>-->
      <div style="background-color: #d2845e; background-image: url(/images/spinnerbackground.png);">
      <div class="container" style="background-color: #d2845e;">
         <div class="aside_playing" style="background-color: #d2845e;">
            <div id="playing_players_list" style="background-color: #d2845e;">
               <strong>
                  <h3 style="margin-left:0px">
                     <b>
                     <span class="next-spin animated_rainbow_1 font-weight-bold" style="font-size:2rem;">Playing players</span>
                     </b>
                  </h3>
               </strong>
               <ul>
                   
                  @if (isset($currentPlayer) && !empty($currentPlayer))
                  <li id="demo" style="background:rgb(162 153 153 / 60%);border:1px solid red;border-radius:5px;padding:5px;margin-bottom:10px;padding:10px;list-style:none;display:flex;justify-content:space-between">
                     <span style="" class="current-player"></span>
                     <span class="next-spin animated_rainbow_1">
                     {{$currentPlayer['player_name']}}
                     </span>
                  </li>
                  @endif
                  @if (isset($row['bool']) && $row['bool'] == 1)
                  <script>
                     var currentKey = '';
                  </script>
                  @endif
                  <?php
                    function maskPlayerName($name) {
                        // Use preg_replace_callback to apply the mask for each word
                        return preg_replace_callback('/\b(\w{3})(\w*)?\b/', function($matches) {
                            // If the word has more than 3 letters, mask the remaining part
                            if (!isset($matches[2]) || empty($matches[2])) {
                                return $matches[1]; // Only return first 3 characters if there are no more letters
                            }
                            // Return the first 3 characters and mask the rest with asterisks
                            return $matches[1] . str_repeat('*', strlen($matches[2]));
                        }, $name);
                    }

                    ?>
                    
                    <!-- JS to set current key if condition matches -->
               @if (isset($player_name)) 
                <li id="demo" style="background:rgba(0,0,0,0.6);border:1px solid red;border-radius:5px;padding:5px;margin-bottom:10px;padding:10px;list-style:none;display:flex;justify-content:space-between">
                     <span style="font-size:20px"> 1</span>
                    
                    
                    <!-- Conditional masking logic -->
                    <span class="next-spin animated_rainbow_1" style="font-size:2rem">
                        {{ $player_name->full_name }}
                    </span>
                </li>
                @endif
                @foreach($final['players_list'] as $key => $row)
                <?php 
                if (isset($player_name) && $player_name->id == $row['player_id']) {
                    continue;
                }
                ?>
                <li id="demo" style="background:rgba(0,0,0,0.6);border:1px solid red;border-radius:5px;padding:5px;margin-bottom:10px;padding:10px;list-style:none;display:flex;justify-content:space-between">
                    {{ $row->full_name }}
                    {{-- <span style="font-size:20px">{{ $key + 2 }}</span> --}}
                    
                    <!-- Mask the player's name if condition is not met -->
                    <span class="next-spin animated_rainbow_1" style="font-size:2rem">
                      
                    </span>
                </li>
            @endforeach

               </ul>
            </div>
         </div>
         @php
         // $settings = 짜App짜Models짜GeneralSetting::first();
         $spinner_date = $settings->spinner_date;
         $spinner_time = $settings->spinner_time;
         $date_today = date('d');
         $time = date('H:i:s');
         if($spinner_date < 10){
         $spinner_date = '0'.$spinner_date;
         }         
         $year = date('Y');
         $month = date('m');
         if($month < 10){
         $month = '0'.$month;
         }
         // $spinner_date = 23;
         $day = $spinner_date;
         $full_date = $year.'-'.$month.'-'.$day.' '.$spinner_time;    
         $full_date_now = date('Y-m-d H:i:s');
         if($month == 12){
         $month = 0;
         }
         $new_month = $month + 1;
         if($new_month < 10){
         $new_month = '0'.$new_month;
         }
         $next_full_date = $year.'-'.($new_month).'-'.$day.' '.$spinner_time;  
         @endphp
         <script>    
            var countDownDate = '{{$full_date}}';
            var nextfullDate = '{{$next_full_date}}';
            var fullDateNow = '{{$full_date_now}}';
         </script>
         <div class="center" style="background-color: #d2845e;">
            @if($date_today == $spinner_date)
            @php  
            $spinner_time_count = strtotime($spinner_time);      
            $actual_time_count = strtotime($time);                            
            @endphp
            @if($spinner_time_count < $actual_time_count)  
            <!--<p id="countdown" class="neon-text2"></p>               -->
            <!--<button id="bigButton" class="hidden bigButton" onclick="calculatePrize(); this.disabled=true;" style="color:red;border: 2px solid red; border-radius:5px; padding: 10px;">-->
            <!--    Spin the Wheel-->
            <!--</button>-->
            @else                       
            <!--<p id="countdown" class="neon-text2"></p>-->
            {{-- hidden --}}
            <!--<button class="hidden bigButton spinnerClickBtn" onclick="calculatePrize(); this.disabled=true;" style="color:red;border: 2px solid red; border-radius:5px; padding: 10px;">-->
            <!--    Spin the Wheel-->
            <!--</button>-->
            @endif
            @else
            @if($date_today > $spinner_date)
            @php
            $full_date = $year.'-'.($month + 1).'-'.$day.' '.$spinner_time; 
            @endphp
            <script>
               countDownDate = '{{$full_date}}';
            </script>
            <!--<p id="countdown" class="neon-text2"></p>-->
            <!--<button class="hidden bigButton spinnerClickBtn" onclick="calculatePrize(); this.disabled=true;" style="color:red;border: 2px solid red; border-radius:5px; padding: 10px;">-->
            <!--    Spin the Wheel-->
            <!--</button>-->
            @else
            <!--<p id="countdown" class="neon-text2"></p>-->
            <!--<button class="hidden bigButton spinnerClickBtn" onclick="calculatePrize(); this.disabled=true;" style="color:red;border: 2px solid red; border-radius:5px; padding: 10px;">-->
            <!--    Spin the Wheel-->
            <!--</button>-->
            @endif
            @endif  
            {{-- 
            <div id="winnerinfo" style="background-color: #d2845e;"></div>
            --}}
            <div id="wheelContainer" style="background-color: #d2845e;">
               <div id="wheel">
                  <!--<div class="canvas">-->
                  <canvas id="canvas" width="500" height="500">
                  </canvas>
                  <!--</div>-->
               </div>
            </div>
            <!--<div class="text-center pt-3">-->
            <!--   <h6>-->
            <!--      <b>-->
            <!--      <span class="next-spin animated_rainbow_1 font-weight-bold" style="font-size:2rem;">Copyright HandyGames</span>-->
            <!--      <span class="next-spin animated_rainbow_1" style="font-size:2rem;"> 2022</span><br> <span class="next-spin animated_rainbow_1" style="font-size:2rem;"> All Rights Reserved</span>-->
            <!--      </b>-->
            <!--   </h6>-->
            <!--</div>-->
         </div>
         <div class="aside_winners" style="background-color: #d2845e;">
            <div id="past_winners_list" style="background-color: #d2845e;">
               <strong>
                  <h3 style="margin-left:0px">
                     <b>
                     <span class="next-spin animated_rainbow_1 font-weight-bold" style="font-size:2rem;"></span>
                     </b>
                  </h3>
               </strong>
               
            </div>
         </div>
      </div>
      </div>
      <script></script>
      <!-- Jquery JS-->
      <script src="{{asset('js/jquery.min.js')}}"></script>
      <script src="https://ajax.aspnetcdn.com/ajax/jquery.validate/1.11.1/jquery.validate.min.js"></script>
      <!--<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>-->
      <!-- Vendor JS-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.3/moment.min.js"></script>
      <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
      <!-- Main JS-->
      <script src="js/global.js"></script>
      <!--<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>-->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
      <script src="https://kit.fontawesome.com/a26d9146a0.js" crossorigin="anonymous"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <!--   Core JS Files   -->
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <script src="{{asset('public/js/jquery-input-mask-phone-number.min.js')}}"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
      <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.jqueryui.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.jqueryui.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script> 
      <script src="{{asset('public/js/core/popper.min.js')}}"></script>
      <script src="{{asset('public/js/core/bootstrap.min.js')}}"></script>
      <script src="{{asset('public/newAdmin/js/plugins/perfect-scrollbar.min.js')}}"></script>
      <script src="{{asset('public/newAdmin/js/plugins/smooth-scrollbar.min.js')}}"></script>
      <script src="{{asset('public/newAdmin/js/plugins/chartjs.min.js')}}"></script>
      <script src="{{asset('public/js/core/bootstrap.min.js')}}"></script>
      <!--<script src="{{asset('public/newAdmin/js/argon-dashboard.min.js')}}"></script>-->
      <script src="{{asset('js/editable.js')}}"></script>
      {{-- <script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
      <script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
      <script src="../../public/js/plugins/bootstrap-notify.js"></script>
      <script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script> --}}
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
      <script src="{{asset('public/js/demo.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script src="{{asset('public/js/table.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
      <script src="{{asset('public/js/jquery-input-mask-phone-number.min.js')}}"></script>
      <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.11.4/jquery-ui.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.js"></script>
      <script type="text/javascript" src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.js"></script>
      <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.66/vfs_fonts.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/dataTables.jqueryui.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.jqueryui.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.colVis.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.flash.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.html5.js"></script>
      <script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/buttons.print.js"></script> 
      <script src="{{asset('public/js/core/popper.min.js')}}"></script>
      <script src="{{asset('public/js/core/bootstrap.min.js')}}"></script>
      <script src="{{asset('public/newAdmin/js/plugins/perfect-scrollbar.min.js')}}"></script>
      <script src="{{asset('public/newAdmin/js/plugins/smooth-scrollbar.min.js')}}"></script>
      <script src="{{asset('public/newAdmin/js/plugins/chartjs.min.js')}}"></script>
      <script src="{{asset('public/js/core/bootstrap.min.js')}}"></script>
      <!--<script src="{{asset('public/newAdmin/js/argon-dashboard.min.js')}}"></script>-->
      <script src="{{asset('js/editable.js')}}"></script>
      {{-- <script src="../../public/js/core/popper.min.js" type="text/javascript"></script>
      <script src="../../public/js/core/bootstrap.min.js" type="text/javascript"></script>
      <script src="../../public/js/plugins/bootstrap-notify.js"></script>
      <script src="../../public/js/light-bootstrap-dashboard790f.js" type="text/javascript"></script> --}}
      <script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote.min.js"></script>
      <script src="{{asset('public/js/demo.js')}}"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
      <script src="{{asset('public/js/table.js')}}"></script><script src="{{asset('public/js/jquery.mCustomScrollbar.js')}}"></script>
      <script>
         $(document).ready(function(){
             $('.current-player').text(currentKey);
         });
         var img1 = new Image();
         var img2 = new Image();
         img1.src = "{{asset('/public/img/casino ring 2.png')}}";
         img2.src = "{{asset('/public/img/casinoring0.png')}}";
         
         var countDownDate = new Date(countDownDate).getTime();
         // console.log(fullDateNow);
         // console.log((new Date()));
         
         function checkTime(i) {
             if (i<10) {i = "0" + i};  // add zero in front of numbers < 10
             return i;
         }
         var today=new Date('<?php echo $carbon_now.'   ('.config('app.timezone').')' ?>');
         var time = '';
         $(document).ready( function () {
             // Set the date we're counting down to
             function setTime() {
                 today.setSeconds(today.getSeconds()+1);
                 var year=today.getFullYear();
                 var month=today.getMonth() + 1;
                 var day=today.getDate();
                 var hour=today.getHours();
                 var minute=today.getMinutes();
                 var second=today.getSeconds();
                 // console.log(month);
                 minute = checkTime(minute);
                 second = checkTime(second);
                 month = checkTime(month);
                 time = year+"-"+month+"-"+day+" "+hour+":"+minute+":"+second;
             }
             setInterval(setTime, 1000);
         
             var x = setInterval(function() {
               // Get today's date and time
               var now = new Date(time).getTime();
             
               // Find the distance between now and the count down date
               var distance = countDownDate - now;
             
               // Time calculations for days, hours, minutes and seconds
               var days = Math.floor(distance / (1000 * 60 * 60 * 24));
               var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
               var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
               var seconds = Math.floor((distance % (1000 * 60)) / 1000);
             
               // Display the result in the element with id="countdown"
             //   document.getElementById("countdown").innerHTML = days + "d " + hours + "h "
             //   + minutes + "m " + seconds + "s ";
             
               // If the count down is finished, write some text
               if (distance < 0) {
                 // document.getElementById("countdown").innerHTML = "Next Spinner will be on";
                 $('.spinnerClickBtn').trigger('click');
                 countDownDate = new Date(nextfullDate).getTime();
               }
             }, 1000);
         
             $('.captcha-input').on('keypress',function(e) {
                 if(!($('.captcha-error').hasClass('hidden'))){
                     $('.captcha-error').addClass('hidden');
                 }
             });
         
         
             $('.submit-btn').on('click',function(e) {
                 console.log('clicked');
                 e.preventDefault();
                 var form = $('#regForm');
         
                 if($('input[name="full_name"]').val() == '') {
                     toastr.error('Error','Enter Full Name');
                     return;
                 }
                 if($('input[name="number"]').val() == '') {
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
         
         // 
         
         playerArray=[];
         
         playerArray['player_info']=[{
                 id:"1",
                 name:"Prasil"
             },
             {  
                 id:"2",
                 name:"Gaurav"
             },
             {
                 id:"3",
                 name:"Prasun"
             }
         ]
         
         playerArray['winner_info'] = [{
             id:"2",
             name:"Prasil",
             }
         ]
         
         
         
         var jsonData = JSON.parse('<?= $final_encoded; ?>');
         var jsonArray=<?= $final_encoded; ?>;
         
         console.log(jsonArray);
         
         // console.log(jsonData);
         
         var res = [];
         var res_winner = [];
         
         
         //build array for segments for wheel
         var segments = [];
         index=0;
         counter=1;
         
         
         //console.log(res);
         jsonData.players_list.forEach(element => {
         //console.log(element);
         //create an array of random fill colors
         var fillColor = ['#000000','#005f2d','#cc2828'];
                     
         if (index>=fillColor.length) {
             index=0;
         }
         
         canvasCenter=250;
         
         let canvas = document.getElementById('canvas');
                     let ctx = canvas.getContext('2d');
                     let radGradient = ctx.createRadialGradient(canvasCenter, canvasCenter, 50, canvasCenter, canvasCenter, 250);
                     
           radGradient.addColorStop(0, "#ccbe00");
                     radGradient.addColorStop(0.5, fillColor[index]);
                     index++;
         
          if(player_info_length<10) textFontSize= 50;
         else if(player_info_length<30) textFontSize=15;
         else if(player_info_length<80) textFontSize=10;
         else textFontSize=10;
         textFontSize=12;
         
         segments.push({
             fillStyle:radGradient,
             offset: 1.0,
             text: ""+counter++,
             lineWidth: 1,
             'strokeStyle' : '#ccbe00',
             // 'textFontFamily' : 'Georgia',
             'textAlignment' : 'outer',
             // 'textOrientation' : 'curved',
             'textFontSize'    : textFontSize,
             'textFillStyle'   : '#ffee00'
             // text: element.player_name
             });
         });
         
         //get the array length of player_info
         var player_info_length = jsonData.players_list.length;
         
         //get id from winner info and compare with player info
         var winner_info_id = jsonData.winner_info.player_id;
         
         // document.getElementById("winnerinfo").innerHTML = "<br>winner will be "+jsonData.winner_info.player_name;
         document.getElementById("winnerinfolaters").innerHTML = jsonData.winner_info.player_name;
         
         //get the index of winner info id
         var winner_info_index = jsonData.players_list.findIndex(x => x.player_id == winner_info_id);
         
         //console.log(jsonData.winner_info);
         
         
         // //convert the player array into a json string
         // playerArray = JSON.stringify(playerArray);
         
         // //convert the json string into an object
         // playerArray = JSON.parse(playerArray);
         
         
         //170 default radi
         
         textSize=10;
         textFontSize=10;
         
         if(player_info_length<10) textFontSize= 10;
         else if(player_info_length<30) textFontSize=10;
         else if(player_info_length<80) textFontSize=10;
         else textFontSize=10;
         
         spin_duration=randomIntFromInterval(10,20); //make spin time random
         spin_times=randomIntFromInterval(3,6);
         
         let theWheel = new Winwheel({
            'numSegments'    : player_info_length,
             'innerRadius'   : 80,   
             'outerRadius'    : 240,
             'segments'       : segments,
             'textFontSize' : textFontSize,
             'textMargin'     : 10, 
             'animation' :
             {
                 'type'          : 'spinToStop',
                 'duration'      : 10,
                 'spins'         : 5,
                 'callbackAfter' : 'drawTriangle()',
                 'callbackSound' : playSound,
                 'callbackFinished' : 'winAnimation()'
             }
             // 'pins' :    // Specify pin parameters.
             // {
             //     'number'      : player_info_length*2,
             //     'outerRadius' : 5,
             //     'margin'      : 10,
             //     'fillStyle'   : '#c28942',
             //     'strokeStyle' : '#c28942'
             // }
         });
         
         let audio = new Audio('assets/tick.mp3');  // Create audio object and load desired file.
         
         function showWinnerInfo() {
         document.getElementById("myModal").style.display = "block";
         }
         
         function winAnimation() {
             start();
                 
             document.getElementById('wheelContainer').style.transform = 'scale(1)';
                 document.getElementById('wheelContainer').style.top = '20px';
                 
                 
             // Get the number of the winning segment.
             let winningSegmentNumber = theWheel.getIndicatedSegmentNumber();
         
             // Loop and set fillStyle of all segments to gray.
             for (let x = 1; x < theWheel.segments.length; x ++) {
                 theWheel.segments[x].fillStyle = '#171717';
                 //remove stroke
                 theWheel.segments[x].strokeStyle = '#171717';
                 //change font color
                 theWheel.segments[x].textFillStyle = '#3b3b3b';
             }
         
             // Make the winning one yellow.
             theWheel.segments[winningSegmentNumber].fillStyle = '#00ab51';
             //change font color to black 
             theWheel.segments[winningSegmentNumber].textFillStyle = '#ffee00';
             //change stroke color to black
             theWheel.segments[winningSegmentNumber].strokeStyle = '#00ab51';
         
             // Call draw function to render changes.
             theWheel.draw();
         
             // Also re-draw the pointer, otherwise it disappears.
             drawTriangle();
             
             showWinnerInfo();
             
             setTimeout(function(){
                 document.getElementById("welcome_container").innerHTML='Concluded. Congratulations ..';
                 
                 
                 
         
                         //move closed left to the left
                         var closed_left = document.getElementById("closed_left");
                         var closed_left_pos = closed_left.offsetLeft;
                         var closed_left_pos_new = closed_left_pos + 1000;
                         TweenMax.to(closed_left, 3, {left:closed_left_pos_new});
         
                         //move closed right to the right
                         var closed_right = document.getElementById("closed_right");
                         var closed_right_pos = closed_right.offsetLeft;
                         var closed_right_pos_new = closed_right_pos - 1000;
                         TweenMax.to(closed_right, 3, {left:closed_right_pos_new});
                         
                         
                         setTimeout(function(){
                             window.location.reload();
                         }, 5000);
             },10000);
         }
         
         function generateRandomColor(){
             // let color = "#";
             // for (let i = 0; i < 3; i++){
             //     color += ("0" + Math.floor(((1 + Math.random()) * Math.pow(16, 2)) / 2).toString(16)).slice(-2);
             // }
             let color = "#"+Math.floor(Math.random()*16777215).toString(16);
             return color;
         }
         
         function randomIntFromInterval(min, max) { // min and max included 
             return Math.floor(Math.random() * (max - min + 1) + min)
         }
         
         function playSound() {
             // Stop and rewind the sound (stops it if already playing).
             audio.pause();
             audio.currentTime = 0;
         
             // Play the sound.
             audio.play();
         }
         
         // Function with formula to work out stopAngle before spinning animation.
         // Called from Click of the Spin button.
         function calculatePrize(winner_info=winner_info_index) {
             // console.log("Winner is"+winner_info);
             // Get random angle inside specified segment of the wheel.
             let stopAt = theWheel.getRandomForSegment(winner_info_index+1);
         
             // Important thing is to set the stopAngle of the animation before stating the spin.
             theWheel.animation.stopAngle = stopAt;
             
             setTimeout(function(){
                 document.getElementById('wheelContainer').style.transform = 'scale(1.5)';
                 document.getElementById('wheelContainer').style.top = '200px';
             }, 6000);
             
             theWheel.draw();
         
             // Start the spin animation here.
             theWheel.startAnimation();
         }
         
         // Usual pointer drawing code.
         drawTriangle();
         
         function drawTriangle() {
             // Get the canvas context the wheel uses.
             let ctx = theWheel.ctx;
         
             ctx.strokeStyle = '#ccbe00';     // Set line colour.
             ctx.fillStyle   = '#ccbe00';     // Set fill colour.
             ctx.lineWidth   = 3;
             ctx.beginPath();              // Begin path.
             ctx.moveTo(250, 10);           // Move to initial position.
             ctx.lineTo(250, 0);           // Draw lines to make the shape.
             ctx.lineTo(250, 20);
             ctx.lineTo(250, 10);
             ctx.stroke();                 // Complete the path by stroking (draw lines).
             ctx.fill();                   // Then fill
         }
         
         // $(document).ready( function () {
         //     $('.datatable').DataTable({
         //         pageLength: 100,
         //         dom: "<'row'<'col-sm-2'l><'col-sm-7 text-center'B><'col-sm-3'f>>tipr",
         //         buttons: [
         //         {
         //            extend: 'copy',
         //            className: 'btn-sm btn-info',
         //            title: 'Gamers',
         //            header: false,
         //            footer: true,
         //            exportOptions: {
         //               // columns: ':visible'
         //            }
         //         },
         //         {
         //            extend: 'csv',
         //            className: 'btn-sm btn-success',
         //            title: 'Gamers',
         //            header: false,
         //            footer: true,
         //            exportOptions: {
         //               // columns: ':visible'
         //            }
         //         },
         //         {
         //            extend: 'excel',
         //            className: 'btn-sm btn-warning',
         //            title: 'Gamers',
         //            header: false,
         //            footer: true,
         //            exportOptions: {
         //               // columns: ':visible',
         //            }
         //         },
         //         {
         //            extend: 'pdf',
         //            className: 'btn-sm btn-primary',
         //            title: 'Gamers',
         //            pageSize: 'A2',
         //            header: false,
         //            footer: true,
         //            exportOptions: {
         //               // columns: ':visible'
         //            }
         //         },
         //         {
         //            extend: 'print',
         //            className: 'btn-sm btn-success',
         //            title: 'Gamers',
         //            // orientation:'landscape',
         //            pageSize: 'A2',
         //            header: true,
         //            footer: false,
         //            orientation: 'landscape',
         //            exportOptions: {
         //               // columns: ':visible',
         //               stripHtml: false
         //            }
         //         }
         //      ],
         //     });
         // } );
         
         jQuery(document).ready( function () {
         
             $(".jquery-width").css("width","100%");
         
             var link = $('.delete-form').attr("href");
             // var link = $('.delete-form');
             $('.datatable tbody').on('click', '.delete-form', function (e) {
                 e.preventDefault();
                 Swal.fire({
                     title: 'Are you sure you want to delete this?',
                     showDenyButton: true,
                     showCancelButton: true,
                     showConfirmButton: false,
                 // confirmButtonText: 'Save',
                 denyButtonText: `Delete`,
             }).then((result) => {
                 if (result.isConfirmed) {
                 } 
                 else if (result.isDenied) {
                     var cid = $(this).data('id');
                     $.ajax({
                         type: 'get',
                         url: "/gamers/destroy/"+cid,
                         data: {
                             "cid": $(this).data('id'),
                         },
                         dataType: 'json',
                         success: function (data) {
                             console.log(data);
                             $('.tr-'+cid).remove();
                             $( ".count-row" ).each(function( index ) {
                                 $(this).text((index+1));
                                     // console.log( index + ": " + $( this ).text() );
                                 })
                             toastr.success('Success',"Deleted"); 
                         },
                         error: function (data) {
                             console.log(data);
                             toastr.error('Error',data.responseText);
                         }
                     });
                         // window.location = link;
                     }
                 });
             });
         
             $('.datatable tbody').on('click', '.edit-form', function () {
                 $('.editFormModal').modal('show');
                 var cid = $(this).data('id');
                 $.ajax({
                     type: 'get',
                     url: "/gamers/edit/"+cid,
                     data: {
                         "cid": $(this).data('id'),
                     },
                     dataType: 'json',
                     success: function (data) {
                         // console.log(data);
                         $('.appendHere').remove();
                         $('.editFormModalBody').append('<div class="appendHere"></div>');
                         $('.appendHere').append(data);
                         // $('#summernote').summernote();
                         // $( ".count-row" ).each(function( index ) {
                             // $(this).text((index+1));
                             // console.log( index + ": " + $( this ).text() );
                         // })
                         // toastr.success('Success',"Deleted");
                         
                     },
                     error: function (data) {
                         console.log(data);
                         toastr.error('Error',data.responseText);
                     }
                 });
             });
             $(".player-list, .player-list2").mCustomScrollbar({
               axis:"yx"
             });
         });
         
         x = '<?php echo $carbon_now.'   ('.config('app.timezone').')' ?>';
         // console.log(x);
         //   var dateTime = new Date();
         var weekday=new Array(7);
         weekday[0]="Sunday";
         weekday[1]="Monday";
         weekday[2]="Tuesday";
         weekday[3]="Wednesday";
         weekday[4]="Thursday";
         weekday[5]="Friday";
         weekday[6]="Saturday";
         
         var monthNames=new Array(7);
         monthNames[0]="January";
         monthNames[1]="February";
         monthNames[2]="March";
         monthNames[3]="April";
         monthNames[4]="May";
         monthNames[5]="June";
         monthNames[6]="July";
         monthNames[7]="August";
         monthNames[8]="September";
         monthNames[9]="October";
         monthNames[10]="November";
         monthNames[11]="December";
         
         var  dateTime = new Date(x);
         var dayName = weekday[dateTime.getDay()];
         var monthName2 = monthNames[dateTime.getMonth()];
         //   console.log(dateTime.getFullYear());
         //   console.log(monthNames[dateTime.getMonth()]);
         var hour, hourTemp, minute, minuteTemp, second, secondTemp, monthnumber, monthnumberTemp, monthday, monthdayTemp, year, ap;
         function timefunction() {
             dateTime.setSeconds(dateTime.getSeconds() + 1, 0);
             hourTemp = hour = dateTime.getHours();
         
             minuteTemp = minute = dateTime.getMinutes();
             if (minute.toString().length == 1)
                 minuteTemp = "0" + minute.toString();
         
             secondTemp = second = dateTime.getSeconds();
             if (second.toString().length == 1)
                 secondTemp = "0" + second.toString();
         
             monthnumberTemp = monthnumber = dateTime.getMonth();
             if ((monthnumber + 1).toString().length == 1)
                 monthnumberTemp = "0" + (monthnumber + 1).toString();
         
             monthdayTemp = monthday = dateTime.getDate();
             if (monthday.toString().length == 1)
                 monthdayTemp = "0" + monthday.toString();
             year = dateTime.getFullYear();
             // console.log(dateTime.getYear());
             ap = "AM";
             if (hour > 11) { ap = "PM"; }
             if (hour > 12) { hour = hour - 12; }
             if (hour == 0) { hour = 12; }
             if (hour.toString().length == 1)
                 hourTemp = "0" + hour.toString();
             $('.date-div').text(dayName + ", "+monthdayTemp+" " + monthName2 + "," + year );
                
             $('.date-countdown').text(hourTemp + " : " + minuteTemp + " : " + secondTemp + " " + ap);
                 // document.getElementById('time').innerHTML = monthnumberTemp + "/" + monthdayTemp + "/" + year + " " + hourTemp + ":" + minuteTemp + ":" + secondTemp + " " + ap;
             }
             timefunction();
             setInterval("timefunction()", 1000);
      </script>
      @if (isset($activeGame) && ($activeGame['image'] != ''))
      <script>
         $('.back-image-game').css('background-image',"url('public/uploads/{{$activeGame['image']}}')");
      </script>
      @else
      <script>
         $('.back-image-game').css('background-color','#ffb342');
      </script>
      @endif
      <script>
         $(function(){
             $('#phone-number').usPhoneFormat({
                 format:'xxx-xxx-xxxx'
             });
             $('#summernote').summernote();
             $('.select2').select2({
             // dropdownParent: $('#popup3')
         });
         });
      </script>
      @if (session('success'))
      <script>
         toastr.success('{{ session('success') }}');
      </script>
      @endif
      @if (session('error'))
      @if(is_array(session('error')))
      @foreach(session('error') as $error)
      <script>
         toastr.error(' {{ $error }}');
      </script>
      @endforeach
      @else    
      <script>
         toastr.error(' {{session('error') }}');
      </script>
      @endif
      @endif
   </body>
   <?php
      //check if current date is equal to sample date
      $sample_date="2022-06-01 00:00:00";
      $current_date=date("Y-m-d H:i:s");
      
      //check if current date is equal to sample date
      if($current_date==$sample_date)
      {
          ?>
   <script>
      //calculatePrize();
   </script>
   <?php
      }
      else
      {
         //show javascript countdown
          echo "<div id='datebox' style='display:none'></div>";
      }
      ?>
   <script>
      //countown from sample date to current date
      var sample_date = new Date("<?php echo $sample_date; ?>");
      var current_date = new Date("<?php echo $current_date; ?>");
      var diff = sample_date.getTime() - current_date.getTime();
      var days = Math.floor(diff / (1000 * 60 * 60 * 24));
      var hours = Math.floor((diff % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      var minutes = Math.floor((diff % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((diff % (1000 * 60)) / 1000);
      
      //show live countdown 
      document.getElementById("datebox").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
      
      //countdown timer
      setInterval(function () {
          seconds--;
          if (seconds < 0) {
              minutes--;
              seconds = 59;
          }
          if (minutes < 0) {
              hours--;
              minutes = 59;
          }
          if (hours < 0) {
              days--;
              hours = 23;
          }
          if (days < 0) {
              days = 0;
          }
          document.getElementById("datebox").innerHTML = days + "d " + hours + "h " + minutes + "m " + seconds + "s ";
      }, 1000);
      
      setTimeout(function() {
        $('.outer-curtain').remove();
        $('video').show();
      }, 4000);
   </script>