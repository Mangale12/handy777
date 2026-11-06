@extends('frontend.cloud.main')
@section('title', 'Registration')
@section('content')
<style>
    @import url('https://fonts.cdnfonts.com/css/sun-flower-2');
    @import url('https://fonts.cdnfonts.com/css/hombo');
    @import url('https://fonts.cdnfonts.com/css/judera-ring');
    @import url('https://fonts.cdnfonts.com/css/paperkind');
   
</style>
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
                          .next-spin-p{
                            font-size: 41px;
                            margin: 0 -25px;
                          }
                          .text-class{
                            font-size: 28px;
                            width: 116%;
                            margin-left: -35px;
                            display: block;
                          }
                        }
                        
                @media (min-width: 1200px) 
                  {
                      .card-1{
                          width: 164%;
                          right: 34%;
                        }
                         .logo{
                          width: 402px;
                          align-items: center;
                          margin-left : 27%;
                          position: relative;
                          }
                          
                  }
                        </style>
<div class="page-wrapper font-robo">
    <div class="wrapper wrapper--w680">
        <div class="card card-1 py-5">
            <!--<div class="card-heading">  -->
            <!--</div>-->
          <div>
                <h2 class="font-weight-bold text-center animated_rainbow_1 next-spin-p" >
                    Platform we have
                </h2>
            </div>
            <div class="card-body">
                <div style="text-align:center">
                    <h3 style="line-height:2rem;">
                            <span class="font-weight-bold animated_rainbow_1 text-class" > Unlock exclusive benefits by registering today. Don't wait, seize the opportunity now.!</span> 
                    </h3>
                </div>
                <!--<img src="{{ URL::to('/images/polacy.png') }}" width="500" height="600">-->


              @php
                    $setting = \App\Models\GeneralSetting::first();
                    $theme = \App\Models\Theme::where('name',$setting->theme)->first();
                @endphp
                 <div class = "text-center logo">
                      <img src="{{ asset('images/'.$setting->theme.'/'.$theme->logo) }}" width="220" height="250" class="w-auto" style="max-width:25%;">
                </div>
            </div>

            <div class="catagory-tab nav nav-tabs" id="myTab" role="tablist">
   <!--<button class="nav-link btn btn-primary gallery-btn active" id="a-tab" data-toggle="tab" data-target="#a"-->
   <!--   type="button" role="tab" aria-controls="a" aria-selected="true">All</button>-->
   <!--<button class="nav-link btn btn-primary gallery-btn" id="b-tab" data-toggle="tab" data-target="#b"-->
   <!--   type="button" role="tab" aria-controls="b" aria-selected="false">Firekirin</button>-->
   <!--<button class="nav-link btn btn-primary gallery-btn" id="c-tab" data-toggle="tab" data-target="#c"-->
   <!--   type="button" role="tab" aria-controls="c" aria-selected="false">MilkyWay</button>-->
   <!--<button class="nav-link btn btn-primary gallery-btn" id="d-tab" data-toggle="tab" data-target="#d"-->
   <!--   type="button" role="tab" aria-controls="d" aria-selected="false">Riversweep</button>-->
   <!--<button class="nav-link btn btn-primary gallery-btn" id="e-tab" data-toggle="tab" data-target="#e"-->
   <!--   type="button" role="tab" aria-controls="e" aria-selected="false">Xgames</button>-->
   <!--<button class="nav-link btn btn-primary gallery-btn" id="f-tab" data-toggle="tab" data-target="#f"-->
   <!--   type="button" role="tab" aria-controls="f" aria-selected="false">Juwa</button>-->
</div>
<div style="display: flex; justify-content:center;">
   <h1 class="animated_rainbow_1">Our Games</h1>
</div>
<div class="gallery-section" id="gallery">
   <div class="tab-content" id="myTabContent">
      <div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="a-tab">
         <div class="row p-3">
             @php
             $games = App\Models\Account::get();
             @endphp
             @foreach($games as $game)
             @if($game->status == "active")
            <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">
               <div class="image h-100">
                  <img class="gallery-img" src="{{ asset('public/uploads/'.$game->image)}}" style="height:278px;">
                  <div class="overlay position-absolute">
                     <a href="{{ $game->game_url }}">
                        <h6 class="animated_rainbow_1">Click to download</h6>
                     </a>
                  </div>
               </div>
            </div>
            @endif
            @endforeach
            
         </div>
      </div>
   
</div>
<!--our game end-->
               <div class="text-center pt-3">
                  <h4 style="font-size:1.6rem"><b><span class="font-weight-bold animated_rainbow_1 next-spin" style="font-size:1.6rem">Copyright AB Gaming</span> <span class="animated_rainbow_1 next-spin" style="font-size:1.6rem">© 2023</span> <span class="animated_rainbow_1 next-spin" style="font-size:1.6rem"> All Rights Reserved</span><b></h4>
               </div>
            </div>
         </div>
      </div>
   </div>
</div>
                <div class="text-center pt-3">
                    <h4><b><span class="animated_rainbow_1 next-spin">Copyright AB Gaming</span> <span class="janimated_rainbow_1 next-spin">© 2021</span> <span class="animated_rainbow_1 next-spin"> All Rights Reserved</span><b></h4>
                </div>
        </div>
    </div>
</div>
@endsection
