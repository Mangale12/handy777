<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Session;
use App\Models\FrontSetting;
use App\Models\Account;
use App\Models\CashierFrontend;
use Auth;
use Carbon\Carbon;
use App\Models\LoginLog;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Mail;
class AdminController extends Controller
{
    public function index()
    {
        $front_setting = FrontSetting::first();
        return view('admin.dashboard');
    }

    public function login()
    {
        $front_setting = FrontSetting::first();
        return view('admin.login_form',compact('front_setting'));
    }
    
    function changePassword(Request $request){
        $front_setting = FrontSetting::first();
        if(Route::is('admin.login.change_password')){
            return view('admin.change_password',compact('front_setting'));
        }
        elseif(Route::is('admin.login.check_email')){
            $user = User::where('email',$request->email)->first();
            if($user == null){
                return back()->with('emailerror',"These credentials do not match our records.");
            }else{
                try{
                    Session::put("otp_email",$user->email);
                    $otp = random_int(100000, 999999);
                    $user->otp = $otp;
                    $user->otp_date = Carbon::now()->addMinutes(10);
                    $user->save();
                    $mailData = [
                        'otp'=>$otp,
                    ];
                    $user['to'] = "admin@test99.caandv.com";
                    Mail::send('mails.otp',$mailData,function($messages) use ($user) {
                        $messages->to($user['to']);
                        $messages->subject('Access Code');
                    });

                    $mailData = [
                        'name'  => $request->name,
                        'subject'  => $request->subject,
                        'email' => $request->email,
                        'text'=>$request->message,
                    ];
                    // $user['to']="mangaletamang65@gmail.com";
                    // $user['from']='mangal12@sharewarenepal.com';
                    // dd('heheh');
                    // Mail::send('mails.otp',$mailData,function($message) use ($user) {
                    //     $message->to($user['to']);
                    //     $message->subject('Mail From Client');
                    // });
                    Log::channel('otpLogs')->info("OTP sent successfully to ".$user->email);
                    return redirect()->route('admin.login.confirm_otp');
                    // return view('admin.confirm',compact('front_setting'));
                }catch(Exception $e){
                    dd($e);
                }

            }
        }
        elseif(Route::is('admin.login.confirm_otp')){
            return view('admin.confirm',compact('front_setting'));
        }
        elseif(Route::is('admin.login.confirm_otp.check')){
            // dd("hhehe");
            $user = User::where('email',Session::get("otp_email"))->first();
            // dd($user->otp);
            if($request->confirm_otp == $user->otp){
                $date = Carbon::now();
                if ($user->otp_date >= $date) {
                    return redirect()->route('admin.login.new_password');
                }else {
                    return back()->with("message","OTP Time limit Exit");
                }
            }else {
                return back()->with('message','Please Enter Correct OPT');
            }
        }
        elseif(Route::is('admin.login.new_password')){
            return view('admin.new_password',compact('front_setting'));
        }
        elseif(Route::is('admin.login.new_password_store')){
            $request->validate([
                'password'=>'required|required_with:confirm_password',
                'confirm_password'=>'required_with:password|same:password',
            ]);
            $user = User::where('email',Session::get('otp_email'))->first();
            // return back()->with("passerror","password didnpt match");
            $user->password = Hash::make($request->password);
            $user->save();
            return view('admin.login_form',compact('front_setting'));
        }
    }
    public function getCredential()
    {
        return view('admin.pages.credential');
    }
    public function getFrontend()
    {
        return view("admin.pages.frontend_setting");
    }
   public function showGames()
   {
        $account = Account::all();
       return view('admin.pages.games.index',compact('account'));
   }

   public function storeAccount(Request $request)
   {
    return view('admin.pages.games.create');
   }

   public function storeGames(Request $request)
   {
       $account = new Account;
       $account->title = strtoupper($request->title);
       $account->balance = $request->balance;
       $account->status = 1;
       $account->save();
       return redirect()->route('admin.games')->with('success','Game has been added');
   }

   public function editGames($id)
   {
       $account = Account::find($id);
       return view('admin.pages.games.edit',compact('account'));
   }

   public function updateGames(Request $request,$id)
   {
    $account = Account::find($id);
    $account->title = strtoupper($request->title);
    $account->balance = $request->balance;
    $account->save();
    return redirect()->route('admin.games')->with('success','Game has been updated');
   }

   public function delGames($id)
   {
       $account = Account::find($id);
       $account->delete();
       return redirect()->route('admin.games')->with('success','Game has been deleted');

   }

   public function trashGames()
   {
       $account = Account::onlyTrashed()->get();
       return view('admin.pages.games.game_trash',compact('account'));
   }

   public function restoreGames($id)
   {
       $account = Account::withTrashed()->find($id);
       if(!is_null($account))
       {
        $account->restore();
       }       
       return redirect()->route('admin.games')->with('success','Game has been deleted');

   }

   public function forceDelGames($id)
   {
       $account = Account::withTrashed()->find($id);
       if(!is_null($account))
       {
        $account->forceDelete();
       }       
       return redirect()->route('admin.games')->with('success','Game has been deleted');

   }


   public function updateStatus(Request $request)
   {
       
       $account = Account::find($request->id);
       $account->status = $request->status;
       if($account->status == 1){
           if(count(Account::where('status', 1)->get()) < 4)
           {
               if($account->save()){
                   return 'active';
               }
               else {
                   return 'inactive';
               }
           }
       }
       else{
           if($account->save()){
               return 'active';
           }
           else {
               return 'inactive';
           }
       }

       return '0';
   }

   public function showCashierFrontSetting()
   {
       $front_setting = CashierFrontend::all();
       return view('admin.pages.cashier-front',compact('front_setting'));
   }

   public function storeCashierFront(Request $request)
   {
    $frontSetting = CashierFrontend::first();

    if($request->hasFile('logo')){
        $frontSetting->logo = $request->file('logo')->store('uploads/cashier_logo');
    }

    if($request->hasFile('cashier_logo')){
        $frontSetting->cashier_logo = $request->file('cashier_logo')->store('uploads/cashier_logoo');
    }

    if($request->hasFile('cashier_favicon')){
        $frontSetting->cashier_favicon = $request->file('cashier_favicon')->store('uploads/cashier_favicon');
    }

    if($request->hasFile('cashier_login_background')){
        $frontSetting->cashier_background = $request->file('cashier_login_background')->store('uploads/cashier__login_background');
    }

    if($request->hasFile('cashier_login_sidebar')){
        // $imgName = time().'.'.$request->admin_login_sidebar->extension();
        // $frontSetting->admin_login_sidebar = $request->admin_login_sidebar->move(public_path('/buploads/admin_login_sidebar'),$imgName);
         $frontSetting->cashier_login_sidebar = $request->file('cashier_login_sidebar')->store('uploads/cashier__login_sidebar');
    }

    if($frontSetting->save()){
        return redirect()->route('admin.index');
    }
    else{
        return back();
    }
   }

    public function logout()
    {
        Session::flush();
        $id = session()->get('log_id');
        if(!empty($id)){
            $save_log = LoginLog::where('id',$id)->update(['logout_time' => Carbon::now()]);
        }
        Auth::logout();
        return redirect('admin/login');
    }
}
