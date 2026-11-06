@extends('newLayout.layouts.newLayout')

@section('title')
    Games
@endsection
@section('content')
@php
    use Carbon\Carbon;
@endphp
<style>
     td{
            border: none;
        }
    .count-row{
        font-weight: 700;
    }
    .name-td,.status-td{
      text-transform:capitalize;
    }
</style>
<div class="row justify-content-center">
            <div class="col-md-12 card">
                <div class="card-body">
                
           
                

                <style>
                    /*Martin Css*/

                .image-wrap {
                    position: relative;
                }

                .overlay {
                    top: 50%;
                    left: 50%;
                    transform: translate(-50%, -50%);
                    display: none;
                    border-radius: 4px;
                }

                .overlay a {
                    text-decoration: none;
                    padding: 10px;
                    display: inline-block;
                    background-image: none;
                }

                .overlay .animated_rainbow_1 {
                    font-size: 1.4rem !important;
                    margin: 0;
                }

                .image-wrap:hover .overlay {
                    display: block;
                    cursor: pointer;
                    background: rgba(0, 0, -10, 0.6);
                }

                .image-wrap:hover .gallery-image {
                    transform: scale(0.9)
                }

                .gallery-section {
                    /* border: 1px solid black; */
                    /*display: grid;*/
                    /*grid-template-columns: auto auto auto;*/
                    /*gap: 2rem;*/
                    /*margin-bottom: 5rem;*/
                    /*margin-left: 2rem;*/
                    /*margin-right: 2rem;*/
                }

                .gallery-img {
                    width: 100%;
                    height: auto;
                    border-radius: 1rem;
                }

                .catagory-tab {
                    display: flex;
                    /* justify-content: left; */
                    gap: 1rem;
                    flex-wrap: unset;
                    margin: 0 2rem 2rem 2rem;
                    border: unset;
                }

                .catagory-tab button {
                    border-radius: 20px !important;
                    margin-top: 5px;
                }

                @media (max-width: 450px) {
                    .gallery-img {
                        height: 250px;
                    }
                    .overlay {
                        display: block;
                        cursor: pointer;
                        background: rgba(0, 0, -10, 0.6);
                    }
                }

                @media (max-width: 768px) {
                    .gallery-img {
                        height: 300px;
                    }
                }

                /*Martin Css*/

                body {
                    margin: 0;
                }

                #main-container {
                    display: flex;
                    flex-direction: column;
                    /* border: 1px solid black; */
                    /*margin: 0 5rem 0 5rem ;*/
                    gap: 5rem;
                    align-items: center;
                    text-align: center;
                    color: aliceblue;
                    background: rgba(0, 0, -10, 0.6);
                }

                .text-area {
                    /* border: 1px solid black; */
                    display: flex;
                    justify-content: center;
                    flex-direction: column;
                    align-items: center;
                    /* padding-top: 8rem; */
                }

                .profile-area {
                    margin-bottom: 5rem;
                }

                .form-wrapper {
                    display: flex;
                    flex-direction: column;
                    background: rgba(0, 0, -10, 0.6);
                    align-items: center;
                    /*margin-top: 8rem;*/
                    padding-top: 3rem;
                }

                .form-area {
                    display: flex;
                    /* border: 1px solid black; */
                    /* height: 25rem; */
                    justify-content: space-evenly;
                    text-align: initial;
                    gap: 1rem;
                    margin-bottom: 5rem;
                    /* background: rgba(0,0,-10,0.6); */
                    padding: 2rem;
                }

                .img-section {
                    /* border: 1px solid black; */
                    width: 40vw;
                    object-fit: cover;
                    object-fit: cover;
                    height: 36rem;
                }

                .form-section {
                    /* border: 1px solid black; */
                    border: 8px solid #027bfe;
                    /* width: 40vw; */
                    color: aliceblue;
                    padding: 2rem;
                    border-radius: 2rem;
                }

                .gallery-img:hover {
                    transform: scale(0.9);
                    overflow: hidden;
                    transition: all 0.3s ease-in;
                }

                #background-video {
                    width: 100vw;
                    height: 100vh;
                    object-fit: cover;
                    position: fixed;
                    left: 0;
                    right: 0;
                    top: 0;
                    bottom: 0;
                    z-index: -1;
                }

                .form-control {
                    background-color: inherit;
                }

                .section-1,
                .section-2,
                .section-3 {
                    display: flex;
                    gap: 2rem;
                }

                .btn {
                    color: #d9e7f5 !important;
                    background-color: #027bfe !important;
                    width: 100%;
                    padding: 2rem 0 2rem 0;
                }

                .btn:hover {
                    background-color: #0062 !important;
                }

                .btn:focus {
                    background-color: #0062 !important;
                    outline: none;
                    box-shadow: none;
                }

                .footer-container {
                    display: flex;
                    flex-direction: column;
                    align-items: center;
                    /* margin-bottom: 8rem; */
                    background: rgba(0, 0, -10, 0.6);
                    color: aliceblue;
                }

                .btn-submission {
                    display: flex;
                    justify-content: center;
                }

                .form-group {
                    font-size: 88% !important;
                }

                .captcha {
                    display: flex;
                    flex-direction: column;
                    gap: 1rem;
                    align-items: center;
                }

                .animated_rainbow_1 {
                    font-size: 50px;
                    /* font-family: Arial Black, Gadget, sans-serif; */
                    background-image: -webkit-linear-gradient(left, #f00, #ff2b00, #f50, #ff8000, #fa0, #ffd500, #ff0, #d4ff00, #af0, #80ff00, #5f0, #2bff00, #0f0, #00ff2a, #0f5, #00ff80, #0fa, #00ffd5, #0ff, #00d5ff, #0af, #0080ff, #05f, #002aff, #00f, #2b00ff, #50f, #8000ff, #a0f, #d400ff, #f0f, #ff00d4, #f0a, #ff0080, #f05, #ff002b, #f00);
                    -webkit-animation: animatedBackground_a 5s linear infinite alternate;
                    -webkit-background-clip: text;
                    -webkit-text-fill-color: #0000;
                    background-clip: text;
                    text-align: center;
                }

                @keyframes animatedBackground_a {
                    0% {
                        background-position: 0 0
                    }
                    100% {
                        background-position: -500px 0
                    }
                }

                @media only screen and (max-width: 600px) {
                    .img-section {
                        display: none;
                    }
                    .section-1,
                    .section-2,
                    .section-3 {
                        flex-direction: column;
                        gap: 0;
                    }
                    .input-block {
                        width: fit-content !important;
                    }
                    .form-section {
                        border: none;
                        width: min-content;
                    }
                    .select-opt {
                        width: 100% !important;
                    }
                    .form-group {
                        font-size: 1rem !important;
                    }
                    .captcha {
                        align-items: flex-start;
                    }
                }
                        .gallery-btn {
                            padding: 5px !important;
                        }

                        @media only screen and (max-width: 425px) {
                            .catagory-tab {
                                display: block !important;
                            }
                        }
                    </style>

                    <div>
                        {{-- <video id="background-video" autoplay loop muted>
                            <source src="https://woodswoood.com/public/anna2/assets/back.mp4" type="video/mp4">
                         </video> --}}
                        <!-- baner -->
                        {{-- <div id="main-container">
                            <div class="text-area">
                                <div>
                                    <h1 class="animated_rainbow_1">WELCOME TO Woods Games</h1>
                                    <h1 class="animated_rainbow_1"> <span>Download our games </span></h1>
                                </div>
                                <!--<div style="margin-top: 5rem;">-->
                                <!--     <img src="assets/animation.gif.mp4" alt="" style="width: 100%;"> -->
                                <!--    <video id="logo" autoplay loop muted poster="">-->
                                <!--        <source src="public/anna2/assets/animation.gif.mp4" type="video/mp4">-->
                                <!--    </video>-->
                                <!--</div>-->
                            </div>
                        </div>--}}
                        <!-- banner -->
                        <!-- formstr -->
                        <!-- form end -->
                        <!-- game -->
                        {{--<div style="display: flex; justify-content:center;">
                            <h1 class="animated_rainbow_1">Our Games</h1>
                        </div>--}}
                       
                        <div class="catagory-tab nav nav-tabs" id="myTab" role="tablist">
                             <button type="button" class="nav-link btn btn-primary gallery-btn active" data-toggle="modal" data-target=".bd-example-modal-lg1">
                      Add Game
                    </button>
                            <!--<button class="nav-link btn btn-primary gallery-btn active" id="a-tab" type="button" role="tab" aria-controls="a" aria-selected="true" data-toggle="tab" data-target="#a">All</button>-->
                            <button class="nav-link btn btn-primary gallery-btn" id="b-tab" data-toggle="tab" data-target="#b" type="button" role="tab" aria-controls="b" aria-selected="false">Our Policies</button>
                            <!--<button class="nav-link btn btn-primary gallery-btn" id="c-tab" data-toggle="tab" data-target="#c"-->
                            <!--    type="button" role="tab" aria-controls="c" aria-selected="false">MilkyWay</button>-->
                            <!--<button class="nav-link btn btn-primary gallery-btn" id="d-tab" data-toggle="tab" data-target="#d"-->
                            <!--    type="button" role="tab" aria-controls="d" aria-selected="false">Riversweep</button>-->
                            <!--<button class="nav-link btn btn-primary gallery-btn" id="e-tab" data-toggle="tab" data-target="#e"-->
                            <!--    type="button" role="tab" aria-controls="e" aria-selected="false">Xgames</button>-->
                            <!--<button class="nav-link btn btn-primary gallery-btn" id="f-tab" data-toggle="tab" data-target="#f"-->
                            <!--    type="button" role="tab" aria-controls="f" aria-selected="false">Juwa</button>-->
                        </div>

                        <script>
                            document.getElementById('b-tab').onclick = function() {
                                document.getElementById("myModaltest").style.display = "block";
                                modal.classList.add('show');
                            }
                        </script>
                        <div class="gallery-section" id="gallery">
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="a" role="tabpanel" aria-labelledby="a-tab">
                                    <div class="row">
                                        @foreach ($forms as $form)
                                        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">
                                            <div class="image h-100">
                                                <img class="gallery-img" src="{{ asset('public/uploads/'.$form['image']) }}">
                                                <div class="overlay position-absolute">
                                                    <a href="{{ $form['game_url'] }}">
                                                        <h6 class="animated_rainbow_1">Click to download</h6>
                                                    </a>
                                                    <div class="display-inline-block">
                         <a href="javascript:void(0);" data-id="{{$form->id}}" class=" edit-game padding-5">
                            <i class="fa fa-edit font-13" style="color:white"></i>
                        </a>
                         <a href="javascript:void(0);" data-id="{{$form->id}}" class=" delete-game padding-5">
                            <i class="fa fa-trash font-13" style="color:white"></i>
                        </a>
                        <a href="javascript:void(0);" data-id="{{$form->id}}" class="image-game padding-5" data-value="{{asset('public/uploads/'.$form->image)}}">
                           <i class="fa fa-image font-13" style="color:white"></i>
                       </a>
                        <a href="{{route('gameImage',['id'=>$form->id])}}" data-id="{{$form->id}}" class="btn btn-success padding-5">
                           <i class="fa fa-picture font-13"></i>
                       </a>
                       
                     </div>
                                                </div>
                                            </div>
                                        </div>
                                        @endforeach

                                    </div>
                                </div>
                                <div class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="b-tab">
                                    <div class="row">
                                        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">
                                            <div class="image h-100">
                                                <img class="gallery-img" src="https://woodswoood.com/public/anna2/assets/fk.jpg">
                                                <div class="overlay position-absolute">
                                                    <a href="facebook.com">
                                                        <h6 class="animated_rainbow_1">Click to download</h6>
                                                    </a>
                                                    
                                                </div>
                                            </div>
                                        </div>
                                        <!--<div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                        <!--    <div class="image h-100">-->
                                        <!--        <img class="gallery-img" src="public/anna2/assets/fk1.jpg">-->
                                        <!--        <div class="overlay position-absolute">-->
                                        <!--            <a href="facebook.com">-->
                                        <!--                <h6 class="animated_rainbow_1">Click to download</h6>-->
                                        <!--            </a>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <!--<div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                        <!--    <div class="image h-100">-->
                                        <!--        <img class="gallery-img" src="public/anna2/assets/fk2.jpg">-->
                                        <!--        <div class="overlay position-absolute">-->
                                        <!--            <a href="facebook.com">-->
                                        <!--                <h6 class="animated_rainbow_1">Click to download</h6>-->
                                        <!--            </a>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                        <!--<div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                        <!--    <div class="image h-100">-->
                                        <!--        <img class="gallery-img" src="public/anna2/assets/fk3.jpg">-->
                                        <!--        <div class="overlay position-absolute">-->
                                        <!--            <a href="facebook.com">-->
                                        <!--                <h6 class="animated_rainbow_1">Click to download</h6>-->
                                        <!--            </a>-->
                                        <!--        </div>-->
                                        <!--    </div>-->
                                        <!--</div>-->
                                    </div>
                                </div>
                                <!--<div class="tab-pane fade" id="c" role="tabpanel" aria-labelledby="c-tab">-->
                                <!--    <div class="row">-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/mk.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/mk1.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/mk2.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/mk2.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="tab-pane fade" id="d" role="tabpanel" aria-labelledby="d-tab">-->
                                <!--    <div class="row">-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/r.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/r1.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/r2.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="tab-pane fade" id="e" role="tabpanel" aria-labelledby="e-tab">-->
                                <!--    <div class="row">-->

                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/x.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--                  <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/x1.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/x2.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/x3.jpg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--    </div>-->
                                <!--</div>-->
                                <!--<div class="tab-pane fade" id="f" role="tabpanel" aria-labelledby="f-tab">-->
                                <!--    <div class="row">-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/g4.webp">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/g1.jpeg">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/g2.webp">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->
                                <!--        <div class="image-wrap col-lg-4 col-md-6 col-sm-12 mb-3">-->
                                <!--            <div class="image h-100">-->
                                <!--                <img class="gallery-img" src="public/anna2/assets/g3.webp">-->
                                <!--                <div class="overlay position-absolute">-->
                                <!--                    <a href="facebook.com">-->
                                <!--                        <h6 class="animated_rainbow_1">Click to download</h6>-->
                                <!--                    </a>-->
                                <!--                </div>-->
                                <!--            </div>-->
                                <!--        </div>-->

                                <!--    </div>-->
                                <!--</div>-->
                            </div>
                        </div>
                        <!-- endgames -->
                        <!-- footer -->
                        <div class="footer-container">
                            <span id="footer-text"></span>
                        </div>
                        <!-- endfootr -->
                    </div>
                    </div>

                    <!-- The Modal -->
                    <div id="myModaltest" class="modaltest">

                        <!-- Modal content -->
                        <div class="modal-contenttest">
                            <span class="closetest">&times;</span>
                            <div id="modal_main_contenttest">
                                <img src="https://woodswoood.com/public/anna2/assets/pupupanna.png" style="width:100%">
                            </div>
                        </div>

                    </div>
                    </div>
                    <script>
                            document.getElementById('a-tab').onclick = function() {
                                document.getElementById("myModaltest").style.display = "block";
                                modal.classList.add('show');
                            }
                        </script>

                <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" class="tab-pane fade" id="b" role="tabpanel" aria-labelledby="b-tab">
                    
                        <div class="modal-dialog modal-lg">
                          <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLongTitle">Add Games</h5>
                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
                              </div>
                              <div class="modal-body">
                                <form action="{{route('gameStore')}}" method="post" enctype="multipart/form-data">
                                  @csrf
                                  <div class="row">
                                    <div class="col-6">
                                      <label for="name" class="form-label">Name</label>
                                      <input required name="name" type="text" class="form-control" id="name" placeholder="Name">
                                    </div>
                                    <div class="col-6">
                                      <label for="title" class="form-label">Title</label>
                                      <input required name="title" type="text" class="form-control" id="title" placeholder="Title">
                                    </div>
                                    <div class="col-6 mt-2">
                                      <label for="balance" class="form-label">Balance</label>
                                      <input required name="balance" type="number" class="form-control" id="balance" placeholder="Balance">
                                    </div>
                                    <div class="col-6 mt-2">
                                      <label for="status" class="form-label">Status</label>
                                      <select required name="status" id="" class="form-control">
                                        <option value="active">Active</option>
                                        <option value="inactive">Inactive</option>
                                      </select>
                                    </div>
                                    <div class="col-6 mt-2">
                                      <label for="image" class="form-label">Image</label>
                                      <input type="file" name="file" class="form-control" id="image">
                                    </div>
                                    <div class="col-6 mt-2">
                                        <label for="game-url" class="form-label">Url</label>
                                        <input type="text" name="game_url" class="form-control" id="game-url">
                                    </div>
                                    <div class="col-12 mt-2">
                                      <button type="submit">Submit</button>
                                    </div>
                                  </div>
                                </form>
                              </div>
                            </div>
                          </div>
                        </div>
                    </div>

                    <script>
                        // Get the modal
                        var modal = document.getElementById("myModaltest");

                        // Get the <span> element that closes the modal
                        var span = document.getElementsByClassName("closetest")[0];

                        // When the user clicks on <span> (x), close the modal
                        span.onclick = function() {
                            modal.classList.remove('show');

                            setTimeout(function() {
                                modal.style.display = "none";
                            }, 500);
                        }

                        document.getElementById("myModaltest").style.display = "none";

                        //close the modal window when the user clicks outside of it
                        window.onclick = function(event) {
                            if (event.target == modal) {
                                modal.classList.remove('show');

                                setTimeout(function() {
                                    modal.style.display = "none";
                                }, 500);
                            }
                        }
                    </script>

                    <style>
                        /* The Modal (background) */

                        .modaltest {
                            display: none;
                            /* Hidden by default */
                            position: fixed;
                            /* Stay in place */
                            z-index: 10;
                            /* Sit on top */
                            padding-top: 50px;
                            /* Location of the box */
                            left: 0;
                            top: 0;
                            width: 100%;
                            /* Full width */
                            height: 100%;
                            /* Full height */
                            overflow: auto;
                            /* Enable scroll if needed */
                            background-color: rgb(0, 0, 0);
                            /* Fallback color */
                            background-color: rgb(0 0 0 / 30%);
                            /* Black w/ opacity */
                            transition: top 0.5s, opacity 0.4s;
                            top: -100%;
                            opacity: 0;
                        }

                        .show {
                            display: block;
                            top: 0;
                            opacity: 1;
                        }

                        /* Modal Content */

                        .modal-contenttest {
                            position: relative;
                            background-color: none;
                            margin: auto;
                            padding: 20px;
                            border: none;
                            max-width: 500px;
                            font-size: 14px;
                            color: black;
                            margin-bottom: 100px;
                            padding-bottom: 30px;
                            border-radius: 0px;
                            -webkit-animation-name: animatetop;
                            -webkit-animation-duration: 0.4s;
                            animation-name: animatetop;
                            animation-duration: 0.4s
                        }

                        @-webkit-keyframes animatetop {
                            from {
                                top: -300px;
                                opacity: 0
                            }
                            to {
                                top: 0;
                                opacity: 1
                            }
                        }

                        @keyframes animatetop {
                            from {
                                top: -300px;
                                opacity: 0
                            }
                            to {
                                top: 0;
                                opacity: 1
                            }
                        }

                        /* The Close Button */

                        .closetest {
                            color: #aaaaaa;
                            float: right;
                            font-size: 28px;
                            margin-top: -10px;
                        }

                        .closetest:hover,
                        .closetest:focus {
                            color: #2a2a2a;
                            text-decoration: none;
                            cursor: pointer;
                        }

                        .modal-content {
                            -webkit-animation-name: animatetop;
                            -webkit-animation-duration: 0.4s;
                            animation-name: animatetop;
                            animation-duration: 0.4s
                        }

                        /* Add Animation */

                        @-webkit-keyframes animatetop {
                            from {
                                top: -300px;
                                opacity: 0
                            }
                            to {
                                top: 0;
                                opacity: 1
                            }
                        }

                        @keyframes animatetop {
                            from {
                                top: -300px;
                                opacity: 0
                            }
                            to {
                                top: 0;
                                opacity: 1
                            }
                        }

                        /* animate from current to top */

                        @-webkit-keyframes animateremove {
                            from {
                                top: 0px;
                                opacity: 1
                            }
                            to {
                                top: -300px;
                                opacity: 0
                            }
                        }

                        @keyframes animateremove {
                            from {
                                top: 0px;
                                opacity: 1
                            }
                            to {
                                top: -300px;
                                opacity: 0
                            }
                        }
                    </style>
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
                <script src="https://woodswoood.com/public/anna2/assets/js/index.js"></script>
                <script>
                    $(document).ready(function() {
                        $('.captcha-input').on('keypress', function(e) {
                            if (!($('.captcha-error').hasClass('hidden'))) {
                                $('.captcha-error').addClass('hidden');
                            }
                        });
                        $('.account-select').on('change', function() {
                            var gameId = $(this).find(':selected').data('title');
                            $('.game-id-text').val(gameId + '_');
                            console.log(gameId);
                        });


                        $('.submit-btn').on('click', function(e) {
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
                                success: function(data) {
                                    if (data == 'true') {
                                        form.submit();
                                    } else {
                                        toastr.error('Error', 'Captcha Incorrect');
                                    }

                                },
                                error: function(data) {
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
                    var images = ['public/anna2/assets/fk.jpg', 'public/anna2/assets/mk.jpg', 'public/anna2/assets/r.jpg', 'public/anna2/assets/x.jpg', 'public/anna2/assets/j.jpg']
                //var catagory1 = ['public/anna2/assets/fk1.jpg','public/anna2/assets/fk2.jpg','public/anna2/assets/fk3.jpg','public/anna2/assets/fk4.jpg']
                //var catagory2 = ['public/anna2/assets/mk1.jpg','public/anna2/assets/mk2.jpg','public/anna2/assets/mk3.jpg','public/anna2/assets/mk4.jpg']
                // var catagory3 = ['public/anna2/assets/r1.jpg','public/anna2/assets/r2.jpg','public/anna2/assets/r3.jpg']
                // var catagory4 = ['public/anna2/assets/x1.jpg','public/anna2/assets/x2.jpg','public/anna2/assets/x3.jpg','public/anna2/assets/x4.jpg']
                // var catagory5 = ['public/anna2/assets/j1.jpg','public/anna2/assets/j2.jpg','public/anna2/assets/j3.jpg']
                let gallery = document.getElementById('gallery')
                var allCatagory = [images, catagory1, catagory2]
                var currentArray = images
                var date = new Date().getFullYear()
                var footerText = document.getElementById('footer-text')
                footerText.innerHTML = "Woods © " + date + " All rights reserved."

                function gg() {
                    currentArray.forEach(element => {
                        let images = document.createElement('img')
                        images.className = "gallery-img"
                        images.src = element
                        gallery.appendChild(images)

                    });
                }
                window.addEventListener(onload, gg())

                function toogleCatagory(catagory) {
                    if (catagory == "catagory1") {
                        console.log(catagory)
                        currentArray = catagory1
                        document.getElementById('gallery').innerHTML = ''
                        gg()
                    }
                    if (catagory == "catagory2") {
                        currentArray = catagory2
                        document.getElementById('gallery').innerHTML = ''
                        gg()
                    }
                    if (catagory == "catagory3") {
                        currentArray = catagory3
                        document.getElementById('gallery').innerHTML = ''
                        gg()
                    }
                    if (catagory == "catagory4") {
                        currentArray = catagory4
                        document.getElementById('gallery').innerHTML = ''
                        gg()
                    }
                    if (catagory == "catagory5") {
                        currentArray = catagory5
                        document.getElementById('gallery').innerHTML = ''
                        gg()
                    }

                    if (catagory == "all") {
                        var allCat = []
                        allCatagory.forEach((element) => {
                            allCat.push(element[0])
                        })
                        console.log(allCat)
                        currentArray = allCat
                        document.getElementById('gallery').innerHTML = ''
                        gg()
                    }


                }

                function validate() {
                    if (document.form.fullname.value.length > 15) {
                        alert("max length 15");
                        document.form.fullname.focus();
                        return false;
                    }
                }
                </script>
                <!--<script src="assets/js/index.js"></script>-->

                </div>
            </div>
    </div>
    <div class="modal fade bd-example-modal-lg editFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: {{isset($color)?$color->color:'purple'}}">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit User</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">

                  </div>
                </div>
              </div>
        </div>
    </div>
    <div class="modal fade bd-example-modal-lg editImageModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: {{isset($color)?$color->color:'purple'}}">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit Image</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">
                    <form action="{{route('gameImageStore')}}" method="post" enctype="multipart/form-data">
                      @csrf
                      <div class="row">
                        <input type="hidden" name="id" id="game-id-image" value="">
                        <div class="col-12 mt-2">
                          <label for="image" class="form-label">Image</label>
                          <input type="file" name="file" class="form-control" id="image">
                          <img src="" alt="" height="300" width="300" id="game-image" class="game-image">
                        </div>
                        <div class="col-12 mt-2">
                          <button type="submit" class="btn btn-primary">Submit</button>
                        </div>
                      </div>
                    </form>
                  </div>
                </div>
              </div>
        </div>
    </div>

    <div class="modal fade bd-example-modal-lg1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
          <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Games</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <div class="modal-body">
                <form action="{{route('gameStore')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="row">
                    <div class="col-6">
                      <label for="name" class="form-label">Name</label>
                      <input required name="name" type="text" class="form-control" id="name" placeholder="Name">
                    </div>
                    <div class="col-6">
                      <label for="title" class="form-label">Title</label>
                      <input required name="title" type="text" class="form-control" id="title" placeholder="Title">
                    </div>
                    <div class="col-6 mt-2">
                      <label for="balance" class="form-label">Balance</label>
                      <input required name="balance" type="number" class="form-control" id="balance" placeholder="Balance">
                    </div>
                    <div class="col-6 mt-2">
                      <label for="status" class="form-label">Status</label>
                      <select required name="status" id="" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                      </select>
                    </div>
                    <div class="col-6 mt-2">
                      <label for="image" class="form-label">Image</label>
                      <input type="file" name="file" class="form-control" id="image" onchange="gameImagePreview()">
                    </div>
                    <div class="col-6 mt-2">
                        <label for="game-url" class="form-label">Url</label>
                        <input type="text" name="game_url" class="form-control" id="game-url">
                    </div>
                    <div class="col-12 mt-2">
                      <button type="submit">Submit</button>
                    </div>
                  </div>
                </form>
              </div>
            </div>
          </div>
        </div>
    </div>
    
    <div class="modal fade bd-example-modal-lg editFormModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header" style="background: {{isset($color)?$color->color:'purple'}}">
                  <h5 class="modal-title" id="exampleModalLabel" style="color: white">Edit User</h5>
                </div>
                <div class="modal-body editFormModalBody">
                  <div class="appendHere">

                  </div>
                </div>
              </div>
        </div>
    </div>

@endsection

@section('script')
<script>

        function gameImagePreview(){
            var output = document.getElementById('game-image');
            output.src = URL.createObjectURL(event.target.files[0]);
        }
      jQuery(document).ready( function () {

        $('.image-game').on('click', function () {
          $('#game-id-image').val($(this).data('id'));
          $('.editImageModal').modal('show');
           $('#game-image').attr('src',$(this).data('value'));
        });
        $('.edit-game').on('click', function () {
            $('.editFormModal').modal('show');
            var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/games/edit/"+cid,
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
        var link = $('.delete-form').attr("href");
        // var link = $('.delete-form');
        $('.datatable tbody').on('click', '.delete-game', function (e) {
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
                        url: "/games/destroy/"+cid,
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
                            });
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
      });

    </script>
@endsection

@section('script')
<script>
      jQuery(document).ready( function () {

        $('.datatable tbody').on('click', '.image-game', function () {
          $('#game-id-image').val($(this).data('id'));
          $('.editImageModal').modal('show');
        });
        $('.datatable tbody').on('click', '.edit-game', function () {
            $('.editFormModal').modal('show');
            var cid = $(this).data('id');
                    $.ajax({
                        type: 'get',
                        url: "/games/edit/"+cid,
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
        var link = $('.delete-form').attr("href");
        // var link = $('.delete-form');
        $('.datatable tbody').on('click', '.delete-game', function (e) {
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
                        url: "/games/destroy/"+cid,
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
                            });
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
      });

    </script>
@endsection

