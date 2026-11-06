<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\LoginLog;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Auth;
use Illuminate\Support\Carbon;
use Session;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    protected function authenticated()
    {
        if(Auth::user()->status=='0'){
            Auth::logout();
            return redirect()->route('user.index')->with('login_error', 'Your Status if Off Please Contact to Admin');
        }else{
            session()->put('log_in_time', Carbon::now());
        if(Auth::user()->role != 'admin'){
            $save_log = LoginLog::create([
                'user_id' => Auth::user()->id,
                'login_time' => Carbon::now()
            ]);
            session()->put('log_id',$save_log->id);
            // 'login_time' => Carbon::now()
        }
        $this->redirectTo = '/dashboard';
        return redirect()->route('dashboard');
        // switch (Auth::user()->role) {
        //     case 'Admin':
        //         $this->redirectTo = '/dashboard';
        //         return redirect()->route('dashboard');
        //         break;
        //     case 'cashier':
        //         $this->redirectTo = '/dashboard';
        //         return redirect()->route('dashboard');
        //         break;
        //     default:
        //         $this->redirectTo = '/dashboard';
        //         return $this->redirectTo;
        //         break;
        // }
        }
    }
    
    
    public function redirectTo()
    {
        session()->put('log_in_time', Carbon::now());
        // if(Auth::user()->role != 'admin'){
            $save_log = LoginLog::create([
                'user_id' => Auth::user()->id,
                'login_time' => Carbon::now()
            ]);
            session()->put('log_id',$save_log->id);
            // 'login_time' => Carbon::now()
        // }
        $this->redirectTo = '/dashboard';
        return $this->redirectTo;
        // switch (Auth::user()->role) {
        //     case 'admin':
        //         $this->redirectTo = '/dashboard';
        //         return $this->redirectTo;
        //         break;
        //     case 'cashier':
        //         $this->redirectTo = '/dashboard';
        //         return $this->redirectTo;
        //         break;
        //     default:
        //         $this->redirectTo = '/dashboard';
        //         return $this->redirectTo;
        //         break;
        // }
    }

    protected function logout()
    {       
        $id = session()->get('log_id');
        Session::flush();
        // dd($id);
        
        if(!empty($id)){
            $save_log = LoginLog::where('id',$id)->update(['logout_time' => Carbon::now()]);
        }
        Auth::logout();
        return redirect('login');
    }
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
