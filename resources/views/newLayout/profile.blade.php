@extends('newLayout.layouts.newLayout')

@section('title')
     Profile 
@endsection
@section('content')
{{-- {{dd(Auth::user())}} --}}
   <div class="row">
     <div class="col-md-8">
      <form method="post" action="{{route('profile.save')}}">
        @csrf
        <div class="card">
          <div class="card-header pb-0">
            <div class="d-flex align-items-center">
              <p class="mb-0">Edit Your Profile</p>
                  <button class="btn btn-primary btn-sm ms-auto" style="background-color:#FF9800;" >Update</button>
            </div>
          </div>
          <div class="card-body">
            <p class="text-uppercase text-sm">Your Information</p>
            <div class="row">
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Username</label>
                  <input name="name" class="form-control" type="text" value="{{Auth::user()->name}}">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Email address</label>
                  <input name="email" class="form-control" type="email" value="{{Auth::user()->email}}" readonly>
                </div>
              </div>
              {{-- <div class="col-md-6">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">First name</label>
                  <input class="form-control" type="text" value="Jesse">
                </div>
              </div>
              <div class="col-md-6">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Last name</label>
                  <input class="form-control" type="text" value="Lucky">
                </div>
              </div> --}}
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Contact Information</p>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Address</label>
                  <input value="{{Auth::user()->address}}" name="address" class="form-control" type="text" placeholder="Bld Mihail Kogalniceanu, nr. 8 Bl 1, Sc 1, Ap 09">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">City</label>
                  <input value="{{Auth::user()->city}}" name="city" class="form-control" type="text" placeholder="New York">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Country</label>
                  <input value="{{Auth::user()->country}}" name="country" class="form-control" type="text" placeholder="United States">
                </div>
              </div>
              <div class="col-md-4">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Postal code</label>
                  <input value="{{Auth::user()->postal}}" name="postal" class="form-control" type="text" placeholder="437300">
                </div>
              </div>
            </div>
                <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Bank Details</p>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Bank Name</label>
                  <input value="{{Auth::user()->bank_name}}" name="bank_name" class="form-control" type="text" placeholder="Name ,Branch">
                </div>
              </div>
                <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Account Number</label>
                  <input value="{{Auth::user()->bank_num}}" name="bank_num" class="form-control" type="text" placeholder="XXXXXXXXXXXXXXXXXXX">
                </div>
              </div>
                <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">Payment Number </label>
                  <input value="{{Auth::user()->payment_number}}" name="payment_number" class="form-control" type="text" placeholder="+1 XXXXXXXXXX">
                </div>
              </div>
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">About me</p>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">About me</label>
                  <input value="{{Auth::user()->about}}" name="about" class="form-control" type="text" placeholder="A beautiful Dashboard for Bootstrap 5. It is Free and Open Source.">
                </div>
              </div>
            </div>
            <hr class="horizontal dark">
            <p class="text-uppercase text-sm">Change Password</p>
            <div class="row">
              <div class="col-md-12">
                <div class="form-group">
                  <label for="example-text-input" class="form-control-label">New Password</label>
                  <input value="" name="password" class="form-control" type="password" placeholder="****">
                </div>
              </div>
            </div>
          </div>
        </div>
      </form>
     </div>
     <div class="col-md-4">
       <div class="card card-profile">
           <video autoplay="" muted="" loop="" id="myVideo">
    <source src="https://noorgames.net/images/fin.mp4" type="video/mp4">
    Your browser does not support HTML5 video.
    </video>
         <!--<img src="{{asset('/public/uploads/bg-profile.jpg')}}" alt="Image placeholder" class="card-img-top">-->
         <div class="row justify-content-center">
           <div class="col-4 col-lg-4 order-lg-2">
             <div class="mt-n4 mt-lg-n6 mb-4 mb-lg-0">
               <a href="javascript:;">
                   
                   
                 <img src="https://noorgames.net/images/dragonnn.gif" class="rounded-circle img-fluid border border-2 border-white">
               </a>
             </div>
           </div>
         </div>
       
         <div class="card-body pt-0">
           
           <div class="text-center mt-4">
             <h5>
               Name:{{Auth::user()->name}}<span class="font-weight-light"></span>
             </h5>
             <div class="h6 font-weight-300">
               <i class="ni location_pin mr-2"></i>Email:{{Auth::user()->email}}
             </div>
             <div class="h6 mt-4">
               <i class="ni business_briefcase-24 mr-2"></i>Address:{{Auth::user()->email}}
             </div>
             <div class="h6 mt-4">
               <i class="ni business_briefcase-24 mr-2"></i>Bank Details:{{Auth::user()->email}}
             </div>
             <div>
               <i class="ni education_hat mr-2"></i>Hired As:{{Auth::user()->role}}
             </div>
           </div>
         </div>
       </div>
     </div>
   </div>
@endsection

