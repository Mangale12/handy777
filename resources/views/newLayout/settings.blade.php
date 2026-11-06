@extends('newLayout.layouts.newLayout')
@section('title')
Settings [ {{date('Y-m-d H:i:s');}} ]
@endsection
@section('content')
<style>
   .example-text{
   padding: 5px;
   background: #e9ecef;
   }
   .bootstrap-tagsinput{
   padding: 10px 10px;
   }
   .tag{
   background: #fbb244;
   padding: 5px;
   }
</style>
<div class="container">
    @php
    $gameregames = json_decode($settings['gameregames'], true);
    @endphp
 
   {{-- <div class="tab-pane fade" id="email-limit" role="tabpanel" aria-labelledby="email-limit-tab"> --}}
      <form action="{{ route('email_id_counter') }}" method="POST">
         @csrf
         <div class="card mt-5">
            <div class="card-header" style="padding-bottom:0">
               <h5>Emali Limit</h5>
            </div>
            <div class="card-body">
               <div class="row">
                  <div class="col-lg-6 col-sm-12">
                     <span>Enter Email Id</span>
                     <input type="number" name="email_id_counter" class="form-control" id="emil-limit" value="{{$settings['email_id_counter']}}">
                  </div>
                  <div class="col-lg-6 col-sm-12">
                     {{-- <span>Enter Email Id</span> --}}
                     <input type="submit" name="email_limit" class="btn btn-primary mt-4" value="submit" >
                  </div>
                  
                  <div class="col-lg-12 col-sm-12">
                     <span>Page Link</span>
                     <textarea name="page_link" class="form-control" id="page_link" required>{{$settings['page_link']}}</textarea>
                  </div>
                  

               </div>
            </div>
         </div>
      </form>

   {{-- </div> --}}
   <!-- Tabs navs -->
   <!-- Tabs content -->

   <div class="row justify-content-center">

   </div>
      <div class="col-md-12">
         <form action="{{ route('settingStore') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="card mt-5">
               <ul class="nav nav-tabs" id="myTab" role="tablist">
                  <li class="nav-item">
                     <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-controls="home"
                        aria-selected="true">Spiner</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="profile-tab" data-toggle="tab" href="#profile" role="tab" aria-controls="profile"
                        aria-selected="false">Mails</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="contact-tab" data-toggle="tab" href="#contact" role="tab" aria-controls="contact"
                        aria-selected="false">Captcha</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="general-setting-tab" data-toggle="tab" href="#general-setting" role="tab" aria-controls="contact"
                        aria-selected="false">General Settings</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="email-setting-tab" data-toggle="tab" href="#email-setting" role="tab" aria-controls="contact"
                        aria-selected="false">Email Settings</a>
                  </li>
                  <li class="nav-item">
                     <a class="nav-link" id="email-limit-tab" data-toggle="tab" href="#email-limit" role="tab" aria-controls="email-limit"
                        aria-selected="false">Email Limit</a>
                  </li>
                  <li class="nav-item">
                    <a class="nav-link" id="gamers-games-tab" data-toggle="tab" href="#gamers-games" role="tab" aria-controls="email-limit"
                       aria-selected="false">Gamers Games Email</a>
                 </li>
                 <li class="nav-item">
                    <a class="nav-link" id="bulk-mail-tab" data-toggle="tab" href="#bulk-mail" role="tab" aria-controls="bulk-mail"
                       aria-selected="false">Bulk Mail</a>
                 </li>
               </ul>
               <div class="card-body">
                  <div class="tab-content" id="myTabContent">
                     <div class="tab-pane fade show active" id="home" role="tabpanel" aria-labelledby="home-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>Spiner Time</h5>
                           </div>
                           <div class="row">
                              <div class="col-lg-6 col-sm-12 mb-3">
                                 <span>Day</span>
                                 <input class="form-control" type="number" name="spinner_winner_day" placeholder="Day" value="{{$settings['spinner_winner_day']}}">
                              </div>
                              <div class="col-lg-6 col-sm-12">
                                 <span>Time</span>
                                 <input type="time" name="spinner_time_cron" class="form-control" id="spinner-time" value="{{$settings['spinner_time_cron']}}">
                              </div>
                              <div class="col-lg-6 col-12">
                                 <span>Spinner Day (Choose between 1 to 31)</span>
                                 <input type="number" class="form-control" name="spinner_date" value="{{$settings['spinner_date']}}" >
                              </div>
                              <div class="col-lg-6 col-12">
                                 <span>Spinner Time</span>
                                 <input type="time" class="form-control" name="spinner_time" value="{{$settings['spinner_time']}}" >
                              </div>
                              {{-- <div class="col-lg-12 col-sm-12">
                                 <input type="submit" class="btn btn-primary mt-2" value="submit">
                              </div> --}}
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="profile" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>Inactive Mail Setting</h5>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Type</span>
                                    <select name="inactive_mail_type" class="form-control">
                                    <option {{($settings['inactive_mail_type'] == 'everyMinute') ? 'selected': ''}} value="everyMinute">Every Minute</option>
                                    <option {{($settings['inactive_mail_type'] == 'dailyAt') ? 'selected': ''}} value="dailyAt">Daily</option>
                                    <option {{($settings['inactive_mail_type'] == 'weeklyOn') ? 'selected': ''}} value="weeklyOn">Weekly</option>
                                    <option {{($settings['inactive_mail_type'] == 'monthlyOn') ? 'selected': ''}} value="monthlyOn">Monthly</option>
                                    <option {{($settings['inactive_mail_type'] == 'lastDayOfMonth') ? 'selected': ''}} value="lastDayOfMonth">Last Day Of Month</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Day</span>
                                    <input class="form-control" type="number" name="inactive_mail_day" placeholder="Day" value="{{$settings['inactive_mail_day']}}">
                                 </div>
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Time</span>
                                    <input type="time" name="inactive_mail_time" class="form-control" id="inactive_mail_time" value="{{$settings['inactive_mail_time']}}">
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Inactive Mail Message</span>
                                    <textarea name="inactive_mail_message" id="" class="form-control inactive_mail_message">{{$settings['inactive_mail_message']}}</textarea>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Inactive Mail Message Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">Hello {Name}</p>
                                       <p class="mb-0 inactive-example-text">{{$settings['inactive_mail_message']}}</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        <div class="card mt-5">
                           {{--
                           <div class="card-header">{{ __('Edit Noorgamers') }}</div>
                           --}}
                           <div class="card-body">
                              {{ csrf_field() }}
                              <div class="row">
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Limit Amount</span>
                                    <input type="number" class="form-control" name="limit_amount" value="{{$settings['limit_amount']}}" >
                                 </div>
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Spinner Message Monthly</span>
                                    <select name="spinner_message_monthly" class="form-control">
                                    <option {{($settings['spinner_message_monthly']==1)?'selected':''}} value="1">On</option>
                                    <option {{($settings['spinner_message_monthly']==0)?'selected':''}} value="0">Off</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Spinner Message</span>
                                    <select name="spinner_message" class="form-control">
                                    <option {{($settings['spinner_message']==1)?'selected':''}} value="1">On</option>
                                    <option {{($settings['spinner_message']==0)?'selected':''}} value="0">Off</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Registration Email</span>
                                    <select name="registration_email" class="form-control">
                                    <option {{($settings['registration_email']==1)?'selected':''}} value="1">On</option>
                                    <option {{($settings['registration_email']==0)?'selected':''}} value="0">Off</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-4 col-sm-12">
                                    <span>Registration SMS</span>
                                    <select name="registration_sms" class="form-control">
                                    <option {{($settings['registration_sms']==1)?'selected':''}} value="1">On</option>
                                    <option {{($settings['registration_sms']==0)?'selected':''}} value="0">Off</option>
                                    </select>
                                 </div>
                              </div>
                              </br>
                              <div class="row">
                                 <div class="col" style="display: inline-grid;">
                                    <span>Send Bonus Emails To</span>
                                    <input type="text" class="form-control emails" name="bonus_report_emails[]" value="{{$settings['bonus_report_emails']}}" >
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col" style="display: inline-grid;">
                                    <span>Send 24 hour Report Emails  & Inactive Emails  To</span>
                                    <input type="text" class="form-control emails" name="emails[]" value="{{$settings['emails']}}" >
                                 </div>
                              </div>
                              <div class="row">
                                 <div class="col" style="display: inline-grid;">
                                    <span>Send New Registration Email To</span>
                                    <input type="text" class="form-control emails" name="new_register_mail[]" value="{{$settings['new_register_mail']}}" >
                                 </div>
                              </div>
                              </br>
                              </br></br>
                           </div>
                        </div>
                        <div class="card mt-5">
                           <div class="card-body">
                              <div class="row">
                                 <div class="bg-light text-center">
                                    <h4>Above Limit Text</h4>
                                 </div>
                                 @php
                                 $above_limit_text = json_decode($settings['above_limit_text'],true);
                                 $between_limit_text = json_decode($settings['between_limit_text'],true);
                                 $below_limit_text = json_decode($settings['below_limit_text'],true);
                                 $email_setting = json_decode($settings['emails_settings'], true);
                                 // print_r( $setting);
                                 // die;
                                 @endphp
                                 <div class="col-lg-8 col-md-6 col-sm-12 mt-2">
                                    <div class="row">
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Above Limit Text 1 </span>
                                          <textarea name="above_limit_text_1" id="" class="form-control above-limit-text">{{$above_limit_text['above_limit_text_1']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Above Limit Text 2 </span>
                                          <textarea name="above_limit_text_2" id="" class="form-control above-limit-text">{{$above_limit_text['above_limit_text_2']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Above Limit Text 3 </span>
                                          <textarea name="above_limit_text_3" id="" class="form-control above-limit-text">{{$above_limit_text['above_limit_text_3']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Above Limit Text 4 </span>
                                          <textarea name="above_limit_text_4" id="" class="form-control above-limit-text">{{$above_limit_text['above_limit_text_4']}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                    <span>Above Limit Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">{{$above_limit_text['above_limit_text_1']}} {Name}</p>
                                       <p class="mb-0 above-example-text">{{$above_limit_text['above_limit_text_2']}}</p>
                                       <p class="mb-0">{{$above_limit_text['above_limit_text_3']}}</p>
                                       <p class="mb-0">{{$above_limit_text['above_limit_text_4']}} {Token}</p>
                                    </div>
                                 </div>
                                 <div class="bg-light text-center mt-5">
                                    <h4>Between Limit Text</h4>
                                 </div>
                                 <div class="col-lg-8 col-md-6 col-sm-12 mt-2">
                                    <div class="row">
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Between Limit Text 1 </span>
                                          <textarea name="between_limit_text_1" id="" class="form-control above-limit-text">{{$between_limit_text['between_limit_text_1']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Between Limit Text 2 </span>
                                          <textarea name="between_limit_text_2" id="" class="form-control above-limit-text">{{$between_limit_text['between_limit_text_2']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Between Limit Text 3 </span>
                                          <textarea name="between_limit_text_3" id="" class="form-control above-limit-text">{{$between_limit_text['between_limit_text_3']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Between Limit Text 4 </span>
                                          <textarea name="between_limit_text_4" id="" class="form-control above-limit-text">{{$between_limit_text['between_limit_text_4']}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                    <span>Above Limit Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">{{$between_limit_text['between_limit_text_1']}} {Name}</p>
                                       <p class="mb-0 above-example-text">{{$between_limit_text['between_limit_text_2']}}</p>
                                       <p class="mb-0">{{$between_limit_text['between_limit_text_3']}}</p>
                                       <p class="mb-0">{{$between_limit_text['between_limit_text_4']}} {Token}</p>
                                    </div>
                                 </div>
                                 {{--
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Between Limit Text </span>
                                    <textarea name="between_limit_text" id="" class="form-control between-limit-text">{{$settings['between_limit_text']}}</textarea>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Between Limit Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">Hello {Name}</p>
                                       <p class="mb-0 between-example-text">{{$settings['between_limit_text']}}</p>
                                       <p class="mb-0">Only {Remaining Balance} left to be eligible for the spinner.</p>
                                    </div>
                                 </div>
                                 --}}
                                 <div class="bg-light text-center mt-5">
                                    <h4>Below Limit Text</h4>
                                 </div>
                                 <div class="col-lg-8 col-md-6 col-sm-12 mt-2">
                                    <div class="row">
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Below Limit Text 1 </span>
                                          <textarea name="below_limit_text_1" id="" class="form-control above-limit-text">{{$below_limit_text['below_limit_text_1']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Below Limit Text 2 </span>
                                          <textarea name="below_limit_text_2" id="" class="form-control above-limit-text">{{$below_limit_text['below_limit_text_2']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Below Limit Text 3 </span>
                                          <textarea name="below_limit_text_3" id="" class="form-control above-limit-text">{{$below_limit_text['below_limit_text_3']}}</textarea>
                                       </div>
                                       <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                          <span>Below Limit Text 4 </span>
                                          <textarea name="below_limit_text_4" id="" class="form-control above-limit-text">{{$below_limit_text['below_limit_text_4']}}</textarea>
                                       </div>
                                    </div>
                                 </div>
                                 <div class="col-lg-4 col-md-4 col-sm-12 mt-2">
                                    <span>Below Limit Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">{{$below_limit_text['below_limit_text_1']}} {Name}</p>
                                       <p class="mb-0 above-example-text">{{$below_limit_text['below_limit_text_2']}}</p>
                                       <p class="mb-0">{{$below_limit_text['below_limit_text_3']}}</p>
                                       <p class="mb-0">{{$below_limit_text['below_limit_text_4']}} {Token}</p>
                                    </div>
                                 </div>
                                 {{--
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Below Limit Text </span>
                                    <textarea name="below_limit_text" id="" class="form-control below-limit-text">{{$settings['below_limit_text']}}</textarea>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Below Limit Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">Hello {Name}</p>
                                       <p class="mb-0 below-example-text">{{$settings['below_limit_text']}}</p>
                                       <p class="mb-0">Only {Remaining Balance} left to be eligible for the spinner.</p>
                                    </div>
                                 </div>
                                 --}}
                                 <div class="bg-light text-center mt-5">
                                    <h4>Other Section</h4>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>New Registration Admin Mail Text </span>
                                    <textarea name="mail_text" id="" class="form-control mail_text-text">{{$settings['mail_text']}}</textarea>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>New Registration Admin Mail Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">Hello Admin, {Users Name} <span class="mail_text-example-text">{{$settings['mail_text']}}</span> </p>
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>New Registration User Text </span>
                                    <textarea name="sms_text" id="" class="form-control sms_text-text">{{$settings['sms_text']}}</textarea>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>New Registration User Text Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">Congratulations {Users Name}.Welcome to {Game Name} Gamers Club.<span class="sms_text-example-text">{{$settings['sms_text']}}</span></p>
                                    </div>
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>
                     
                     
                     <!--bulk mail start-->
                     @php
                     $bulk_mail = json_decode($settings['bulk_mail'], true);
                     @endphp
                     <div class="tab-pane fade" id="bulk-mail" role="tabpanel" aria-labelledby="profile-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>Bulk Mail Setting</h5>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 
                                 <div class="col-lg-12 col-sm-12">
                                    <span>Mail Subject</span>
                                    <input class="form-control" type="text" name="bulk_mail_subject" placeholder="Mail Subject" value="{{$bulk_mail['subject']}}">
                                 </div>
                                 <div class="col-lg-12 col-sm-12">
                                    <span>Copyright Text</span>
                                    <input class="form-control" type="text" name="copyright_text" placeholder="Mail Subject" value="{{$bulk_mail['coopyright_text']}}">
                                 </div>
                                 <div class="col-lg-12 col-sm-12">
                                    <span>App Name</span>
                                    <input class="form-control" type="text" name="app_name" placeholder="Mail Subject" value="{{$bulk_mail['app_name']}}">
                                 </div>
                                 
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Mail Message</span>
                                    <textarea name="bulk_mail_message" id="" class="form-control inactive_mail_message">{{$bulk_mail['message']}}</textarea>
                                 </div>
                                  <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Logo</span>
                                    <input class="form-control" type="file" name="bulk_mail_image" placeholder="Choose File">
                                    <div class="form-check">
                                      <input class="form-check-input" type="checkbox" name="enable_logo" id="flexCheckChecked" {{ $bulk_mail['enable_logo'] == '1' ? 'checked' : '' }}>
                                      <label class="form-check-label" for="flexCheckChecked">
                                        Enable Logo
                                    </div>
                                    
                                    <div>
                                        <img style="max-width: 100%;" src="{{asset('public/uploads/'.$bulk_mail['image'])}}">
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Background Image</span>
                                    <input class="form-control" type="file" name="background_image" placeholder="Choose File">
                                    <div>
                                        <img style="max-width: 100%;" src="{{asset('public/uploads/'.$bulk_mail['background_image'])}}">
                                    </div>
                                 </div>
                                 <div class="col-lg-6 col-md-6 col-sm-12 mt-2">
                                    <span>Inactive Mail Message Example</span>
                                    <div class="example-text">
                                       <p class="mb-0">Hello {Name}</p>
                                       <p class="mb-0 inactive-example-text">{{$bulk_mail['message']}}</p>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        
                     </div>
                     <!--bulk mail end -->
                     <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>Captcha Setting</h5>
                           </div>
                           {{--
                           <div class="card-header">{{ __('Edit Noorgamers') }}</div>
                           --}}
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Captcha</span>
                                    <select name="captcha" class="form-control">
                                    <option {{($settings['captcha']==1)?'selected':''}} value="1">On</option>
                                    <option {{($settings['captcha']==0)?'selected':''}} value="0">Off</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Captcha Type</span>
                                    <select name="captcha_type" class="form-control">
                                    <option {{($settings['captcha_type']=='custom')?'selected':''}} value="custom">Custom</option>
                                    <option {{($settings['captcha_type']=='google')?'selected':''}} value="google">Google</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>SMS Key</span>
                                    <input type="text" class="form-control" name="api_key" value="{{$settings['api_key']}}" >
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>SMS Secret</span>
                                    <input type="text" class="form-control" name="api_secret" value="{{$settings['api_secret']}}" >
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="general-setting" role="tabpanel" aria-labelledby="general-setting-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>General Setting</h5>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Theme</span>
                                    <select name="theme" class="form-control">
                                    <option {{($settings['theme']=='default')?'selected':''}} value="default">Default</option>
                                    <option {{($settings['theme']=='anna')?'selected':''}} value="anna">Anna</option>
                                    <option {{($settings['theme']=='anna2')?'selected':''}} value="anna2">Anna2</option>
                                    <option {{($settings['theme']=='cloud')?'selected':''}} value="cloud">Cloud</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Allow Same Device</span>
                                    <select name="same_device" class="form-control">
                                    <option {{($settings['same_device']==1)?'selected':''}} value="1">Yes</option>
                                    <option {{($settings['same_device']==0)?'selected':''}} value="0">No</option>
                                    </select>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Site Name</span>
                                    <input type="text" name="site_name" class="form-control" id="site-name" value="{{$settings['site_name']}}">
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Logo</span>
                                    <input type="file" name="file" class="form-control" id="image">
                                    @php
                                    $settings = \App\Models\GeneralSetting::first();
                                    $active_theme = \App\Models\Theme::where('name',$settings->theme)->first();
                                    //dd($active_theme);
                                    @endphp
                                     <img style="max-width: 100%;" src="{{asset('images/'.$settings->theme.'/'.$active_theme->logo)}}">
                                    @if($active_theme != null)
                                    @if($active_theme->logo != null)
                                    
                                    <!--@if(file_exists(base_path('images/'.$settings->theme.'/'.$active_theme->logo)))-->
                                    
                                   

                                    <!--@endif-->
                                    @endif
                                    @endif
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>
                     <div class="tab-pane fade" id="email-setting" role="tabpanel" aria-labelledby="general-setting-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>Emali Settings</h5>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Subject</span>
                                    <input type="text" name="subject" class="form-control" id="site-name" value="{{$email_setting['subject']}}" required>
                                 </div>
                                 <div class="col-lg-6 col-sm-12">
                                    <span>Message</span>
                                    <textarea name="email_message" class="form-control" id="message" required>{{$email_setting['email_message']}}</textarea>
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>
                     
                     <div class="tab-pane fade" id="gamers-games" role="tabpanel" aria-labelledby="general-setting-tab">
                        <div class="card mt-5">
                           <div class="card-header" style="padding-bottom:0">
                              <h5>Emali Settings</h5>
                           </div>
                           <div class="card-body">
                              <div class="row">
                                <div class="col-lg-6 col-12">
                                    <span>Mailing Day (Choose between 1 to 31)</span>
                                    <input type="number" class="form-control" name="gameregames_date" value="{{$gameregames['gameregames_date']}}" >
                                 </div>
                                 <div class="col-lg-6 col-12">
                                    <span>Mailing Time</span>
                                    <input type="time" class="form-control" name="gameregames_time" value="{{$gameregames['gameregames_time']}}" >
                                 </div>

                              </div>
                           </div>
                        </div>
                     </div>

               </div>
               <div class="float-end" >
                <button type="submit" class="btn btn-primary mt-2">Confirm</button>
             </div>
            </div>

         </form>


   </div>
   </div>
</div>
@endsection
@section('script')
<script>
   $('.inactive_mail_message').on('keyup',function(){
       var val = $(this).val();
       $('.inactive-example-text').text(val);
   });
   $('.above-limit-text').on('keyup',function(){
       var val = $(this).val();
       $('.above-example-text').text(val);
   });
   $('.between-limit-text').on('keyup',function(){
       var val = $(this).val();
       $('.between-example-text').text(val);
   });
   $('.below-limit-text').on('keyup',function(){
       var val = $(this).val();
       $('.below-example-text').text(val);
   });
   $('.mail_text-text').on('keyup',function(){
       var val = $(this).val();
       $('.mail_text-example-text').text(val);
   });
   $('.sms_text-text').on('keyup',function(){
       var val = $(this).val();
       $('.sms_text-example-text').text(val);
   });
   $('#email-limit').on('keyup', function(){
       alert('hello');
   })
</script>
@endsection
