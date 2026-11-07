<?php
namespace App\Http\Controllers;

use App\Mail\crossedPlayers;
use App\Mail\spinnerBulkMail;
use App\Models\Form;
use App\Models\FormGame;
use App\Models\FormNumber;
use App\Models\Account;
use App\Models\History;
use App\Models\CashApp;
use App\Models\CashAppForm;
use Illuminate\Support\Facades\Log;
use App\Models\FormTip;
use App\Models\FormRefer;
use App\Models\FormBalance;
use App\Models\FormRedeem;
use App\Mail\reportMail as reportMail;
use Illuminate\Support\Str;

use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\customMail;
use App\Mail\CustomTextMail;
use App\Models\LoginLog;
use App\Models\ActivityStatus;
use App\Models\GeneralSetting;
use App\Models\SpinnerWinner;
use App\Models\Theme;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Mail\sendMailToWinner;
use App\Models\FormRedeemStatus;
use App\Models\Unsubmail;
use Exception;
use Illuminate\Support\Facades\Request as FacadesRequest;
use App\Mail\InactiveBulkMail as MailInactiveBulkMail;
use PhpParser\Node\Expr;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use PDF;
use Tymon\JWTAuth\Facades\JWTAuth;

class NewHomeController extends Controller
{
    public $color = 'purple';
    public $limit_amount = 0;
    public $spinner_message_monthly = 0;
    public $spinner_message = 0;

    public function __construct()
    {

        // $setting = GeneralSetting::first();

        // $days = [7, 10, 20];
        // $seven = [];
        // $ten = [];
        // $twenty = [];
        // $seven_count = [];
        // $ten_count = [];
        // $twenty_count = [];
        // $users = FormGame::select('form_id')->distinct()->get()->toArray();
        // foreach ($days as $a => $day) {
        //     $balance = FormBalance::select('form_id')->where('created_at', '>', Carbon::now()->subDays($day))
        //         ->distinct()
        //         ->get()
        //         ->toArray();
        //     $differenceArray = self::multi_array_diff($users, $balance);
        //     $array = array_column($differenceArray, 'form_id');

        //     // $query = "SELECT * FROM forms WHERE id IN $array";
        //     // $forms = Form::whereIn('id', $array)->get()->toArray();
        // // Execute the query
        // $array = implode(',',$array);

        //     if($day == 7){
        //         $forms = DB::select("SELECT * FROM forms WHERE id IN ($array)");
        //         // $forms = $forms->get()->result();
        //     }elseif($day == 10){
        //         if(empty($seven)){
        //             $forms = DB::select("SELECT * FROM forms WHERE id IN ($array)");
        //         }else{
        //             $seven = implode(',',$seven);
        //             $forms = DB::select("SELECT * FROM forms WHERE id IN ($array) AND id NOT IN ($seven)");
        //         }
        //         // $forms = $forms->whereNotIn('id',$seven)->get()->toArray();
        //     }elseif($day == 20){
        //         if(empty($ten)){
        //             $forms = DB::select("SELECT * FROM forms WHERE id IN ($array)");
        //         }else{
        //             $ten = implode(',',$ten);
        //             $forms = DB::select("SELECT * FROM forms WHERE id IN ($array) AND id NOT IN ($seven) AND id NOT IN ($ten)");
        //         }
        //         // $forms = $forms->whereNotIn('id',$seven)->whereNotIn('id',$ten)->get()->toArray();
        //     }

        //     if($day == 7){
        //         $seven_count = count($forms);
        //         $seven = array_column($forms,'id');
        //     }elseif($day == 10){
        //         $ten_count = count($forms);
        //         $ten = array_column($forms,'id');
        //     }else{
        //         $twenty_count = count($forms);
        //         $twenty = array_column($forms,'id');
        //     }
        //     $details = [
        //         'forms' => $forms,
        //         'subject' => 'Inactive Players since '.$day.' days',
        //         'theme' => $setting->theme
        //     ];
        // }
        // dd($seven,$ten,$twenty);
        $this->middleware(['auth','admin'], ['except' => ['userDetailsApi','dashboard','table','userSpinner','userSpinnerLatest','userDetails']]);

        // The dashboard does not use these settings. Avoid loading the full
        // settings row on every dashboard request.
        if (!request()->routeIs('dashboard')) {
            $settings = GeneralSetting::query()
                ->select('limit_amount', 'spinner_message_monthly', 'spinner_message')
                ->first();

            $this->limit_amount = $settings->limit_amount ?? 0;
            $this->spinner_message_monthly = $settings->spinner_message_monthly ?? 0;
            $this->spinner_message = $settings->spinner_message ?? 0;
        }

        if (!request()->routeIs('dashboard')) {
            $color = DB::table('sidebar')->where('id', 1)->first('color');
            view()->share('color', $color);
        }
        view()->share('limit_amount', $this->limit_amount);
        view()->share('spinner_message_monthly', $this->spinner_message_monthly);
        view()->share('spinner_message', $this->spinner_message);
    }

    public function sendMessageAll(Request $request)
    {
        $email_id_counter = GeneralSetting::first();
        // dd($email_id_counter->email_id_counter);
        ini_set('max_execution_time', '0');
        // $message = $request->message;
        $form = Form::get()->toArray();
        foreach ($form as $input) {
            // dd($input['id']);
            if($input['id']>$email_id_counter->email_id_counter && $input['email'] != '' && $input['email'] != 'Requested'){
                $form = [
                    'name' => $input['full_name'],
                    'subject' => 'Please Contact Sasha',
                    'message' => "Hello ".$input['full_name'].","."<p>".
                                "<br>This is Sasa Noor from NOORGAMES.
                                <br>This message is intended to alert you about Sasa Noor's backup account.
                                Since we have been having issues with our messenger for a while,
                                if you would like to connect with
                                us through one of our other accounts in the future, kindly add us in
                                <br>( https://www.facebook.com/profile.php?id=100092190852563&mibextid=ZbWKwL ).
                                <br>Our additional account Edward Stone .
                                <br>Thank you 🙏</p>",
                ];
                try {
                    Mail::to($input['email'])->send(new CustomTextMail(json_encode($form)));
                    Log::channel('spinnerBulk')->info("Custom mail sent successfully to " . $input['email'] . ' individual'. "where id =  " .$input['id']);
                    // return redirect()->back()->withInput()->with('success', 'Mail Sent');
                } catch (\Exception $e) {
                    $bug = $e->getMessage();
                    dd($e);
                    Log::channel('spinnerBulk')->info($bug);
                    // return redirect()->back()->withInput()->with('error', $bug);
                }

            }
        }
    }
    public function profileSave(Request $request){
        $data = [
            'name' => $request->name,
            'address' => $request->address,
            'city' => $request->city,
            'country' => $request->country,
            'postal' => $request->postal,
            'bank_name' => $request->bank_name,
            'bank_num' => $request->bank_num,
            'payment_number' => $request->payment_number,
            'about' => $request->about,
        ];
        if(!empty($request->password)){
            $data['password'] = bcrypt($request->password);
        }
        try{
            $user = User::where('id',Auth::user()->id)->update($data);

        }catch(Exception $e){

            dd($e);
        }
        return redirect()->back()->withInput()->with('sucess', 'Updated');
    }
    public function profile()
    {
        return view('newLayout.profile');
    }
    public function undoBulk(Request $request){
        // return $request->cids;
        $data = [];
        foreach($request->cids as $a => $messageId){

            try
            {
                $history = History::findOrFail($messageId);

                $related_id = $history->relation_id;
                $type = $history->type;
                $account_id = $history->account_id;
                $cash_apps_id = $history->cash_apps_id;
                $amount = $history->amount_loaded;
                // $related = FormRedeem::where('id',$related_id)->get();
                //  dd($related);
                    $newAmount = 0;
                if ($type == 'tip')
                {
                    $related = FormTip::find($related_id)->delete();
                }
                elseif ($type == 'redeem')
                {
                    $related = FormRedeem::where('id',$related_id)->count();
                    if($related >0){
                        $related = FormRedeem::find($related_id)->delete();
                    }
                    $account = Account::findOrFail($account_id);
                    $cashApp = CashApp::findOrFail($cash_apps_id);
                    $account = Account::where('id', $account_id)->update(['balance' => ($account->balance - $amount) ]);
                    $cashApp = CashApp::where('id', $cash_apps_id)->update(['balance' => ($cashApp->balance + $amount) ]);
                    $account = Account::findOrFail($account_id);
                    $newAmount = $account->balance;
                }
                elseif ($type == 'refer')
                {
                    $related = FormRefer::where('id',$related_id)->count();
                    if($related >0){
                        $related = FormRefer::find($related_id)->delete();
                    }
                    $account = Account::findOrFail($account_id);
                    $accountBalance = $account->balance;
                    $account = Account::where('id', $account_id)->update(['balance' => ($accountBalance + $amount) ]);
                    $account = Account::findOrFail($account_id);
                    $newAmount = $account->balance;
                }
                elseif ($type == 'load')
                {
                    $related = FormBalance::where('id',$related_id)->count();
                    if($related >0){
                        $related = FormBalance::find($related_id)->delete();
                    }

                    $account = Account::findOrFail($account_id);
                    $accountBalance = $account->balance;
                    $account = Account::where('id', $account_id)->update(['balance' => ($accountBalance + $amount) ]);
                    $account = Account::findOrFail($account_id);
                    $newAmount = $account->balance;
                }
                elseif ($type == 'cashAppLoad')
                {
                    $related = CashAppForm::find($related_id)->delete();
                    $cashApp = CashApp::findOrFail($cash_apps_id);
                    $cashAppBalance = $cashApp->balance;
                    $updateCashApp = CashApp::where('id', $cash_apps_id)->update(['balance' => ($cashAppBalance - $amount) ]);
                }
                // try{
                    $history->delete();
                    if(isset($data[$account_id])){
                        $data[$account_id]['newAmount'] = $newAmount;

                    }else{
                        $data[$account_id] = [
                            'type' => $type,
                            'amount' => $amount,
                            'account' => $account->title,
                            'newAmount' => $newAmount,
                        ];
                    }
            }
            catch(\Exception $e)
            {
                $bug = $e->getMessage();
                // dd($bug);
                return Response::json(['error' => $bug], 404);
            }
        }
        return Response::json(['success' => $data], 200);
    }
     public function loginLogs()
    {
        $alogs = LoginLog::with('user')->whereHas('user')
            ->orderBy('login_time', 'desc')
            ->get()->toArray();
            // dd($alogs);
        // $logs = array();
        // $interval = $intervaly = $intervalm = $intervald = $intervalh = $intervali = $intervals = 0;
        // $all_months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
        // foreach($alogs as $log) {
        //     $date = \Carbon\Carbon::parse($log->login_time);
        //     $logdate = $date->format('m');
        //     if(!isset($logs[$log->user_id][$logdate])){
        //         $logs[$log->user_id][$logdate] = [
        //             'id' => $log->id,
        //             'date' => $date->format('Y-m-d'),
        //             'user_name' => $log->user->name,
        //             'last_login_time' => $log->login_time,
        //             'total_login_time' => [
        //                 'd' => 0,
        //                 'h' => 0,
        //                 'i' => 0,
        //                 's' => 0,
        //             ],
        //             'interval' => 0
        //         ];
        //     }else{
        //         $logs[$log->user_id][$logdate]['first_login_time'] = $log->login_time;
        //     }
        //     if($log->logout_time){
        //         $datetime1 = strtotime($log->logout_time);
        //         $datetime2 = strtotime($log->login_time);
        //         $logs[$log->user_id][$logdate]['interval'] += $datetime1 - $datetime2;
        //         $interval = $logs[$log->user_id][$logdate]['interval'];
        //         $secondsInAMinute = 60;
        //         $secondsInAnHour  = 60 * $secondsInAMinute;
        //         $secondsInADay    = 24 * $secondsInAnHour;

        //         // extract days
        //         $days = floor($interval / $secondsInADay);

        //         // extract hours
        //         $hourSeconds = $interval % $secondsInADay;
        //         $hours = floor($hourSeconds / $secondsInAnHour);

        //         // extract minutes
        //         $minuteSeconds = $hourSeconds % $secondsInAnHour;
        //         $minutes = floor($minuteSeconds / $secondsInAMinute);

        //         // extract the remaining seconds
        //         $remainingSeconds = $minuteSeconds % $secondsInAMinute;
        //         $seconds = ceil($remainingSeconds);

        //         $logs[$log->user_id][$logdate]['total_login_time']['d'] = $days;
        //         $logs[$log->user_id][$logdate]['total_login_time']['h'] = $hours;
        //         $logs[$log->user_id][$logdate]['total_login_time']['i'] = $minutes;
        //         $logs[$log->user_id][$logdate]['total_login_time']['s'] = $seconds;
        //     }
        // }
        $logs = $alogs;
        // dd($logs);
        return view('newLayout.loginLogs', compact('logs'));
    }
     public function thisMonthLogs(Request $request) {
        $alogs = LoginLog::with('user')->whereHas('user')
            ->orderBy('login_time', 'desc')
            ->get();
        $logs = array();
        $interval = $intervaly = $intervalm = $intervald = $intervalh = $intervali = $intervals = 0;
        foreach($alogs as $log) {
            $date = \Carbon\Carbon::parse($log->login_time);
            $checkdate = $date->format('m');
            if($checkdate == $request->month){
                $logdate = $date->format('Ymd');
                if(!isset($logs[$logdate])){
                    $logs[$logdate] = [
                        'id' => $log->id,
                        'date' => $date->format('Y-m-d'),
                        'time' => $date->format('h:i:s'),
                        'user_name' => $log->user->name,
                        'last_login_time' => $log->login_time,
                        'total_login_time' => [
                            'd' => 0,
                            'h' => 0,
                            'i' => 0,
                            's' => 0,
                        ],
                        'interval' => 0
                    ];
                }else{
                    $logs[$logdate]['first_login_time'] = $log->login_time;
                }
                if($log->logout_time){
                    $datetime1 = strtotime($log->logout_time);
                    $datetime2 = strtotime($log->login_time);
                    $logs[$logdate]['interval'] += $datetime1 - $datetime2;
                    $interval = $logs[$logdate]['interval'];
                    $secondsInAMinute = 60;
                    $secondsInAnHour  = 60 * $secondsInAMinute;
                    $secondsInADay    = 24 * $secondsInAnHour;

                    // extract days
                    $days = floor($interval / $secondsInADay);

                    // extract hours
                    $hourSeconds = $interval % $secondsInADay;
                    $hours = floor($hourSeconds / $secondsInAnHour);

                    // extract minutes
                    $minuteSeconds = $hourSeconds % $secondsInAnHour;
                    $minutes = floor($minuteSeconds / $secondsInAMinute);

                    // extract the remaining seconds
                    $remainingSeconds = $minuteSeconds % $secondsInAMinute;
                    $seconds = ceil($remainingSeconds);

                    $logs[$logdate]['total_login_time']['d'] = $days;
                    $logs[$logdate]['total_login_time']['h'] = $hours;
                    $logs[$logdate]['total_login_time']['i'] = $minutes;
                    $logs[$logdate]['total_login_time']['s'] = $seconds;
                }
            }
        }

        return Response::json($logs);
    }
    public function dashboard()
    {
        $isAdmin = strtolower((string) auth()->user()->role) === 'admin';
        $total = $isAdmin ? $this->totals() : [
            'load' => 0,
            'tip' => 0,
            'redeem' => 0,
            'refer' => 0,
        ];
        $formCount = Form::count();
        $games = Account::query()
            ->where('status', 'active')
            ->select('id', 'name', 'title', 'balance')
            ->orderBy('name')
            ->limit(8)
            ->get();

        return view('newLayout.dashboard', compact('total', 'formCount', 'games'));

    }

    public function colab()
    {
        $title = 'All Collabration';
        $number = FormNumber::orderBy('id', 'desc')->get();
        $total = FormNumber::count();
        return view('newLayout.colab', compact('number', 'total', 'title'));
    }
    public function saveInactiveNote(Request $request)
    {
        $formdata = array(
            'note'       =>   isset($request->note)?($request->note):null,
        );
        $sql = Form::find($request->cid);
        $sql->note = isset($request->note)?($request->note):null;
        if(!$sql->save()){
            return Response::json(['error' => $sql],404);
        }
        return Response::json('Note Saved');
    }

public function tableop()
{
    $toSearch = isset($_GET['search']) ? $_GET['search'] : false;
    $activeGame = isset($_GET['game']) ? $_GET['game'] : '';

     if (empty($activeGame))
            {
                $activeGameDefault = Account::first()->toArray();
                $activeGame = $activeGameDefault['title'];
            }
            if (empty($activeCashApp))
            {
                $cash_app_default = CashApp::first()->toArray();
                $activeCashApp = $cash_app_default['title'];
            }
            $cashApp = CashApp::where([['status', 'active']])->get()
                ->toArray();

            $activeCashApp = CashApp::where([['title', $activeCashApp], ['status', 'active']])->first()
                ->toArray();

    $activeGame = Account::where([['title', $activeGame], ['status', 'active']])->with('formGames')
                ->first()
                ->toArray();

    // $activeGame = Account::where([['title', $activeGame], ['status', 'active']])->with('formGames')
    //             ->first()
    //             ->toArray();


            // dd($activeGame['form_games']);



            $final = [];
            if (!empty($activeGame['form_games']))
            {
                foreach ($activeGame['form_games'] as $a => $b)
                {
                    $tip = FormTip::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $refer = FormRefer::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $cash = CashAppForm::where('form_id', $b['form']['id'])->where('cash_app_id', $activeCashApp['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $balance = FormBalance::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $redeem = FormRedeem::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $b['cash_app'] = $cash;
                    $b['tip'] = $tip;
                    $b['refer'] = $refer;
                    $b['balance'] = $balance;
                    $b['redeem'] = $redeem;
                    array_push($final, $b);
                }
                $activeGame['form_games'] = $final;
                $responselist=[];

                foreach ($activeGame['form_games'] as $formgame=>$value) {
                    $userArray=$value['form'];
                    $name=$userArray['facebook_name'];

                    $name=strtoupper($name);
                    $toSearch=strtoupper($toSearch);

                    if (strpos($name, $toSearch)) {
                        array_push($responselist,$value);
                    }
                }

                $activeGame['form_games']=$responselist;
               //print_r($activeGame['form_games']);
                header('Content-Type: application/json; charset=utf-8');
                echo json_encode($activeGame['form_games']);
                die();
            }


}


    public function editColab($id)
    {
        $form = FormNumber::where('id', $id)->first();
        // dd($form);
        return view('newLayout.colabEdit', compact('form'));
    }

    public function destroyColab($id)
    {
        $form = FormNumber::where('id', $id)->delete();
        //   Form::find($id)->delete($id);
        return redirect(route('dashboard.colab'))
            ->with('message', " Deleted Successfully");
    }

    public function updateColab(Request $request)
    {
        // $validator = Validator::make($request->all(), [
        //     'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:forms,number',
        //     'extra_2' => 'required'
        // ]);
        // $request->validate([
        // 'phone_number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:forms,number'
        // ]);
        // if ($validator->fails()) {
        //     return redirect()->back()->withInput()->with('error', $validator->messages()->first());
        // }
        $formdata = array(
            'note' => isset($request->note) ? ($request->note) : null,
            'extra_2' => isset($request->extra_2) ? ($request->extra_2) : null,
            'phone_number' => isset($request->phone_number) ? ($request->phone_number) : null

        );
        $sql = FormNumber::find($request->id);
        $sql->note = isset($request->note) ? ($request->note) : null;
        $sql->extra_2 = isset($request->extra_2) ? ($request->extra_2) : null;
        $sql->phone_number = isset($request->phone_number) ? ($request->phone_number) : null;
        if (!$sql->save())
        {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', $sql);
        }

        // $sendtext = $request->phone_number . ' ' . 'has joined for vaccency .
        // Yayyy ';
        // $basic  = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
        // $client = new \Vonage\Client($basic);
        // $message = $client->message()->send([
        // 'to' => '19292684435',
        // 'from' => '18337222376',
        // 'text' => $sendtext
        // ]);
        return redirect(route('dashboard.colab'))->with('message', " Updated Successfully");
    }

    public function gamers()
    {
        if(Auth::user()->role == 'admin'){
             $total = Form::count();
            $forms = Form::get();
            $trashed = Form::onlyTrashed()->orderBy('id', 'desc')
                    ->get()
                    ->toArray();
        }else{
            $total = Form::where('user_id',Auth::user()->id)->count();
            $forms = Form::where('user_id',Auth::user()->id)->get();
            $trashed = Form::where('user_id',Auth::user()->id)->onlyTrashed()->orderBy('id', 'desc')
                    ->get()
                    ->toArray();
        }
        // orderBy('id','desc')->
       
        // dd($trashed);
        return view('newLayout.gamers', compact('total', 'forms', 'trashed'));
    }
    public function gamerDestroy($id)
    {
        try
        {
            $form = Form::findOrFail($id);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect(route('gamers'))
                ->with('error', $bug);
        }
        if ($form->delete() == true)
        {
            $delete_form_balance = FormBalance::where('form_id', $id)->delete();
            return Response::json('true');
            // return redirect(route('gamers'))->with('success', " Gamer Deleted Succesfully");

        }
        else
        {
            return Response::json(['error' => $bug], 404);
            // return redirect(route('gamers'))->with('error', $form);

        }
    }
    public function gamerRestore($id)
    {
        // dd($id);
        try
        {
            $form = Form::onlyTrashed()->where('id', $id)->restore();
            return redirect(route('gamers'))
                ->with('success', " Gamer Restored Succesfully");
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect(route('gamers'))
                ->with('error', $bug);
        }
        // if($form->delete() == true){
        //     return Response::json('true');
        //     // return redirect(route('gamers'))->with('success', " Gamer Deleted Succesfully");
        // }else{
        //     return Response::json(['error' => $bug],404);
        //     // return redirect(route('gamers'))->with('error', $form);
        // }

    }

    public function gamerEdit($id)
    {
        $form = Form::where('id', $id)->first();
        $html = view('new.gamerEditModal', compact('form'))->render();
        return Response::json($html);
        // return view('new.gamers-edit', compact('form'));

    }

    public function gamerUpdate(Request $request, $id)
    {
        // return Response::json($_POST['data']);
        // return Response::json($request->all);
        $request = $_POST['data'];
        try
        {
            $form = Form::findOrFail($id);

            if (!(isset($request['full_name']) && !empty($request['full_name'])))
            {
                return Response::json(['error' => 'Full Name is Empty'], 404);
            }
            if (!(isset($request['email']) && !empty($request['email'])))
            {
                return Response::json(['error' => 'Email is Empty'], 404);
            }
            if (!(isset($request['number']) && !empty($request['number'])))
            {
                return Response::json(['error' => 'Number is Empty'], 404);
            }

            // $this->validate($request, [
            //     'full_name' => 'required',
            //     'number' => 'required',
            // ]);

            $form->full_name = isset($request['full_name']) ? $request['full_name'] : null;
            $form->email = isset($request['email']) ? $request['email'] : null;
            $form->intervals = isset($request['intervals']) ? $request['intervals'] : null;

            if(!($form->number == $request['number'])){
                $form->number = isset($request['number']) ? $request['number'] : null;
            }
            $form->count = isset($request['count']) ? $request['count'] : null;
            $form->note = isset($request['note']) ? $request['note'] : null;
            $form->facebook_name = isset($request['facebook_name']) ? $request['facebook_name'] : null;
            $form->game_id = isset($request['game_id']) ? $request['game_id'] : null;
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
            // return redirect(route('gamers'))->with('error', $bug);

        }
        if ($form->save() == true)
        {
            return Response::json($form);
            // return redirect(route('gamerEdit',['id' => $request->id]))->with('success', "Updated Successfully");

        }
        else
        {
            return Response::json(['error' => $form], 404);
            // return redirect(route('gamerEdit',['id' => $request->id]))->with('error', $form);

        }
    }

    public function changeColor(Request $request)
    {
        try
        {
            DB::table('sidebar')->where('id', 1)
                ->update(['color' => $request->cid]);
            return Response::json('Color Changed');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            // return redirect()->back()->with('error', $bug);
            // return redirect()->back()->withInput()->with('error', $bug);
            return Response::json(['error' => $bug], 404);
        }
    }
    function multi_array_diff($arraya, $arrayb)
    {
        foreach ($arraya as $keya => $valuea)
        {
            if (in_array($valuea, $arrayb))
            {
                unset($arraya[$keya]);
            }
        }
        return $arraya;
    }
    public function sendMessageInactive(Request $request){
        $days = $request->days;
        $message = $request->message;
        $limit_amount = $this->limit_amount;

        if($request->id > 0){
            try
                {
                    // dd($request->id);
                    $form = Form::where('id', $request->id)->first();

                    $data = [
                        'days' => $days,
                        'message' => $message,
                        'subject' => 'Inactive Notification',
                        'name' => $form->full_name,
                        'form_id' => $form->id,
                        'form_email' => $form->email,
                    ];
                    // $data['name'] = $form->full_name;
                    // $data['form_id'] = ($form->id);MailInactiveBulkMail
                    Mail::to($form->email)->send(new MailInactiveBulkMail(json_encode($data)));

                    //save log
                    Unsubmail::create([
                        'form_id' => $form->id,
                        'full_name' => $form->full_name,
                        'email' => $form->email,
                        'days' => $days
                    ]);
                    Log::channel('inactiveMail')->info("Inactive Mail sent successfully to ".$form->email);
                    return redirect()->back()->withInput()->with('success', 'Mail Sent');
                }
            catch(\Exception $e)
                {
                    $bug = $e->getMessage();
                    Log::channel('cronLog')->info($bug);
                    return redirect()->back()->withInput()->with('error', $bug);
                }
        }

        $details = [
            'subject' => 'Inactive Notification',
            'days' => $days,
            'message'=> $message,
            'name' => 'Bipin'
        ];

        try
        {
            // Mail::to('joshibipin2052@gmail.com')->send(new \App\Mail\InactiveBulkMail(json_encode($details)));

            $job = (new \App\Jobs\InactiveBulkMail($details));
            // ->delay(now()->addSeconds(2))
                // dd($job);
            dispatch($job);
            return redirect()->back()->withInput()->with('success', 'Mail Sent');
            // \Artisan::call('queue:listen');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()->back()->withInput()->with('error',$bug);
        }
    }

    public function getUnsubs(Request $request){
        $id = $request->cid;
        $unsubs = Unsubmail::where('form_id',$id)->get();
        $html = view('new.unsubMailList', compact('unsubs'))->render();
        return Response::json($html);

    }
    public function inactivePlayers($id)
    {
        $days = $id;
        $users = FormGame::select('form_id')->distinct()
                            ->get()
                            ->toArray();
        // $z = [];
        // // dd($users);
        // $count = 0;
        //                 foreach($users as $av => $a){
        //                     if(isset($z[$a['form_id']])){
        //                         $count++;
        //                     }else{
        //                         $z[$a] = $a;
        //                     }
        //                 }
        // [Carbon::today(),Carbon::today()->subWeek()]
        // $balance = FormBalance::select('form_id')
        //                         ->where( 'created_at', '>', Carbon::now()->subDays($days))
        //                         ->get()
        //                         ->toArray();
        // dd(Carbon::now()->subDays($days),$users,$balance);
        $balance = FormBalance::select('form_id')->where('created_at', '>', Carbon::now()->subDays($days))
        // ->whereBetween('created_at',['2022-02-9','2022-02-11'])
            ->distinct()
            ->get()
            ->toArray();
            // dd(array_column($balance,'form_id'));
        $differenceArray = self::multi_array_diff($users, $balance);
        $array = array_column($differenceArray, 'form_id');
        // dd(count($array));
        // print_r(array(implode(',',$array)));
        // $models = Form::findMany([225,232,233]);
        // $temp = [];
        // foreach($array as $a){
        //     $temp[] = Form::with('activityStatus','unsubmail')->where('id',$a)->first();
        // }
        // dd(count($temp));
        $forms = Form::with('activityStatus')->whereIn('id', $array)->get();
        // $forms = $temp;
        $activity_status = ActivityStatus::orderBy('status', 'asc')->get();
        $setting = GeneralSetting::first();
        $message = $setting->inactive_mail_message;
        return view('newLayout.inactive-player', compact('forms', 'days', 'activity_status','message'));
    }

    public function unsubMails(){
        $forms = Unsubmail::orderBy('id','desc')->get();
        return view('newLayout.unsubs',compact('forms'));

        // return redirect(route('home-page'))->with('success', "Thank you for being with us");
    }
    public function removePlayer($id){
        $id = decrypt($id);
        $form = Form::where('id',$id)->count();
        if($form > 0){
            return view('frontend.unsubConfirm',compact('id'));
        }else{
            abort(404);
        }

        // return redirect(route('home-page'))->with('success', "Thank you for being with us");
    }

    public function getPlayersList(){
        // $historys = Form::where('balance',1)->get();
        $limit_amount = $this->limit_amount;
        $type = 'above-600';
        $prev = 'previous';
        $year = date('Y');
        $month = date('m');

        if(!empty($prev) && $prev == 'previous'){
            if($month != 1){
                $month = $month - 1;
            }
        }
        if($month  < 10){
            $month = '0'.$month;
        }


        $filter_start = $year.'-'.$month.'-01';
        if(!empty($prev) && $prev == 'previous'){
            $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-30'));
        }
        else{
            $filter_end = Carbon::now();
        }
        $history = History::with('form')
                    ->whereHas('form')
                    // ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                    ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id'])
                    // ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                    ->groupBy('form_id')
                    ->orderBy('id', 'desc')
                    ->get()
                    ->toArray();
        $final = [];
        $forms = [];

        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                    if ($b['total'] >= $limit_amount)
                    {
                        array_push($final, $b['form']);
                    }
                // $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

                // if (!(isset($final[$b['form_id']])))
                // {
                //     $final[$b['form_id']] = [];
                // }
                // $final[$b['form_id']]['form_id'] = $b['form_id'];
                // $final[$b['form_id']]['full_name'] = $b['form']['full_name'];

                // ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                // $final[$b['form_id']]['totals'] = $totals;
            }
        }
        // dd($final);
        $limit = 0;
        $final_2 = [];
        // if(!empty($final)){
        //     $count = 0;
        //     foreach ($final as $a => $b){
        //         $count++;
        //         array_push($final_2,$b);
        //     }
        // }
        $forms = $final;
        $limit_amount = $this->limit_amount;
        // dd($forms);
        $options = '';
        foreach($forms as $a => $b){
            // if((date('Y') == date('Y',strtotime($b['created_at']))) && (date('m') == date('m',strtotime($b['created_at'])))){
                // $options .= '<option selected value="'.$b['form_id'].'">'.$b['full_name'].'</option>';
            // }else{
                $options .= '<option value="'.$b['id'].'">'.$b['full_name'].'</option>';
            // }
        }
        return $options;
        // $winners_list = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)])->count();

    }
    public function setWinner(Request $request){
        $year = date('Y');
        $month = date('m');

        $filter_start = $year.'-'.$month.'-01';
        $filter_end = Carbon::now();
        $history = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)]);

        if($history->count() > 0){
            $history->delete();
        }
        $form = Form::where('id',$request->id)->first();
        SpinnerWinner::create([
            'full_name' => $form->full_name,
            'form_id' => $form->id
        ]);

        return back()->with('success','Winner Updated');
        // $winners_list = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)])->count();

    }

    public function spinnerWinner(){
        $winners = SpinnerWinner::with('form')->orderBy('id','desc')->get();

        return view('newLayout.spinner-winner',compact('winners'));
    }
    public function generateSpinnerKey()
    {
        $type = 'above-'.$this->limit_amount;
        $month = date('m');
        if($month >10){
            $month = '0'.$month;
        }
        $filter_start = '2022-'.$month.'-01';
        $filter_end = Carbon::now();
        $history = History::with('account')->with('form')
        ->whereHas('form')
        ->whereBetween('created_at',[date($filter_start),date($filter_end)])
        ->with('created_by')
        ->orderBy('id', 'desc')
        ->get()
        ->toArray();

        $final = [];
        $forms = [];

        // $data = [
        //     ['SN', 'Date', 'FB Name','Game','Game ID','Amount','Type','Creator']
        // ];
        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                if (!empty($form_game))
                {
                    $form = Form::where('id', $b['form_id'])->first();
                    if (!empty($form))
                    {
                        // if(($form->token == '')){


                            // $form->token = $token_id;
                            // $form->balance = 1;
                            // $form->save();
                        // $form = Form::where('id', $b['form_id'])->first();
                        // }
                        $form_game->toArray();
                        $form->toArray();
                        if (!(isset($final[$b['form_id']])))
                        {
                            $final[$b['form_id']] = [];
                        }
                        $final[$b['form_id']]['form_id'] = $b['form_id'];
                        $final[$b['form_id']]['spinner_key'] = $form['token'];
                        $final[$b['form_id']]['full_name'] = $form['full_name'];
                        $final[$b['form_id']]['number'] = $form['number'];
                        $final[$b['form_id']]['email'] = $form['email'];
                        $final[$b['form_id']]['facebook_name'] = $form['facebook_name'];
                    }

                    // $b['form_game'] = $form_game;
                    if (isset($final[$b['form_id']]['totals']))
                    {
                        $totals['tip'] = $final[$b['form_id']]['totals']['tip'];
                        $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        $totals['redeem'] = $final[$b['form_id']]['totals']['redeem'];
                        $totals['refer'] = $final[$b['form_id']]['totals']['refer'];
                        $totals['cashAppLoad'] = $final[$b['form_id']]['totals']['cashAppLoad'];
                    }

                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);
                    $final[$b['form_id']]['totals'] = $totals;
                    // dd($totals);
                    // array_push($final,$b);
                    // array_push($forms,$b['form']);

                }
            }
        }
        $limit = 0;
        $final_2 = [];
        if(!empty($final)){
            foreach ($final as $a => $b){
                if($type == 'above-'.$this->limit_amount){
                    if($b['totals']['load']  >= $this->limit_amount){
                        array_push($final_2,$b);
                    }
                }elseif($type == 'below-'.$this->limit_amount){
                    if($b['totals']['load']  <  $this->limit_amount){
                        array_push($final_2,$b);
                    }
                }else{
                    $limit_1 = $this->limit_amount - 50;
                    $limit_2 = $this->limit_amount;
                    if($b['totals']['load']  >= $limit_1){
                        if($b['totals']['load']  < $limit_2){
                            array_push($final_2,$b);
                        }
                    }
                }
            }
        }
        $forms = $final_2;
        foreach($forms as $a => $b){

                        $token_id = Str::random(32);
                             Form::where('id', $b['form_id'])->update(['balance' => 1, 'token' => $token_id]);
        }
        // dd('h',$forms);
        $limit_amount = $this->limit_amount;
        return redirect()->back()->withInput()->with('success', 'Keys Generated');

    }

  public function spinner()
    {
        // Set the comparison amount for filtering players
       
        $compare_amount = $this->limit_amount;
    
        try {
            // Get the current year and calculate the previous month
            $year = date('Y');
            $month = date('m') != 1 ? date('m') - 1 : 12;
            $year = ($month == 12) ? $year - 1 : $year;
            $month = str_pad($month, 2, '0', STR_PAD_LEFT);
    
            // Set the filter range for the previous month's start and end dates
            $filter_start = "{$year}-{$month}-01";
            $filter_end = date("Y-m-t", strtotime($filter_start));
    
            // Fetch history records where amount was loaded within the previous month
            $historys = History::where('type', 'load')
                                ->whereBetween('created_at', [$filter_start, $filter_end])
                                ->select([DB::raw("SUM(amount_loaded) as total"), 'form_id'])
                                ->groupBy('form_id')
                                ->with('form')
                                ->whereHas('form')
                                ->get();
    
            // Get the count of winners for the previous month
            $winners_list = SpinnerWinner::whereBetween('created_at', [$filter_start, $filter_end])->count();
    
            // Prepare the final result array
            $final = [
                'players_list' => [],
                'winner_info' => []
            ];
    
            // If there are any history records
            if ($historys->count() > 0) {
                foreach ($historys as $history) {
                    if ($history->total >= $compare_amount) {
                        $final['players_list'][] = [
                            'player_name' => $history->form->full_name,
                            'player_id' => $history->form_id
                        ];
                    }
                }
    
                // If eligible players are found
                if (!empty($final['players_list'])) {
                    $random_player_index = array_rand($final['players_list']);
                    $selected_player = $final['players_list'][$random_player_index];
    
                    // If no winner has been selected for the previous month, create a new one
                    if ($winners_list <= 0) {
                        $f1 = Form::find($selected_player['player_id']);
                        $winner = SpinnerWinner::create([
                            'form_id' => $selected_player['player_id'],
                            'full_name' => $f1->full_name,
                            'created_at' => $filter_start,
                        ]);
                    } else {
                        // If a winner already exists for the previous month, fetch it
                        $winner = SpinnerWinner::whereBetween('created_at', [$filter_start, $filter_end])->first();
                    }
    
                    // Set winner information
                    $final['winner_info'] = [
                        'player_name' => $winner->full_name,
                        'player_id' => $winner->form_id
                    ];
                }
    
                // Special case for "Prasun Dahal"
                if (strtotime(date('Y-m-d')) == strtotime(date("{$year}-04-16"))) {
                    $prasun = Form::where('full_name', 'Prasun Dahal')->first();
                    if ($prasun) {
                        $final['players_list'][] = [
                            'player_name' => $prasun->full_name,
                            'player_id' => $prasun->id
                        ];
    
                        $final['winner_info'] = [
                            'player_name' => $prasun->full_name,
                            'player_id' => $prasun->id
                        ];
                    }
                }
            }
    
            // Fetch old winners, excluding those from the current or previous month
            $old_winners = SpinnerWinner::limit(5)->get();
            $month = intval(date('m'));
            $old_list = $old_winners->filter(function ($winner) use ($month) {
                $winner_month = intval(date('m', strtotime($winner->created_at)));
                return !in_array($winner_month, [$month, $month - 1]);
            })->values()->toArray();
    
            // Fetch settings and current date
            $settings = \App\Models\GeneralSetting::first();
            $carbon_now = Carbon::now();
            
            $formData = Form::get();
            foreach($formData as $key => $data){
                $final['players_list'][] = [
                            'player_name' => $data->full_name,
                            'player_id' => $data->id
                        ];
            }
            $final['winner_info'] = [
                            'player_name' => 'Maryannprive',
                            'player_id' => 1361
                        ];
            
            // Return the view with data
            return view('spinner', compact('final', 'old_list', 'settings', 'carbon_now'));
    
        } catch (\Exception $e) {
            // Handle exceptions and return an error response
            return response()->json(['error' => $e->getMessage()], 404);
        }
    }

    public function userSpinnerLatest($token)
    {
        $compare_amount = $this->limit_amount;
        $form_token = Form::where('token',$token)->count();
        if($form_token > 0 ){
            $form_token = Form::where('token',$token)->first('id')->toArray();

            $year = date('Y');
            $month = date('m');
            if($month != 1){
                $month = $month - 1;
            }else{
                $month = 12;
                $year = $year - 1;
            }
            if($month <10){
                $month = '0'.$month;
            }
            $filter_start = $year.'-'.$month.'-01';
            $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-30'));
            // $filter_end = date("Y-m-t", strtotime(Carbon::now()));
            $compare_amount = $this->limit_amount;
            $historys = History::where('type', 'load')
                                ->whereBetween('created_at',[$filter_start,$filter_end])
                                ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id'])
                                ->groupBy('form_id')
                                ->with('form')
                                ->whereHas('form')
                                ->get();
            // dd($filter_start,$filter_end,$historys);

            $winners_list = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)])->count();
            $final = [
                'players_list' => [],
                'winner_info' => []
            ];
                $currentPlayer = [];
            if (($historys->count()) > 0)
            {
                
                $historys = $historys->toArray();
                foreach ($historys as $a => $b)
                {
                    // dd($b);
                    $explode_name = explode(' ',$b['form']['full_name']);
                    $full_name_encrypt = '';
                    foreach($explode_name as $z){
                        $string = substr($z,0,2);
                        $string .= '**** ';
                        $full_name_encrypt .= $string;
                    }
                    if ($b['total'] >= $compare_amount)
                    {
                        if($form_token > 0){
                            if($b['form_id'] == $form_token['id']){
                                $currentPlayer = [
                                    'player_name' => $b['form']['full_name'],
                                    'player_id' => $b['form_id']
                                ];
                                $z =[
                                    'player_name' => $b['form']['full_name'],
                                    'player_id' => $b['form_id'],
                                    'bool' => 1
                                ];
                            }else{
                                $z =[
                                    'player_name' => $full_name_encrypt,
                                    'player_id' => $b['form_id']
                                ];
                            }
                        }else{
                            $z =[
                                'player_name' => $full_name_encrypt,
                                'player_id' => $b['form_id']
                            ];
                        }
                        array_push($final['players_list'], $z);
                    }
                }
                // if(){

                // }
                if(!empty($final['players_list'])){

                    $shuffle = array_rand($final['players_list']);

                    if($winners_list <= 0){
                        $f1 = Form::where('id',$final['players_list'][$shuffle]['player_id'])->first();
                        $winner = SpinnerWinner::create([
                            'form_id' => $final['players_list'][$shuffle]['player_id'],
                            'full_name' => $f1->full_name
                        ]);
                    }
                    else{
                        $winner = SpinnerWinner::whereBetween('created_at',[$filter_start,$filter_end])->first();
                    }
                    $final['winner_info'] =[
                        'player_name' => $winner->full_name,
                        'player_id' =>  $winner->form_id
                    ];
                }

                // dd($final);
                //prasun dahal
                $year = date('Y');
                $month = 4;
                $day = 16;
                // if(strtotime(date('Y-m-d')) == strtotime(date($year . '-' . $month . '-'.$day))){
                //     $prasun_count = Form::where('full_name','Prasun Dahal')->count();
                //     if($prasun_count > 0){
                //         $prasun = Form::where('full_name','Prasun Dahal')->first()->toArray();
                //         $z =[
                //             'player_name' => $prasun['full_name'],
                //             'player_id' => $prasun['id']
                //         ];
                //         array_push($final['players_list'], $z);

                //         $final['winner_info'] =[
                //             'player_name' => $prasun['full_name'],
                //             'player_id' =>  $prasun['id']
                //         ];
                //     }

                // }
                //prasun dahal
            }

            $old_winners = SpinnerWinner::count();
            if($old_winners > 0){
                $old_winners = SpinnerWinner::limit(5)->get()->toArray();
                $final_old = [];
                $month = intval(date('m'));
                foreach($old_winners as $a => $b){
                    $date = explode('-',date('Y-m-d',strtotime($b['created_at'])));
                    if(intval($date[1]) != $month && intval($date[1]) != ($month-1)){
                        array_push($final_old,$b);
                    }else{
                    }
                }
                // $old_winners = $final_old;
                $old_list = $final_old;
            }else{
                $old_winners = [];
            }
            $settings = \App\Models\GeneralSetting::first();
            $carbon_now = Carbon::now();
            
            
            $formData = Form::get();
            foreach($formData as $key => $data){
                $final['players_list'][] = [
                            'player_name' => $data->full_name,
                            'player_id' => $data->id
                        ];
            }
            $final['winner_info'] = [
                            'player_name' => 'winner name',
                            'player_id' => 1
                        ];
        // dd($old_list);
            return view('spinner', compact('final','form_token','old_list','currentPlayer','settings','carbon_now'));
        }
        else{
            abort(404);
        }
    }
    public function userSpinner($token)
    {
        $currentPlayer = [];
        //spinner runs on 10 so we bring data of previous month
        
        $form_token = Form::where('token',$token)->count();
        if($form_token > 0 ){
            $form_token = Form::where('token',$token)->first('id')->toArray();

            $year = date('Y');
            $month = date('m');
            if($month != 1){
                $month = $month - 1;
            }else{
                $month = 12;
                $year = $year - 1;
            }
            if($month <10){
                $month = '0'.$month;
            }
            // dd($month);
            $filter_start = $year.'-'.$month.'-01';
            $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-30'));
            // $filter_end = date("Y-m-t", strtotime(Carbon::now()));
            $compare_amount = $this->limit_amount;
            $historys = History::where('type', 'load')
                                ->whereBetween('created_at',[$filter_start,$filter_end])
                                ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id'])
                                ->groupBy('form_id')
                                ->with('form')
                                ->whereHas('form')
                                ->get();
            // dd($filter_start,$filter_end,$historys);
    
            $winners_list = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)])->count();
    
            $final = [
                'players_list' => [],
                'winner_info' => []
            ];
            
            if (($historys->count()) > 0)
            {
                
                $historys = $historys->toArray();
                foreach ($historys as $a => $b)
                {
                    // dd($b);
                    $explode_name = explode(' ',$b['form']['full_name']);
                    $full_name_encrypt = '';
                    foreach($explode_name as $z){
                        $string = substr($z,0,2);
                        $string .= '**** ';
                        $full_name_encrypt .= $string;
                    }
                    if ($b['total'] >= $compare_amount)
                    {
                        if($form_token > 0){
                            if($b['form_id'] == $form_token['id']){
                                $currentPlayer = [
                                    'player_name' => $b['form']['full_name'],
                                    'player_id' => $b['form_id']
                                ];
                                $z =[
                                    'player_name' => $b['form']['full_name'],
                                    'player_id' => $b['form_id'],
                                    'bool' => 1
                                ];
                            }else{
                                $z =[
                                    'player_name' => $full_name_encrypt,
                                    'player_id' => $b['form_id']
                                ];
                            }
                        }else{
                            $z =[
                                'player_name' => $full_name_encrypt,
                                'player_id' => $b['form_id']
                            ];
                        }
                        array_push($final['players_list'], $z);
                    }
                }
                // if(){
                    
                // }
                if(!empty($final['players_list'])){
                        
                    $shuffle = array_rand($final['players_list']);
    
                    if($winners_list <= 0){
                        $f1 = Form::where('id',$final['players_list'][$shuffle]['player_id'])->first();
                        $winner = SpinnerWinner::create([
                            'form_id' => $final['players_list'][$shuffle]['player_id'],
                            'full_name' => $f1->full_name
                        ]);
                    }
                    else{
                        $winner = SpinnerWinner::whereBetween('created_at',[$filter_start,$filter_end])->first();
                    }
                    $final['winner_info'] =[
                        'player_name' => $winner->full_name,
                        'player_id' =>  $winner->form_id
                    ];
                }
                
                // dd($final);  
                //prasun dahal
                $year = date('Y');
                $month = 4;
                $day = 16;
                // if(strtotime(date('Y-m-d')) == strtotime(date($year . '-' . $month . '-'.$day))){
                //     $prasun_count = Form::where('full_name','Prasun Dahal')->count();
                //     if($prasun_count > 0){
                //         $prasun = Form::where('full_name','Prasun Dahal')->first()->toArray();
                //         $z =[
                //             'player_name' => $prasun['full_name'],
                //             'player_id' => $prasun['id']
                //         ];
                //         array_push($final['players_list'], $z);
    
                //         $final['winner_info'] =[
                //             'player_name' => $prasun['full_name'],
                //             'player_id' =>  $prasun['id']
                //         ];
                //     }
                    
                // }
                //prasun dahal
            }
            
            $old_winners = SpinnerWinner::count();
            if($old_winners > 0){
                $old_winners = SpinnerWinner::limit(5)->get()->toArray();
                $final_old = [];
                $month = intval(date('m'));
                foreach($old_winners as $a => $b){
                    $date = explode('-',date('Y-m-d',strtotime($b['created_at'])));
                    if(intval($date[1]) != $month && intval($date[1]) != ($month-1)){
                        array_push($final_old,$b);
                    }else{
                    }
                }
                // $old_winners = $final_old;
                $old_list = $final_old;
            }else{
                $old_winners = [];
            }
            $settings = \App\Models\GeneralSetting::first();
            $carbon_now = Carbon::now();
            
            $formData = Form::get();
            $player_name = Form::where('token', $token)->first();
            foreach($formData as $key => $data){
                $final['players_list'][] = [
                            'player_name' => $data->full_name,
                            'player_id' => $data->id
                        ];
            }
            $final['winner_info'] = [
                            'player_name' => 'Maryannprive',
                            'player_id' => 1361
                        ];
        // dd($old_list);
            return view('newLayout.spinnerEncrypt', compact('final','form_token','old_list','currentPlayer','settings','carbon_now', 'player_name'));
        }
        else{
            abort(404);
        }
    }

    public function sendMailToWinner(){
        try
        {
            $month = date('m');
            if($month != 1){
                $month = $month - 1;
            }
            if($month >10){
                $month = '0'.$month;
            }
            $filter_start = '2022-'.$month.'-01';
            $filter_end = Carbon::now();
            $winner = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)])
                                ->count();
            if($winner > 0){
                $winner = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)])->first();
                // dd($winner);
                // if($winner->mail == 0){


                    $settings = GeneralSetting::first();
                    $form = Form::where('id',$winner->form_id)->first();

                    $token_id = Str::random(32);
                    $winner->token = $token_id.'---'.$form->id;
                    $details = [
                        'name' => $form->full_name,
                        'token_id' => $token_id.'---'.$form->id,
                        'message' => 'Congratulations!!! You have won the first monthly spinner.',
                        'theme' => ($settings->theme)
                    ];
                    try
                        {
                            // Mail::to($form->email)->send(new sendMailToWinner(($details)));
                            // $winner->mail = 1;
                            // $winner->save();
                            // Log::channel('spinnerBulk')->info("Mail sent successfully to ".$form->email);
                            // return Response::json(['success' => $winner], 200);
                        }
                    catch(\Exception $e)
                        {
                            $bug = $e->getMessage();
                            Log::channel('spinnerBulk')->info($bug);
                        }
                // }
            }
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            dd($bug);
            return Response::json(['error' => $bug], 404);
        }
    }

    public function spinnerForm($token)
    {
        $token_explode = explode('---',$token);

        if(SpinnerWinner::where(['form_id' => isset($token_explode[1])?$token_explode[1]:'','token' => $token])->count() > 0){
            return view('newLayout.spinnerForm',compact('token'));
        }else{
            return abort(404);
        }
    }
    public function spinnerFormSave(Request $request){
        //captcha check
        session_start();
        $entered_captcha=strtoupper($request->captcha_token);
        $generated_captcha=strtoupper($_SESSION['captcha_token']);
        if($entered_captcha!=$generated_captcha) {
            return redirect()->back()->withInput()->with('error','Entered Captcha is wrong.');
        }else{
            // abort(500, 'Something went wrongasf');
            $details = [
                'Full Name' => $request->full_name,
                'Phone' => $request->number,
                'Email' => $request->email,
            ];
            $settings = GeneralSetting::first();
            //send mail
            $mail = [
                'subject' => 'Spinner Winner has filled up Form.',
                'message' => 'This months spinner winner has filled up his/her form.',
                'details' => json_encode($details),
                'theme' => ($settings->theme)
            ];
            Mail::to('joshibipin2052@gmail.com')->send(new CustomTextMail(json_encode($mail)));
        }
    }

    public function table()
    {
        try {
            $forms = Form::orderBy('full_name', 'asc')->get()->toArray();
            //  dd($forms);
            $games = Account::where('status', 'active')->get()->toArray();

            $activeGame = isset($_GET['game']) ? $_GET['game'] : '';
            $activeCashApp = isset($_GET['cash_app']) ? $_GET['cash_app'] : '';



            if (empty($activeGame)) {
                $activeGameDefault = Account::first()->toArray();
                $activeGame = $activeGameDefault['title'];
            }
            if (empty($activeCashApp)) {
                $cash_app_default = CashApp::first()->toArray();
                $activeCashApp = $cash_app_default['title'];
            }

            $activeGame = Account::where([['title', $activeGame], ['status', 'active']])
                ->with('formGames')
                ->first()
                ->toArray();
            // dd($activeGame);
            $cashApp = CashApp::where([['status', 'active']])
                ->get()
                ->toArray();

            $activeCashApp = CashApp::where([['title', $activeCashApp], ['status', 'active']])
                ->first()
                ->toArray();

            $final = [];
            if (!empty($activeGame['form_games'])) {
                foreach ($activeGame['form_games'] as $a => $b) {
                    $tip = FormTip::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $refer = FormRefer::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $cash = CashAppForm::where('form_id', $b['form']['id'])->where('cash_app_id', $activeCashApp['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $balance = FormBalance::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $redeem = FormRedeem::where('form_id', $b['form']['id'])->where('account_id', $activeGame['id'])->sum('amount');
                    $b['cash_app'] = $cash;
                    $b['tip'] = $tip;
                    $b['refer'] = $refer;
                    $b['balance'] = $balance;
                    $b['redeem'] = $redeem;
                    array_push($final, $b);
                }
                $activeGame['form_games'] = $final;
            }
            $history = History::where('account_id', $activeGame['id'])
                ->where('created_by', Auth::user()->id)
                ->with('form')
                ->with('account')
                ->with(['formGames' => function ($query) use ($activeGame) {
                    $query->where('account_id', $activeGame['id']);
                }])

                ->orderBy('id', 'desc')
                ->get()
                ->toArray();
            // dd($activeCashApp);

            return view('newLayout.table', compact(
                'forms',
                'games',
                'activeGame',
                'history',
                'activeCashApp',
                'cashApp'
            ));
        } catch (\Exception $e) {
            $bug = $e->getMessage();
            dd($bug);
            return Response::json(['error' => $bug], 404);
        }
    }

    public function removeFormGame(Request $request)
    {
        try
        {
            $gameId = $request->gameId;
            $userId = $request->userId;

            $account = Account::findOrFail($gameId);
            $user = Form::findOrFail($userId);
            $form_game = FormGame::where('account_id', $gameId)->where('form_id', $userId)->delete();
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }
        return Response::json('true');
    }

     public function tableUpdate(Request $request)
    {
        $setting = GeneralSetting::first();
         // $name = FacadesRequest::input('name');
        $created_at = isset($_GET['date'])?$_GET['date']:Carbon::now();
        $url = $request->fullUrl();
        // return [$url,$created_at];
        try
        {
            $gameId = $request->gameId;
            $userId = $request->userId;
            $amount = $request->amount;
            $cashAppId = $request->cashAppId;

            $account = Account::findOrFail($gameId);
            $user = Form::findOrFail($userId);
            $cashApp = CashApp::findOrFail($cashAppId);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }

        $accountBalance = $account->balance;
        $userBalance = $user->balance;
        // return $amount;
        $cashAppBalance = $cashApp->balance;
        $updateCashApp = CashApp::where('id', $cashAppId)->update(['balance' => ($cashAppBalance + $amount) ]);
        if(session()->has('tableDate')){
            $created_at = session()->get('tableDate');
        }else{
            $created_at = Carbon::now();
        }
        $cash_app_form = CashAppForm::create(['created_at' => $created_at,'form_id' => $userId, 'cash_app_id' => $cashAppId, 'account_id' => $gameId, 'amount' => $amount, 'created_by' => Auth::user()->id]);

        $account = Account::where('id', $gameId)->update(['balance' => ($accountBalance - $amount) ]);
        // $user = Form::where('id', $userId)->update(['balance' => ($userBalance + $amount)]);
        $user_balance = FormBalance::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'amount' => $amount, 'created_by' => Auth::user()->id]);

        //update History
        $history = History::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'amount_loaded' => $amount, 'relation_id' => $user_balance->id, 'previous_balance' => $userBalance, 'final_balance' => $userBalance + $amount, 'type' => 'load', 'created_by' => Auth::user()->id]);
        // Log::channel('cronLog')->info('This is testing for sharewarenepal.com!'
        // $accountBalance = $account->balance;
        // $userBalance = $user->balance;
       
        if ($user->balance != 1)
        {
            $currentMonth = date('m');
            $data = DB::table("histories")->where('form_id', $user->id)
                ->whereRaw('MONTH(created_at) = ?', [$currentMonth])->sum('amount_loaded');
            if ($data >= $this->limit_amount)
            {
                Log::channel('spinnerBulk')->info("yes user balance is greater ");
                // dd($data >= 600);
                $token_id = Str::random(32);
                $form = Form::where('id', $user->id)
                    ->update(['balance'=>1,'token' => $token_id]);
                $form = Form::where('id', $user->id)
                    ->first()
                    ->toArray();
                    $details = [
                        'form'=>$form,
                        'theme'=>$setting->theme,
                    ];
                try
                {
                    // return Response::json($form);
                    if (!empty($form['email']))
                    {
                        Mail::to("mangaletamang65@gmail.com")->send(new crossedPlayers(json_encode($form)));
                        
                        
                    }
                    // if(!empty($form['phone'])){
                    $boyname = $form['full_name'];

                    // $number  =  $form['full_name'];
                    $basic = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
                    $client = new \Vonage\Client($basic);

                    $sendtextuser = 'Congratulation ' . $boyname . '!!! ' . ' You are now eligible for spinner';

                    // $message = $client->message()
                    //     ->send(['to' => '+9779813815279', 'from' => '18337222376', 'text' => $sendtextuser]);

                    // }
                    // Mail::to('riteshnoor69@gmail.com')->send(new crossedPlayers(json_encode($form)));
                    // Mail::to('prasundahal@gmail.com')->send(new crossedPlayers(json_encode($form)));
                    // Mail::to('joshibipin2052@gmail.com')->send(new crossedPlayers(json_encode($form)));
                }
                catch(\Exception $e)
                {
                    return Response::json($e->getMessage());
                }
            }
        }
        return Response::json(Account::get()
            ->toArray());
    }
    public function referBalance(Request $request)
    {
        try
        {
            $gameId = $request->gameId;
            $userId = $request->userId;
            $amount = $request->amount;

            $account = Account::findOrFail($gameId);
            $user = Form::findOrFail($userId);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug,'user'=>$userId], 404);
        }

        $accountBalance = $account->balance;
        // $userBalance = $user->balance;


        $account = Account::where('id', $gameId)->update(['balance' => ($accountBalance - $amount) ]);

        // $user = Form::where('id', $userId)->update(['balance' => ($userBalance + $amount)]);
        //create refer entry
        if(session()->has('tableDate')){
            $created_at = session()->get('tableDate');
        }else{
            $created_at = Carbon::now();
        }
        $refer = FormRefer::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'amount' => $amount, 'created_by' => Auth::user()->id]);

        //update History
        $history = History::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'relation_id' => $refer->id, 'amount_loaded' => $amount, 'previous_balance' => 0, 'final_balance' => 0, 'type' => 'refer', 'created_by' => Auth::user()->id]);
        // Log::channel('cronLog')->info('This is testing for ItSolutionStuff.com!'
        // $accountBalance = $account->balance;
        // $userBalance = $user->balance;
        return Response::json(Account::get()
            ->toArray());
    }

    public function loadCashBalance(Request $request)
    {
        try
        {
            $cashAppId = $request->cashAppId;
            $userId = $request->userId;
            $amount = $request->amount;
            $gameId = $request->gameId;
            // CashApp
            // CashAppForm
            $account = Account::findOrFail($gameId);
            $cashApp = CashApp::findOrFail($cashAppId);
            $user = Form::findOrFail($userId);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }

        $cashAppBalance = $cashApp->balance;
        // $userBalance = $user->balance;


        $updateCashApp = CashApp::where('id', $cashAppId)->update(['balance' => ($cashAppBalance + $amount) ]);

        // $user = Form::where('id', $userId)->update(['balance' => ($userBalance + $amount)]);
        //create refer entry
        $cash_app_form = CashAppForm::create(['form_id' => $userId, 'cash_app_id' => $cashAppId, 'account_id' => $gameId, 'amount' => $amount, 'created_by' => Auth::user()->id]);

        //update History
        $history = History::create(['form_id' => $userId, 'account_id' => $gameId, 'amount_loaded' => $amount, 'relation_id' => $cash_app_form->id, 'cash_apps_id' => $cashAppId, 'previous_balance' => 0, 'final_balance' => 0, 'type' => 'cashAppLoad', 'created_by' => Auth::user()->id]);
        // Log::channel('cronLog')->info('This is testing for ItSolutionStuff.com!'
        // $accountBalance = $account->balance;
        // $userBalance = $user->balance;
        return Response::json(Account::get()
            ->toArray());
    }
    public function redeemBalance(Request $request)
    {
        try
        {
            $gameId = $request->gameId;
            $userId = $request->userId;
            $amount = $request->amount;
            $cashAppId = $request->cashAppId;

            $account = Account::findOrFail($gameId);
            $user = Form::findOrFail($userId);
            $cashApp = CashApp::findOrFail($cashAppId);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }

        $accountBalance = $account->balance;
        $userBalance = $user->balance;
        $cashAppBalance = $cashApp->balance;

        $account = Account::where('id', $gameId)->update(['balance' => ($accountBalance + $amount) ]);
        // $user = Form::where('id', $userId)->update(['balance' => ($userBalance - $amount)]);
        $cashApp = CashApp::where('id', $cashAppId)->update(['balance' => ($cashAppBalance - $amount) ]);

        if(session()->has('tableDate')){
            $created_at = session()->get('tableDate');
        }else{
            $created_at = Carbon::now();
        }

        $form_redeem = FormRedeem::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'amount' => $amount, 'created_by' => Auth::user()->id]);

        //update History
        $history = History::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'cash_apps_id' => $cashAppId, 'amount_loaded' => $amount, 'relation_id' => $form_redeem->id, 'previous_balance' => $userBalance, 'final_balance' => $userBalance - $amount, 'type' => 'redeem', 'created_by' => Auth::user()->id]);

        // $accountBalance = $account->balance;
        // $userBalance = $user->balance;
        return Response::json(Account::get()
            ->toArray());
    }
    public function tipBalance(Request $request)
    {
        try
        {
            $gameId = $request->gameId;
            $userId = $request->userId;
            $amount = $request->amount;

            $account = Account::findOrFail($gameId);
            $user = Form::findOrFail($userId);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }

        $accountBalance = $account->balance;

        $account = Account::where('id', $gameId)->update(['balance' => ($accountBalance + $amount) ]);
        // $user = Form::where('id', $userId)->update(['balance' => ($userBalance - $amount)]);
        // $cashApp = CashApp::where('id', $cashAppId)->update(['balance' => ($cashAppBalance - $amount)]);

        if(session()->has('tableDate')){
            $created_at = session()->get('tableDate');
        }else{
            $created_at = Carbon::now();
        }
        $form_redeem = FormTip::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'amount' => $amount, 'created_by' => Auth::user()->id]);

        //update History
        $history = History::create(['created_at' => $created_at,'form_id' => $userId, 'account_id' => $gameId, 'relation_id' => $form_redeem->id, 'amount_loaded' => $amount, 'type' => 'tip', 'created_by' => Auth::user()->id]);

        // $accountBalance = $account->balance;
        // $userBalance = $user->balance;
        return Response::json(Account::get()
            ->toArray());
    }
    public function addUser(Request $request)
    {
        try
        {
            $id = $request->id;
            $game_id = $request->game_id;
            $account_id = $request->account_id;

            $form = Form::findOrFail($id);
            $account = Account::findOrFail($account_id);

            // $exists = FormGame::where([['form_id', $id], ['account_id', $account_id]])->count();
            // if ($exists > 0)
            // {
            //     return redirect()->back()
            //         ->with('error', 'User Already exists in this game.');
            // }
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }
        try
        {
            $form_game = FormGame::create(['form_id' => $id, 'account_id' => $account_id, 'game_id' => str_replace(' ', '_', strtolower($account['title'])) . '_' . $game_id, 'created_by' => Auth::user()->id, ]);
        }
        catch(\Illuminate\Database\QueryException $e)
        {
            $error_code = $e->errorInfo[1];
            if ($error_code == 1062)
            {
                return redirect()->back()
                    ->with('error', 'Game id already exists in this game.');
            }
        }
        //update History
        // $accountBalance = $account->balance;
        // $userBalance = $user->balance;
        return redirect()
            ->back()
            ->with('success', 'User Added');
    }
    public function report()
    {

        // with('account')
        // ->with('form')
        $history = History::with('form')->whereHas('form')
            ->with('account')
            ->whereHas('account')
        // ->whereBetween('created_at', [Carbon::now()->subMinutes(1440), now()])
        // ->with('created_by')

            ->orderBy('id', 'desc')
            ->get()
            ->toArray();

        $final = [];
        $forms = [];

        if (!empty($history))
        {
            $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
            foreach ($history as $a => $b)
            {
                if (!isset($final[$b['account_id']]))
                {
                    $final[$b['account_id']]['game_name'] = $b['account']['name'];
                    $final[$b['account_id']]['game_title'] = $b['account']['title'];
                    $final[$b['account_id']]['game_balance'] = $b['account']['balance'];
                    $final[$b['account_id']]['histories'] = [];
                    $final[$b['account_id']]['totals'] = $totals;
                    $final[$b['account_id']]['total_transactions'] = 1;
                }

                ($b['type'] == 'tip') ? ($final[$b['account_id']]['totals']['tip'] = $final[$b['account_id']]['totals']['tip'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['tip'] = $final[$b['account_id']]['totals']['tip']);
                ($b['type'] == 'load') ? ($final[$b['account_id']]['totals']['load'] = $final[$b['account_id']]['totals']['load'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['load'] = $final[$b['account_id']]['totals']['load']);
                ($b['type'] == 'redeem') ? ($final[$b['account_id']]['totals']['redeem'] = $final[$b['account_id']]['totals']['redeem'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['redeem'] = $final[$b['account_id']]['totals']['redeem']);
                ($b['type'] == 'refer') ? ($final[$b['account_id']]['totals']['refer'] = $final[$b['account_id']]['totals']['refer'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['refer'] = $final[$b['account_id']]['totals']['refer']);
                ($b['type'] == 'cashAppLoad') ? ($final[$b['account_id']]['totals']['cashAppLoad'] = $final[$b['account_id']]['totals']['cashAppLoad'] + $b['amount_loaded']) : ($final[$b['account_id']]['totals']['cashAppLoad'] = $final[$b['account_id']]['totals']['cashAppLoad']);
                $final[$b['account_id']]['total_transactions'] = $final[$b['account_id']]['total_transactions'] + 1;
                array_push($final[$b['account_id']]['histories'], $b);
            }
        }
        $details = $final;
        Mail::to('riteshnoor69@gmail.com')->send(new reportMail(json_encode($details)));
        Mail::to('prasundahal@gmail.com')->send(new reportMail(json_encode($details)));
        Mail::to('joshibipin2052@gmail.com')->send(new reportMail(json_encode($details)));
        // return view('mails.report',compact('details'));

    }
    public function totals()
    {
        $data = [
            'load' => FormBalance::query()->sum('amount'),
            'tip' => FormTip::query()->sum('amount'),
            'redeem' => FormRedeem::query()->sum('amount'),
            'refer' => FormRefer::query()->sum('amount'),
        ];

        return $data;
    }
    public function allHistory1()
    {

        ini_set('max_execution_time', '0');

        if (Auth::user()->role == 'admin'){
            $history = History::where('created_by',Auth::user()->id)->orderBy('id', 'desc')->count();
        }else{
            $history = History::orderBy('id', 'desc')->count();
        }
        $final = [];
        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
        $forms = [];
$old=null;
        $data = [['SN', 'Date', 'FB Name', 'Game', 'Game ID', 'Amount', 'Type', 'Creator']];
        if (($history > 0))
        {
            if (Auth::user()->role != 'admin'){
                $history = History::with('account')->with('form')->whereHas('form')->where('created_by',Auth::user()->id)->orderBy('id', 'desc')->with('created_by')->paginate(15);
            }else{
                $history = History::with('account')->with('form')->whereHas('form')->with('created_by')->orderBy('id', 'desc')->paginate(15);
            }
            $old = $history;
            $zzz = $history->toArray();
            $history = $zzz['data'];
            // dd($history->toArray());
            foreach ($history as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                if (!empty($form_game))
                {
                    $form_game->toArray();

                    $b['form_game'] = $form_game;

                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                    array_push($final, $b);
                    // array_push($forms, $b['form']);
                }
            }
            $count = 1;
            foreach ($final as $key => $item)
            {
                $z = [$count++, date('d M,Y', strtotime($item['created_at'])) , $item['form']['facebook_name'], $item['form_game']['game_id'], $item['amount_loaded'], $item['type'], $item['created_by']['name']];
                array_push($data, $z);
            }

            // $activeGame['form_games'] = $final;

        }
        $games = Account::where('status', 'active')->get()
            ->toArray();
        // $filename = 'file.csv';
        // header('Content-Type: application/csv; charset=UTF-8');
        // header('Content-Disposition: attachment;filename="'.$filename.'";');
        // ob_clean();
        // flush();
        // $f = fopen('php://output', 'w');
        // foreach ($data as $line) {
        //     fputcsv($f, $line, ';');
        // }
        // $totals = [
        //     ['Total Tip','Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
        //     [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
        // ];
        $totals_2 = [['', ''], ['Total Tip', $totals['tip']], ['Total Balance', $totals['load']], ['Total Redeem', $totals['redeem']], ['Total Refer', $totals['refer']], ['Total Amount', $totals['cashAppLoad']], ['Total Profit', ($totals['load'] - $totals['redeem']) ],
        // 'Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
        // [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
        ];
        // foreach ($totals_2 as $line) {
        //     fputcsv($f, $line, ';');
        // }
        // fclose($f);
        // exit;
        $total = $totals;
        $forms = Form::get()->toArray();
        return view('newLayout.history', compact('old','final', 'total', 'games', 'forms'));
    }
    
     public function playersLoadDetails(Request $request)
    {
        // Base query for players
        $query = Form::query();
        
        // Get all players for the dropdown
        $allPlayers = Form::orderBy('full_name')->get(['id', 'full_name']);
        
        // Filter by player id if provided
        if ($request->filled('player_id')) {
            $query->where('id', $request->player_id);
        }
        
        // Get filtered players with their histories
        $players = $query->with(['histories' => function($q) use ($request) {
            // Apply date filters to histories
            if ($request->filled('start_date')) {
                $q->where('created_at', '>=', $request->start_date);
            }
            if ($request->filled('end_date')) {
                $endDate = $request->end_date . ' 23:59:59';
                $q->where('created_at', '<=', $endDate);
            }
            $q->with('game:id,name');
        }])->get();
        
        // Calculate totals for each player
        $totals = $players->map(function($player) {
            $histories = $player->histories;
            
            return [
                'player' => $player,
                'total_load' => $histories->where('type', 'load')->sum('amount_loaded'),
                'total_tip' => $histories->where('type', 'tip')->sum('amount_loaded'),
                'total_redeem' => $histories->where('type', 'redeem')->sum('amount_loaded'),
                'total_refer' => $histories->where('type', 'refer')->sum('amount_loaded'),
            ];
        });
        
        return view('newLayout.players_load_details', compact('totals', 'allPlayers'));
    }



    public function thisDayGame(Request $request)
    {
        $year = isset($request->year) ? $request->year : '';
        $month = isset($request->month) ? $request->month : '';
        $day = isset($request->day) ? $request->day : '';
        $game = isset($request->game) ? $request->game : '';
        $history = History::with('account')->with('form')
            ->whereHas('form')
            ->where('account_id',$game)
            ->with('created_by')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
        $grouped = [];
        if($month < 10){
            $month = '0'.$month;
        }
        if($day < 10){
            $day = '0'.$day;
        }
        $data = ['year' => $year, 'month' => $month, 'day' => $day];
        foreach ($history as $a => $b)
        {
            $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
            $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
            if (($created_at[0] == $year) && ($created_at[1] == $month) && ($created_at[2] == $day) && !empty($form_game))
            {
                $form_game->toArray();
                $b['form_game'] = $form_game;
                array_push($grouped, $b);
            }
        }
            // return Response::json($data);
        // return Response::json($data);
        return Response::json($grouped);
    }
    public function thisDay(Request $request)
    {
        $year = isset($request->year) ? $request->year : '';
        $month = isset($request->month) ? $request->month : '';
        $day = isset($request->day) ? $request->day : '';

        $category = isset($request->category) ? $request->category : '';

        $data = ['year' => $year, 'month' => $month, 'day' => $day];

        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

        $account_totals = [];
        $history = History::with('form')
            ->with('created_by')
            ->with('account')
            ->whereHas('account', function ($query) use ($category) {
                if($category && $category != 'all')
                return $query->where('name', 'like', $category);
            })
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
        $grouped = [];
        $accounts = [];
        foreach ($history as $a => $b)
        {
            $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
            $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
            if (($created_at[0] == $year) && ($created_at[1] == $month) && ($created_at[2] == $day) && !empty($form_game))
            {
                $account_totals[$b['account_id']]['tip'] = isset($account_totals[$b['account_id']]['tip']) ? $account_totals[$b['account_id']]['tip'] : 0;
                $account_totals[$b['account_id']]['load'] = isset($account_totals[$b['account_id']]['load']) ? $account_totals[$b['account_id']]['load'] : 0;
                $account_totals[$b['account_id']]['redeem'] = isset($account_totals[$b['account_id']]['redeem']) ? $account_totals[$b['account_id']]['redeem'] : 0;
                $account_totals[$b['account_id']]['refer'] = isset($account_totals[$b['account_id']]['refer']) ? $account_totals[$b['account_id']]['refer'] : 0;
                $account_totals[$b['account_id']]['cashAppLoad'] = isset($account_totals[$b['account_id']]['cashAppLoad']) ? $account_totals[$b['account_id']]['cashAppLoad'] : 0;
                $form_game->toArray();

                $b['form_game'] = $form_game;
                array_push($grouped, $b);
                ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                ($b['type'] == 'tip') ? ($account_totals[$b['account_id']]['tip'] = $account_totals[$b['account_id']]['tip'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['tip'] = $account_totals[$b['account_id']]['tip']);
                ($b['type'] == 'load') ? ($account_totals[$b['account_id']]['load'] = $account_totals[$b['account_id']]['load'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['load'] = $account_totals[$b['account_id']]['load']);
                ($b['type'] == 'redeem') ? ($account_totals[$b['account_id']]['redeem'] = $account_totals[$b['account_id']]['redeem'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['redeem'] = $account_totals[$b['account_id']]['redeem']);
                ($b['type'] == 'refer') ? ($account_totals[$b['account_id']]['refer'] = $account_totals[$b['account_id']]['refer'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['refer'] = $account_totals[$b['account_id']]['refer']);
                ($b['type'] == 'cashAppLoad') ? ($account_totals[$b['account_id']]['cashAppLoad'] = $account_totals[$b['account_id']]['cashAppLoad'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['cashAppLoad'] = $totals['cashAppLoad']);

                if (!(isset($accounts[$b['account_id']])))
                {
                    $accounts[$b['account_id']] =
                    [
                        'game_id' => $b['account']['id'],
                        'game_name' => $b['account']['name'],
                        'game_title' => $b['account']['title'],
                        'game_balance' => $b['account']['balance'],
                        'histories' => [],
                        'totals' => $totals,
                        'total_transactions' => 0
                    ];
                }
                if(isset($accounts[$b['account_id']])) {
                    $accounts[$b['account_id']]['totals'] = $account_totals[$b['account_id']];
                }
            }
        }
        $default_accounts = Account::get()->toArray();
        $data['accounts'] = $accounts;
        $data['default_accounts'] = $default_accounts;
        $data['grouped'] = $grouped;
        // return Response::json($data);
        return Response::json($data);
    }
    public function thisDayRedeem(Request $request)
    {
        $year = isset($request->year) ? $request->year : '';
        $month = isset($request->month) ? $request->month : '';
        $day = isset($request->day) ? $request->day : '';
        $form = isset($request->form) ? $request->form : '';

        $category = isset($request->category) ? $request->category : '';

        $data = ['year' => $year, 'month' => $month, 'day' => $day];

        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

        $account_totals = [];
        if (empty($year))
        {
            $year = date('Y');
        }
        if (empty($month))
        {
            $month = date('m');
        }
        if (empty($day))
        {
            $day = date('d');
        }

        //

        if(!empty($form)){
            $history = FormRedeem::with('form')
            ->with('created_by')
            ->with('account')
            ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
            ->where('form_id',$form)->orderBy('created_at', 'asc')->get()->toArray();
        }else{
            $history = FormRedeem::with('form')
            ->with('created_by')
            ->with('account')
            ->whereDate('created_at', '>=', date($year . '-' . $month . '--01'))
            ->orderBy('created_at', 'asc')->get()->toArray();
        }
        $grouped = [];
        $accounts = [];
        foreach ($history as $a => $b)
        {
            $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
            $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
            if (!empty($form_game))
            {
                // $account_totals[$b['account_id']]['tip'] = isset($account_totals[$b['account_id']]['tip']) ? $account_totals[$b['account_id']]['tip'] : 0;
                // $account_totals[$b['account_id']]['load'] = isset($account_totals[$b['account_id']]['load']) ? $account_totals[$b['account_id']]['load'] : 0;
                $account_totals[$b['account_id']]['redeem'] = isset($account_totals[$b['account_id']]['redeem']) ? $account_totals[$b['account_id']]['redeem'] : 0;
                // $account_totals[$b['account_id']]['refer'] = isset($account_totals[$b['account_id']]['refer']) ? $account_totals[$b['account_id']]['refer'] : 0;
                // $account_totals[$b['account_id']]['cashAppLoad'] = isset($account_totals[$b['account_id']]['cashAppLoad']) ? $account_totals[$b['account_id']]['cashAppLoad'] : 0;
                // $form_game->toArray();

                $b['form_game'] = $form_game;
                array_push($grouped, $b);
                // ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                // ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                $totals['redeem'] = $totals['redeem'] + $b['amount'];
                // ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                // ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                // ($b['type'] == 'tip') ? ($account_totals[$b['account_id']]['tip'] = $account_totals[$b['account_id']]['tip'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['tip'] = $account_totals[$b['account_id']]['tip']);
                // ($b['type'] == 'load') ? ($account_totals[$b['account_id']]['load'] = $account_totals[$b['account_id']]['load'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['load'] = $account_totals[$b['account_id']]['load']);
                $account_totals[$b['account_id']]['redeem'] = $account_totals[$b['account_id']]['redeem'] + $b['amount'];
                // ($b['type'] == 'refer') ? ($account_totals[$b['account_id']]['refer'] = $account_totals[$b['account_id']]['refer'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['refer'] = $account_totals[$b['account_id']]['refer']);
                // ($b['type'] == 'cashAppLoad') ? ($account_totals[$b['account_id']]['cashAppLoad'] = $account_totals[$b['account_id']]['cashAppLoad'] + $b['amount_loaded']) : ($account_totals[$b['account_id']]['cashAppLoad'] = $totals['cashAppLoad']);

                if (!(isset($accounts[$b['account_id']])))
                {
                    $accounts[$b['account_id']] =
                    [
                        'game_id' => $b['account']['id'],
                        'game_name' => $b['account']['name'],
                        'game_title' => $b['account']['title'],
                        'game_balance' => $b['account']['balance'],
                        'histories' => [],
                        'totals' => $totals,
                        'total_transactions' => 0
                    ];
                }
                if(isset($accounts[$b['account_id']])) {
                    $accounts[$b['account_id']]['totals'] = $account_totals[$b['account_id']];
                }
            }
        }
        // return Response::json($grouped);
        $default_accounts = Account::get()->toArray();
        $data['accounts'] = $accounts;
        $data['default_accounts'] = $default_accounts;
        $data['grouped'] = $grouped;
        // return Response::json($data);
        return Response::json($data);
    }
    public function filterUndoHistory(Request $request)
   {
       $filter_type = $request->filter_type;
       $userId = $request->userId;
       $game = $request->game;
       $filter_start = $request->filter_start;
       $filter_end = $request->filter_end;
       $historyType = $request->historyType;

       $history = History::query();

       $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

       if ($filter_type != 'all')
       {
           $history->where('type', $request->filter_type);
       }
       if ($userId != 'all')
       {
           $history->where('form_id', $userId);
       }
       if ($filter_start != '')
       {
           $history->whereDate('created_at', '>=', $filter_start);
       }
       if ($filter_end != '')
       {
           $history->whereDate('created_at', '<=', $filter_end);
       }
       if ($game != 'all')
       {
           $history->where('account_id', $game);
       }

       $history->with('account')
                ->with('form')
                ->whereHas('form')
                ->with('formGames')
                ->whereHas('formGames')
                ->with('created_by')
                ->orderBy('id', 'desc');

       $final = [];

       $historys = $history->get();

       $return_array = [
           'status' => (count($historys) > 0)?1:0,
           'data' => $historys
       ];
       return Response::json($return_array);
   }
     public function filterUndoHistory2(Request $request)
    {
        $filter_type = $request->filter_type;
        $userId = $request->userId;
        $game = $request->game;
        $filter_start = $request->filter_start;
        $filter_end = $request->filter_end;
        $historyType = $request->historyType;

        $history = new History();

        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

        if ($filter_type != 'all')
        {
            $history->where('type', $request->filter_type);
        }
        if ($userId != 'all')
        {
            $history->where('form_id', $userId);
        }

        // $history->when(request('filter_type', '!=','all'), function ($q, $filter_type) {
        //     return $q->where('type',$filter_type);
        // });
        // return Response::json($historys);
        if ($filter_start != '')
        {
            $history->whereDate('created_at', '>=', $filter_start);
        }
        if ($filter_end != '')
        {
            $history->whereDate('created_at', '<=', $filter_end);
        }
        if ($game != 'all')
        // if ($game == 'all')
        {
            $history->where('account_id', $game);
        }

        $history->with('account')->with('form')->with('formGames')->whereHas('formGames') ->with('created_by')->orderBy('id', 'desc');



        // ->with(['formGames' => function ($query) use ($game) {
        //     return $query->where('id', 'relation_id');
        // }])
        // if($game && $game != 'all')
        // $query->where('account_id', $activeGame['id']);

        // ->whereHas('account', function ($query) use ($category) {
        //     if($category && $category != 'all')
        //     return $query->where('name', 'like', $category);
        // })
        // if($filter_end != ''){
        //     $history->where('type',$request->filter_type);
        // }
        // $history->whereBetween('created_at',[date($filter_start),date($filter_end)]);
        // $history->whereDate('created_at','<=', $filter_start)->whereDate('created_at','>=', $filter_end);
        // if($filter_start != ''){
        //     $history->where('type',$request->filter_type);
        // }
        // if($filter_end != ''){
        //     $history->where('type',$request->filter_type);
        // }
        $final = [];
            // return Response::json($history->get());
        $historys = $history->get()
            ->toArray();
        //         ->orderBy('id','desc')
        //         ->get()
        //         ->toArray();
        // if (!empty($historys))
        // {
        //     foreach ($historys as $a => $b)
        //     {
        //         $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first()
        //             ->toArray();
        //         $b['form_game'] = $form_game;
        //         ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
        //         ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
        //         ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
        //         ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
        //         ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

        //         array_push($final, $b);
        //     }
        //     $totals['profit'] = $totals['load'] - $totals['redeem'];
        // }

        // return Response::json([$final,$totals]);
        $data = [
            'filter_type' => $filter_type,
            'userId' => $userId,
            'game' => $game,
            'filter_start' => $filter_start,
            'filter_end' => $filter_end,
            'history' => $historys,
        ];
        // return Response::json([$final, $totals]);

        $return_array = [
            'status' => (count($historys) > 0)?1:0,
            'data' => $historys
        ];
        return Response::json($return_array);
    }
    public function filterUserHistoryAllData(Request $request)
    {
        $type = isset($request->filter_type) ? $request->filter_type : '';
        $year = isset($request->filter_year) ? $request->filter_year : '';
        $month = isset($request->filter_month) ? $request->filter_month : '';
        $day = isset($request->filter_day) ? $request->filter_day : '';
        $category = isset($request->filter_category) ? $request->filter_category : '';

        $history = History::with('account')->with('form')
            ->whereHas('account', function ($query) use ($category) {
                if($category && $category != 'all')
                return $query->where('name', 'like', $category);
            })
            ->with('created_by')
            ->orderBy('created_at', 'asc')
            ->get()
            ->toArray();
        $grouped = [];
        foreach ($history as $a => $b)
        {
            $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
            $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
            $b['created_at'] = date('Y-m-d', strtotime($b['created_at']));
            if(!empty($form_game)){
                $form_game->toArray();
                $b['form_game'] = $form_game;
            }

            if ($type == 'all')
            {
                if (($created_at[0] == $year) && ($created_at[1] == $month) && ($created_at[2] == $day))
                {
                    array_push($grouped, $b);
                }
            }
            else
            {
                if ($b['type'] == $type)
                {
                    if (($created_at[0] == $year) && ($created_at[1] == $month) && ($created_at[2] == $day))
                    {
                        array_push($grouped, $b);
                    }
                }
            }
        }
        return Response::json($grouped);
    }

    public function redeemStatus(Request $request){
        $id = $request->id;
        $redeem_status = $request->redeem_status;
        $year = ($request->year == '')?date('Y'):$request->year;
        $month = ($request->month == '')?date('m'):$request->month;;
        $status_date = $year.'-'.$month.'-1';

        try{
            // Form::where('id',$id)->update([
            //     'redeem_status' => $redeem_status
            // ]);

            FormRedeemStatus::updateOrCreate(
                ['form_id' => $id,'status_date' => $status_date],
                [
                    'status' => $redeem_status,
                    'created_by' => Auth::user()->id
                ]
            );
            return Response::json([
                'success' => 1,
                'created_by' => Auth::user()->name,
                'status' => $redeem_status
            ], 200);
        }catch(Exception $e){
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }
    }
    public function redeemHistory()
    {
        ini_set('max_execution_time', '300');
        // Form::query()->update(['balance' => 0]);
        //get
        $year = isset($_GET['year']) ? $_GET['year'] : '';
        $month = isset($_GET['month']) ? $_GET['month'] : '';
        $sel_cat = isset($_GET['category']) && $_GET['category'] ? $_GET['category'] : '';
        $game_categories = Account::select('name')->distinct()->get();
        $emptyMonth = 0;
        if (empty($year))
        {
            $year = date('Y');
        }
        if (empty($month))
        {
            $emptyMonth = 1;
            $month = date('m');
        }
        // $month = 2;
        if($emptyMonth == 0){
                if ($month < 10)
                {
                    $month = '0'.$month;
                }

        }
        $date = $year.'-'.$month.'-'.'01';
        $date_1 = Carbon::parse($date)->submonth()->format('Y-m-d');
        $date_2 = Carbon::parse($date_1)->submonth()->format('Y-m-d');
        $date_3 = Carbon::parse($date_2)->submonth()->format('Y-m-d');
        // dd($date_1,$date_2,$date_3);
        // if (Auth::user()->role != 'admin'){
        //     $history = FormRedeem::whereHas('account', function ($query) {
        //                             if(isset($_GET['category']) && $_GET['category'])
        //                             return $query->where('name', 'like', $_GET['category']);
        //                         })
        //                         ->where('created_by',Auth::user()->id);
        // }else{
            $history = FormRedeem::whereHas('account', function ($query) {
                                    if(isset($_GET['category']) && $_GET['category'])
                                    return $query->where('name', 'like', $_GET['category']);
                                });
        // }
        $history = $history->with('form')
                    ->whereHas('form')
                    // ->where('form_id',488)
                    ->with('balance',function($query) use ($date,$year,$month){
                        $query->whereBetween('created_at', [$date, $year . '-' . $month . '-31']);
                    })
                    ->with('redeemstatus',function($query) use ($date){
                        return $query->whereDate('status_date', '=', date($date));
                    })
                    ->with('redeemstatus1',function($query) use ($date_1){
                        return $query->whereDate('status_date', '=', date($date_1));
                    })
                    ->with('redeemstatus2',function($query) use ($date_2){
                        return $query->where('status_date', date($date_2));
                    })
                    ->with('redeemstatus3',function($query) use ($date_3){
                        return $query->whereDate('status_date', '=', date($date_3));
                    })
                    // ->whereHas('redeemstatus')
                    // ->limit(1)
                    ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
                    ->whereDate('created_at', '<=', date($year . '-' . $month . '-31'))
                    ->orderBy('id', 'desc');
                    // whereDate('status_date',($date_2))->
                    // dd(FormRedeemStatus::withTrashed()->where('form_id',644)->get()->toArray());
// dd(FormRedeemStatus::get()->toArray(),FormRedeemStatus::whereDate('status_date',($date_2))->where('form_id',644)->get()->toArray(),$date_1,$date_2,$date_3);
//                     echo date($date_2);
                    // dd($history->get()->toArray(),$date);
        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0, 'count' => 0];
        $grouped = [];
        // dd($history->get()->toArray());
        if (($history->count() > 0))
        {
                // if (Auth::user()->role != 'admin'){
                //     $history = $history->where('created_by',Auth::user()->id)->get()->toArray();
                // }else{
                    $history = $history->get()->toArray();
                // }
            foreach ($history as $a => $b)
            {
                $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
                if (!(isset($grouped[$b['form_id']])))
                {
                    $grouped[$b['form_id']] = [
                        'tip' => 0,
                        'load' => 0,
                        'redeem' => 0,
                        'refer' => 0,
                        'cashAppLoad' => 0,
                        'totalLoad' => 0,
                        'count' => 0,
                        'form' => $b['form'],
                        'redeemstatus' => $b['redeemstatus'],
                        'redeemstatus1' => $b['redeemstatus1'],
                        'redeemstatus2' => $b['redeemstatus2'],
                        'redeemstatus3' => $b['redeemstatus3']
                    ];
                }
                $creator = [];
                if(isset($b['redeemstatus']['created_by']) && !empty($b['redeemstatus']['created_by'])){
                    $creator = User::where('id',$b['redeemstatus']['created_by']);
                    if($creator->count() > 0){
                        $creator = $creator->first()->toArray();
                    }
                }
                $grouped[$b['form_id']]['totalLoad'] = array_sum(array_column($b['balance'], 'amount'));
                $grouped[$b['form_id']]['creator'] = $creator;
                $grouped[$b['form_id']]['redeem'] = $grouped[$b['form_id']]['redeem'] + $b['amount'];
                $grouped[$b['form_id']]['count'] += 1;
                $totals['redeem'] = $totals['redeem'] + $b['amount'];
            }
        }
        // dd($grouped);
        $new = [];
        $doubt = [];
        $countVerified = count($grouped);
        $count = 0;
        foreach($grouped as $a => $b){
            $z = self::recursiveCheck($new,$b['redeem']);
            // echo $z.'-';
            if(isset($b['redeemstatus']['status']) && $b['redeemstatus']['status'] == 2){
                $doubt[$z] = $b;
            }elseif(isset($b['redeemstatus']['status']) && $b['redeemstatus']['status'] == 1){
                $doubt[$z] = $b;
            }
            else{
                $new[$z] = $b;
            }
            // if((isset($new[$b['redeem']]))){
            //     $z = $b['redeem'] + 1;
            //     $new[$z] = $b;
            // }else{
            //     $new[$b['redeem']] = $b;
            // }
            // $new[$b['redeem']] = [];
            // $redeem_status1 = FormRedeemStatus::where(['status_date' => date($date_2),'form_id' => $b['form']['id']])->get();
            // echo $b['redeem'].'-';
            // if (!empty($b['redeemstatus']) && isset($b['redeemstatus']['status']) && $b['redeemstatus']['status'] == 2) {
            //     $countVerified -= 1;
            // }
            $count += 1;
            // if(!($redeem_status1->isEmpty())){
            //     $new[$b['redeem']]['redeem_status1'] = $redeem_status1;
            // }else{
            //     $new[$b['redeem']]['redeem_status1'] = null;
            // }
            // echo $count + 1;
        }
        krsort($new);
        array_reverse($new);
        $grouped = $new;
        // dd($doubt);
        // dd($new);
        // dd($grouped);
        // dd($new);
        // dd($grouped,$history);
        $total = $totals;
        $history = [];

        $all_months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
        // dd($grouped,$year,$month,$history,$totals);
        $forms = Form::orderBy('id', 'desc')->get()->toArray();
        $games = Account::orderBy('id', 'desc')->get()->toArray();


        $form_games = FormGame::orderBy('id', 'desc')->with('form')->whereHas('form')->get()->toArray();
        // dd($form_games);
        $status = [
            [
                'id' => 1,
                'name' => 'verified'
            ],
            [
                'id' => 2,
                'name' => 'doubtful'
            ],
        ];
        // dd($grouped);
        return view('newLayout.redeem-history', compact('doubt','countVerified','status','grouped', 'month', 'year', 'form_games','total', 'all_months','forms','games','game_categories','sel_cat'));
    }
    
    public function recursiveCheck($new,$redeem){
        $newRedeem = 0;
        // dd('asd');
        if((key_exists($redeem,$new))){
            // echo '<pre>';
            // print_r($new);
            // echo '</pre>';
            $newRedeem = $redeem + 1;
            self::recursiveCheck($new,$newRedeem);
        }else{
            // dd($new);
            // echo 'no-';
            return $redeem;
        }
        return $newRedeem;
    }
     public function allData()
    {
        ini_set('max_execution_time', '300');
        // Form::query()->update(['balance' => 0]);
        //get
        $year = isset($_GET['year']) ? $_GET['year'] : '';
        $month = isset($_GET['month']) ? $_GET['month'] : '';
        $sel_cat = isset($_GET['category']) && $_GET['category'] ? $_GET['category'] : '';
        $game_categories = Account::select('name')->distinct()->get();

        if (empty($year))
        {
            $year = date('Y');
        }
        if (empty($month))
        {
            $month = date('m');
        }
        if (Auth::user()->role != 'admin'){
            $history = History::whereHas('account', function ($query) {
                                    if(isset($_GET['category']) && $_GET['category'])
                                    return $query->where('name', 'like', $_GET['category']);
                                })
                                ->where('created_by',Auth::user()->id)
                                ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
                                ->whereDate('created_at', '<=', date($year . '-' . $month . '-31'))
                                ->orderBy('id', 'desc')
                                ->count();
        }else{
            $history = History::whereHas('account', function ($query) {
                                    if(isset($_GET['category']) && $_GET['category'])
                                    return $query->where('name', 'like', $_GET['category']);
                                })
                                ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
                                ->whereDate('created_at', '<=', date($year . '-' . $month . '-31'))
                                ->orderBy('id', 'desc')
                                ->count();
        }
        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0, 'count' => 0];
        $grouped = [];
        if (($history > 0))
        {
                if (Auth::user()->role != 'admin'){
                    $history = History::whereHas('account', function ($query) {
                                    if(isset($_GET['category']) && $_GET['category'])
                                    return $query->where('name', 'like', $_GET['category']);
                                })
                                ->where('created_by',Auth::user()->id)
                                        ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
                                        ->whereDate('created_at', '<=', date($year . '-' . $month . '-31'))
                                        ->orderBy('id', 'desc')
                                        ->get()
                                        ->toArray();
                }else{
                    $history = History::whereHas('account', function ($query) {
                                    if(isset($_GET['category']) && $_GET['category'])
                                    return $query->where('name', 'like', $_GET['category']);
                                })
                                ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
                                        ->whereDate('created_at', '<=', date($year . '-' . $month . '-31'))
                                        ->orderBy('id', 'desc')
                                        ->get()
                                        ->toArray();
                }
            foreach ($history as $a => $b)
            {
                $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
                if (!(isset($grouped[$created_at[2]])))
                {
                    $grouped[$created_at[2]] = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0, 'count' => 0];
                }
                ($b['type'] == 'tip') ? ($grouped[$created_at[2]]['tip'] = $grouped[$created_at[2]]['tip'] + $b['amount_loaded']) : ($grouped[$created_at[2]]['tip'] = $grouped[$created_at[2]]['tip']);
                ($b['type'] == 'load') ? ($grouped[$created_at[2]]['load'] = $grouped[$created_at[2]]['load'] + $b['amount_loaded']) : ($grouped[$created_at[2]]['load'] = $grouped[$created_at[2]]['load']);
                ($b['type'] == 'redeem') ? ($grouped[$created_at[2]]['redeem'] = $grouped[$created_at[2]]['redeem'] + $b['amount_loaded']) : ($grouped[$created_at[2]]['redeem'] = $grouped[$created_at[2]]['redeem']);
                ($b['type'] == 'refer') ? ($grouped[$created_at[2]]['refer'] = $grouped[$created_at[2]]['refer'] + $b['amount_loaded']) : ($grouped[$created_at[2]]['refer'] = $grouped[$created_at[2]]['refer']);
                ($b['type'] == 'cashAppLoad') ? ($grouped[$created_at[2]]['cashAppLoad'] = $grouped[$created_at[2]]['cashAppLoad'] + $b['amount_loaded']) : ($grouped[$created_at[2]]['cashAppLoad'] = $grouped[$created_at[2]]['cashAppLoad']);
                $grouped[$created_at[2]]['count'] += 1;

                ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

            }

            // return view('newLayout.alldata', compact('grouped', 'month', 'year','total'));

        }
        $total = $totals;
        $history = [];

        $all_months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
        // dd($grouped,$year,$month,$history,$totals);
        $forms = Form::orderBy('id', 'desc')->get()->toArray();
        $games = Account::orderBy('id', 'desc')->get()->toArray();


        $form_games = FormGame::orderBy('id', 'desc')->with('form')->whereHas('form')->get()->toArray();
        // dd($form_games);
        return view('newLayout.alldata', compact('grouped', 'month', 'year', 'form_games','total', 'all_months','forms','games','game_categories','sel_cat'));
    }
    public function allData1()
    {

        $history = History::with('account')->with('created_by')
            ->orderBy('created_at', 'asc')
            ->count();
        $final = [];
        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
        $forms = [];

        $data = [['SN', 'Date', 'FB Name', 'Game', 'Game ID', 'Amount', 'Type', 'Creator']];
        if (($history > 0))
        {
            $history = History::with('account')->with('form')
                ->whereHas('form')
                ->with('created_by')
            // ->whereDate('created_at', Carbon::today())

                ->orderBy('created_at', 'asc')
                ->get()
            // ->groupby('id')

                ->toArray();
            // $visitors = History::select('*')
            //     ->orderBy('created_at')
            //     ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            //     ->get();
            // dd($history);
            // $history = DB::table('histories')
            // ->groupBy(DB::raw("DATE_FORMAT(created_at, '%m-%Y')"))
            // ->get();
            $grouped = [];
            foreach ($history as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));

                if (!(isset($grouped[$created_at[0]])))
                {
                    $grouped[$created_at[0]] = [];
                }

                if (!(isset($grouped[$created_at[0]][$created_at[1]])))
                {
                    $grouped[$created_at[0]][$created_at[1]] = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
                }

                // if(isset($grouped[$created_at[0]])){
                //     $grouped[$created_at[0]][$created_at[1]] = [];
                // }
                if (!empty($form_game))
                {
                    $form_game->toArray();

                    $b['form_game'] = $form_game;

                    ($b['type'] == 'tip') ? ($grouped[$created_at[0]][$created_at[1]]['tip'] = $grouped[$created_at[0]][$created_at[1]]['tip'] + $b['amount_loaded']) : ($grouped[$created_at[0]][$created_at[1]]['tip'] = $grouped[$created_at[0]][$created_at[1]]['tip']);
                    ($b['type'] == 'load') ? ($grouped[$created_at[0]][$created_at[1]]['load'] = $grouped[$created_at[0]][$created_at[1]]['load'] + $b['amount_loaded']) : ($grouped[$created_at[0]][$created_at[1]]['load'] = $grouped[$created_at[0]][$created_at[1]]['load']);
                    ($b['type'] == 'redeem') ? ($grouped[$created_at[0]][$created_at[1]]['redeem'] = $grouped[$created_at[0]][$created_at[1]]['redeem'] + $b['amount_loaded']) : ($grouped[$created_at[0]][$created_at[1]]['redeem'] = $grouped[$created_at[0]][$created_at[1]]['redeem']);
                    ($b['type'] == 'refer') ? ($grouped[$created_at[0]][$created_at[1]]['refer'] = $grouped[$created_at[0]][$created_at[1]]['refer'] + $b['amount_loaded']) : ($grouped[$created_at[0]][$created_at[1]]['refer'] = $grouped[$created_at[0]][$created_at[1]]['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($grouped[$created_at[0]][$created_at[1]]['cashAppLoad'] = $grouped[$created_at[0]][$created_at[1]]['cashAppLoad'] + $b['amount_loaded']) : ($grouped[$created_at[0]][$created_at[1]]['cashAppLoad'] = $grouped[$created_at[0]][$created_at[1]]['cashAppLoad']);

                    // array_push($final, $b);
                    // array_push($forms, $b['form']);

                }
            }

            $count = 1;
            foreach ($final as $key => $item)
            {
                $z = [$count++, date('d M,Y', strtotime($item['created_at'])) , $item['form']['facebook_name'], $item['form_game']['game_id'], $item['amount_loaded'], $item['type'], $item['created_by']['name']];
                array_push($data, $z);
            }

            // $activeGame['form_games'] = $final;

        }
        $games = Account::where('status', 'active')->get()
            ->toArray();
        // $filename = 'file.csv';
        // header('Content-Type: application/csv; charset=UTF-8');
        // header('Content-Disposition: attachment;filename="'.$filename.'";');
        // ob_clean();
        // flush();
        // $f = fopen('php://output', 'w');
        // foreach ($data as $line) {
        //     fputcsv($f, $line, ';');
        // }
        // $totals = [
        //     ['Total Tip','Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
        //     [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
        // ];
        $totals_2 = [['', ''], ['Total Tip', $totals['tip']], ['Total Balance', $totals['load']], ['Total Redeem', $totals['redeem']], ['Total Refer', $totals['refer']], ['Total Amount', $totals['cashAppLoad']], ['Total Profit', ($totals['load'] - $totals['redeem']) ],
        // 'Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
        // [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
        ];
        // foreach ($totals_2 as $line) {
        //     fputcsv($f, $line, ';');
        // }
        // fclose($f);
        // exit;
        $total = $totals;
        dd($final);
        return view('newLayout.history', compact('final', 'total', 'games', 'forms'));
    }
    public function redeems(Request $request)
    {
        // dd($request->all());
        $filter_start= '';
        $filter_end = '';
        $filter_start = $request->start_date;
        $filter_end = $request->end_date;
        if (Auth::user()->role != 'admin'){
            $history = FormRedeem::where('created_by',Auth::user()->id)->orderBy('id', 'desc')->count();
        }else{
            $history = FormRedeem::orderBy('id', 'desc')->count();
        }
        $final = [];
        $totals = 0;
        $forms = [];

        $data = [['SN', 'Date', 'FB Name', 'Game', 'Game ID', 'Amount', 'Type', 'Creator']];
        if (($history > 0))
        {
            if (Auth::user()->role != 'admin'){
                $history = FormRedeem::groupBy('form_id')
                                        ->selectRaw('sum(amount) as sum, form_id')
                                        ->with('form')
                                        ->whereHas('form')
                                        ->orderBy('sum','desc')
                                        ->where('created_by',Auth::user()->id)
                                        ->orderBy('id', 'desc');
            }else{
                $history = FormRedeem::groupBy('form_id')->selectRaw('sum(amount) as sum, form_id')->with('form')->whereHas('form')->orderBy('sum','desc');
            }
            if ($filter_start != '')
            {
                $history->whereDate('created_at', '>=', $filter_start);
            }
            if ($filter_end != '')
            {
                $history->whereDate('created_at', '<=', $filter_end);
            }

           $history = $history->get()->toArray();
        //    dd($filter_start,$filter_end,$history);
        }
        return view('newLayout.redeems-history', compact('history','filter_start','filter_end'));
    }
    public function todaysHistory()
    {
        if (Auth::user()->role != 'admin'){
            $history = History::where('created_by',Auth::user()->id)->orderBy('id', 'desc')->count();
        }else{
            $history = History::orderBy('id', 'desc')->count();
        }
        $final = [];
        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
        $forms = [];

        $data = [['SN', 'Date', 'FB Name', 'Game', 'Game ID', 'Amount', 'Type', 'Creator']];
        if (($history > 0))
        {

            if (Auth::user()->role != 'admin'){
                $history = History::with('account')->with('form')->whereHas('form')->where('created_by',Auth::user()->id)->orderBy('id', 'desc')->whereDate('created_at', Carbon::today())->with('created_by')->get()->toArray();
            }else{
                $history = History::with('account')->with('form')->whereHas('form')->with('created_by')->whereDate('created_at', Carbon::today())->orderBy('id', 'desc')->get()->toArray();
            }
            // $history = History::with('account')->with('form')
            //     ->whereHas('form')
            //     ->with('created_by')
            //     ->whereDate('created_at', Carbon::today())
            //     ->orderBy('id', 'desc')
            //     ->get()
            //     ->toArray();
            foreach ($history as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                if (!empty($form_game))
                {
                    $form_game->toArray();

                    $b['form_game'] = $form_game;

                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                    array_push($final, $b);
                    array_push($forms, $b['form']);
                }
            }
            $count = 1;
            foreach ($final as $key => $item)
            {
                $z = [$count++, date('d M,Y', strtotime($item['created_at'])) , $item['form']['facebook_name'], $item['form_game']['game_id'], $item['amount_loaded'], $item['type'], $item['created_by']['name']];
                array_push($data, $z);
            }

            // $activeGame['form_games'] = $final;

        }
        $games = Account::where('status', 'active')->get()
            ->toArray();
        // $filename = 'file.csv';
        // header('Content-Type: application/csv; charset=UTF-8');
        // header('Content-Disposition: attachment;filename="'.$filename.'";');
        // ob_clean();
        // flush();
        // $f = fopen('php://output', 'w');
        // foreach ($data as $line) {
        //     fputcsv($f, $line, ';');
        // }
        // $totals = [
        //     ['Total Tip','Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
        //     [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
        // ];
        $totals_2 = [['', ''], ['Total Tip', $totals['tip']], ['Total Balance', $totals['load']], ['Total Redeem', $totals['redeem']], ['Total Refer', $totals['refer']], ['Total Amount', $totals['cashAppLoad']], ['Total Profit', ($totals['load'] - $totals['redeem']) ],
        // 'Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
        // [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
        ];
        // foreach ($totals_2 as $line) {
        //     fputcsv($f, $line, ';');
        // }
        // fclose($f);
        // exit;
        $total = $totals;
        return view('newLayout.history', compact('final', 'total', 'games', 'forms'));
    }
    public function allHistory()
    {
        if(auth()->role=='admin'){
            $history = History::with('account')->with('form')
            ->whereHas('form')
            ->with('created_by')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
        }else{
            $history = History::where('created_by',auth()->id)->with('account')->with('form')
            ->whereHas('form')
            ->with('created_by')
            ->orderBy('id', 'desc')
            ->get()
            ->toArray();
        }
        
        $final = [];
        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first()
                    ->toArray();
                $b['form_game'] = $form_game;

                array_push($final, $b);
            }
            // $activeGame['form_games'] = $final;

        }
        return Response::json($final);
    }
    public function undoHistory()
    {

        $history = History::with('account')->with('form')
            ->whereHas('form')
            ->with('created_by')
            ->orderBy('id', 'desc')
            ->take(100)
            ->get()
            ->toArray();
        $final = [];
        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                if ($form_game)
                {
                    $form_game->toArray();
                    $b['form_game'] = $form_game;
                    array_push($final, $b);
                }
            }
            // $activeGame['form_games'] = $final;

        }
        return Response::json($final);
    }

    public function undoItemHistory($id)
    {
        try
        {
            $history = History::findOrFail($id);

            $related_id = $history->relation_id;
            $type = $history->type;
            $account_id = $history->account_id;
            $cash_apps_id = $history->cash_apps_id;
            $amount = $history->amount_loaded;
            // $related = FormRedeem::where('id',$related_id)->get();
            //  dd($related);
                $newAmount = 0;
            if ($type == 'tip')
            {
                $related = FormTip::find($related_id)->delete();
            }
            elseif ($type == 'redeem')
            {
                $related = FormRedeem::where('id',$related_id)->count();
                if($related >0){
                    $related = FormRedeem::find($related_id)->delete();
                }
                $account = Account::findOrFail($account_id);
                $cashApp = CashApp::findOrFail($cash_apps_id);
                $account = Account::where('id', $account_id)->update(['balance' => ($account->balance - $amount) ]);
                $cashApp = CashApp::where('id', $cash_apps_id)->update(['balance' => ($cashApp->balance + $amount) ]);
                $account = Account::findOrFail($account_id);
                $newAmount = $account->balance;
            }
            elseif ($type == 'refer')
            {
                $related = FormRefer::where('id',$related_id)->count();
                if($related >0){
                    $related = FormRefer::find($related_id)->delete();
                }
                $account = Account::findOrFail($account_id);
                $accountBalance = $account->balance;
                $account = Account::where('id', $account_id)->update(['balance' => ($accountBalance + $amount) ]);
                $account = Account::findOrFail($account_id);
                $newAmount = $account->balance;
            }
            elseif ($type == 'load')
            {
                $related = FormBalance::where('id',$related_id)->count();
                if($related >0){
                    $related = FormBalance::find($related_id)->delete();
                }

                $account = Account::findOrFail($account_id);
                $accountBalance = $account->balance;
                $account = Account::where('id', $account_id)->update(['balance' => ($accountBalance + $amount) ]);
                $account = Account::findOrFail($account_id);
                $newAmount = $account->balance;
            }
            elseif ($type == 'cashAppLoad')
            {
                $related = CashAppForm::find($related_id)->delete();
                $cashApp = CashApp::findOrFail($cash_apps_id);
                $cashAppBalance = $cashApp->balance;
                $updateCashApp = CashApp::where('id', $cash_apps_id)->update(['balance' => ($cashAppBalance - $amount) ]);
            }
            try{
                $history->delete();
                $data = [
                    'type' => $type,
                    'amount' => $amount,
                    'newAmount' => $newAmount
                ];
                return Response::json(['success' => $data], 200);
            }catch(Exception $e){
                $bug = $e->getMessage();
                return Response::json(['error' => $bug], 404);
            }

            // return back()->with('success', "Transaction undo successful");
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            // dd($bug);
            return Response::json(['error' => $bug], 404);
        }
        Response::json('asdfasdf');
        // return redirect(route('table'))->with('success', "Transaction undo successful");
    }
    public function undoTable($id)
    {
        try
        {
            $history = History::findOrFail($id);

            $related_id = $history->relation_id;
            $type = $history->type;
            $account_id = $history->account_id;
            $cash_apps_id = $history->cash_apps_id;
            $amount = $history->amount_loaded;
            // $related = FormRedeem::where('id',$related_id)->get();
            //  dd($related);
            if ($type == 'tip')
            {
                $related = FormTip::find($related_id)->delete();
            }
            elseif ($type == 'redeem')
            {
                $related = FormRedeem::find($related_id)->delete();
                $account = Account::findOrFail($account_id);
                $cashApp = CashApp::findOrFail($cash_apps_id);
                $account = Account::where('id', $account_id)->update(['balance' => ($account->balance - $amount) ]);
                $cashApp = CashApp::where('id', $cash_apps_id)->update(['balance' => ($cashApp->balance + $amount) ]);
            }
            elseif ($type == 'refer')
            {
                $related = FormRefer::find($related_id)->delete();
                $account = Account::findOrFail($account_id);
                $accountBalance = $account->balance;
                $account = Account::where('id', $account_id)->update(['balance' => ($accountBalance + $amount) ]);
            }
            elseif ($type == 'load')
            {
                $related = FormBalance::find($related_id)->delete();
                $account = Account::findOrFail($account_id);
                $accountBalance = $account->balance;
                $account = Account::where('id', $account_id)->update(['balance' => ($accountBalance + $amount) ]);
            }
            elseif ($type == 'cashAppLoad')
            {
                $related = CashAppForm::find($related_id)->delete();
                $cashApp = CashApp::findOrFail($cash_apps_id);
                $cashAppBalance = $cashApp->balance;
                $updateCashApp = CashApp::where('id', $cash_apps_id)->update(['balance' => ($cashAppBalance - $amount) ]);
            }
            // switch($type) {
            //     case('tip'):
            //     case('redeem'):
            //     case('refer'):
            //         case('load'):
            //     case('cashAppLoad'):
            // }
            $history->delete();
            return back()
                ->with('success', "Transaction undo successful");
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }

        return redirect(route('table'))->with('success', "Transaction undo successful");
    }
    public function userHistory(Request $request)
    {
        $type = $request->type;
        $getType = $request->getType;

        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
        $final = [];
        if (!empty($getType) && $getType == 'all')
        {
            $history = History::where('form_id', $request->userId)
                ->with('account')
                ->with('created_by')
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();

            if (!empty($history))
            {
                foreach ($history as $a => $b)
                {
                    $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first()
                        ->toArray();
                    $b['form_game'] = $form_game;
                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                    array_push($final, $b);
                }
                $totals['profit'] = $totals['load'] - $totals['redeem'];
            }
            return Response::json([$final, $totals]);
        }
        if (!empty($type))
        {
            $history = History::where('account_id', $request->game)
                ->where('form_id', $request->userId)
                ->where('type', $request->type)
                ->with('created_by')
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();
        }
        else
        {

            $history = History::where('form_id', $request->userId)
            // ->where('account_id', $request->game)
                ->with('created_by')
                ->orderBy('id', 'desc')
                ->get()
                ->toArray();
        }
        // return Response::json([$request->game,$request->userId,$request->type]);
        return Response::json($history);
    }

    public function filterUserHistory(Request $request)
    {
        $filter_type = $request->filter_type;
        $userId = $request->userId;
        $game = $request->game;
        $filter_start = $request->filter_start;
        $filter_end = $request->filter_end;
        $historyType = $request->historyType;

        $history = History::query();

        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

        if ($filter_type != 'all')
        {
            $history->where('type', $request->filter_type);
        }

        // $history->when(request('filter_type', '!=','all'), function ($q, $filter_type) {
        //     return $q->where('type',$filter_type);
        // });
        // return Response::json($historys);
        if ($filter_start != '')
        {
            $history->whereDate('created_at', '>=', $filter_start);
        }
        if ($filter_end != '')
        {
            $history->whereDate('created_at', '<=', $filter_end);
        }
        if ($historyType == '')
        {
            $history->where('account_id', $game);
        }

        $history->where('form_id', $userId)->with('account')
            ->with('created_by')
            ->orderBy('id', 'desc');
        // if($filter_end != ''){
        //     $history->where('type',$request->filter_type);
        // }
        // $history->whereBetween('created_at',[date($filter_start),date($filter_end)]);
        // $history->whereDate('created_at','<=', $filter_start)->whereDate('created_at','>=', $filter_end);
        // if($filter_start != ''){
        //     $history->where('type',$request->filter_type);
        // }
        // if($filter_end != ''){
        //     $history->where('type',$request->filter_type);
        // }
        $final = [];
        $historys = $history->get()
            ->toArray();
        //         ->orderBy('id','desc')
        //         ->get()
        //         ->toArray();
        if (!empty($historys))
        {
            foreach ($historys as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first()
                    ->toArray();
                $b['form_game'] = $form_game;
                ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                array_push($final, $b);
            }
            $totals['profit'] = $totals['load'] - $totals['redeem'];
        }

        // return Response::json([$final,$totals]);
        // $data = [
        //     'filter_type' => $filter_type,
        //     'userId' => $userId,
        //     'game' => $game,
        //     'filter_start' => $filter_start,
        //     'filter_end' => $filter_end,
        //     'history' => $historys,
        // ];
        return Response::json([$final, $totals]);
        return Response::json($data);
    }

    public function export(Request $request)
    {
        $filter_type = $request->filter_type;
        $filter_start = $request->filter_start;
        $filter_end = $request->filter_end;
        $filter_game = $request->filter_game;
        $filter_user = $request->filter_user;

        $history = History::query();

        if ($filter_game != 'all')
        {
            $history->where('account_id', '=', $filter_game);
        }
        if ($filter_user != 'all')
        {
            $history->where('form_id', '=', $filter_user);
        }
        if ($filter_start != '')
        {
            $history->whereDate('created_at', '>=', $filter_start);
        }
        if ($filter_end != '')
        {
            $history->whereDate('created_at', '<=', $filter_end);
        }

        $history->with('form')
            ->whereHas('form')
            ->with('account')
            ->with('created_by')
            ->orderBy('id', 'desc');

        $historys = $history->get()
            ->toArray();

        $final = [];
        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
        $forms = [];

        $data = [
        // ['SN', 'Date', 'FB Name','Game','Game ID','Amount','Type','Creator']
        ];
        if (!empty($historys))
        {
            foreach ($historys as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                if (!empty($form_game))
                {
                    $form_game->toArray();
                    $b['form_game'] = $form_game;

                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);

                    array_push($final, $b);
                    array_push($forms, $b['form']);
                }
            }
            $count = 1;
            foreach ($final as $key => $item)
            {
                $z = [$count++, date('d M,Y', strtotime($item['created_at'])) , $item['form']['facebook_name'], $item['account']['name'], $item['form_game']['game_id'], $item['amount_loaded'], $item['type'], $item['created_by']['name']];
                array_push($data, $z);
            }
            // return $data;
            // $filename = 'file.csv';
            // header('Content-Type: application/csv; charset=UTF-8');
            // header('Content-Disposition: attachment;filename="'.$filename.'";');
            // ob_clean();
            // flush();
            // $f = fopen('php://output', 'w');
            // foreach ($data as $line) {
            // fputcsv($f, $line, ';');
            // }
            $totals_2 = [['', ''], ['Total Tip', $totals['tip']], ['Total Balance', $totals['load']], ['Total Redeem', $totals['redeem']], ['Total Refer', $totals['refer']], ['Total Amount', $totals['cashAppLoad']], ['Total Profit', ($totals['load'] - $totals['redeem']) ],
            // 'Total Balance','Total Redeem','Total Refer','Total Amount','Total Profit'],
            // [$totals['tip'],$totals['load'],$totals['redeem'],$totals['refer'],$totals['cashAppLoad'],($totals['load'] - $totals['redeem'])],
            ];
            // foreach ($totals_2 as $line) {
            //     fputcsv($f, $line, ';');
            // }
            // fclose($f);
            // exit;
            return [$data, $totals_2];
            // return Response::json('success');
            // $activeGame['form_games'] = $final;

        }
        else
        {
            return Response::json(['error' => 'History is Empty'], 404);
        }
        return Response::json(['error' => 'Something went wrong'], 404);
    }
    public function filterAllHistory(Request $request)
    {
        $filter_type = $request->filter_type;
        $filter_start = $request->filter_start;
        $filter_end = $request->filter_end;
        $filter_game = $request->filter_game;
        $filter_user = $request->filter_user;

        $history = History::query();

        if ($filter_type != 'all')
        {
            $history->where('type', $request->filter_type);
        }

        // $history->when(request('filter_type', '!=','all'), function ($q, $filter_type) {
        //     return $q->where('type',$filter_type);
        // });
        // return Response::json($historys);
        if ($filter_game != 'all')
        {
            $history->where('account_id', '=', $filter_game);
        }
        if ($filter_user != 'all')
        {
            $history->where('form_id', '=', $filter_user);
        }
        if ($filter_start != '')
        {
            $history->whereDate('created_at', '>=', $filter_start);
        }
        if ($filter_end != '')
        {
            $history->whereDate('created_at', '<=', $filter_end);
        }

        $history->with('form')
            ->whereHas('form')
            ->with('account')
            ->with('created_by')
            ->orderBy('id', 'desc');

        $historys = $history->get();

        $final = [];

        $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0, 'profit' => 0];
        if (!empty($historys))
        {
            foreach ($historys as $a => $b)
            {
                $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->count();
                if ($form_game > 0)
                {
                    $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first()
                        ->toArray();
                    $b['form_game'] = $form_game;

                    ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                    ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);
                    // switch($b['type']) {
                    // case('tip'):
                    //     $totals['tip'] = $totals['tip'] + $b['amount_loaded'];
                    //     case('load'):
                    //         $totals['load'] = $totals['load'] + $b['amount_loaded'];
                    //     case('redeem'):
                    //         $totals['redeem'] = $totals['redeem'] + $b['amount_loaded'];
                    //     case('refer'):
                    //         $totals['refer'] = $totals['refer'] + $b['amount_loaded'];
                    //     case('cashAppLoad'):
                    //         $totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded'];
                    // }
                    array_push($final, $b);
                }

            }
            $totals['profit'] = $totals['load'] - $totals['redeem'];
            // $activeGame['form_games'] = $final;

        }

        // $data = [
        //     'filter_type' => $filter_type,
        //     'userId' => $userId,
        //     'game' => $game,
        //     'filter_start' => $filter_start,
        //     'filter_end' => $filter_end,
        //     'history' => $historys,
        // ];
        // dd();
        // $final['totals'] = $totals;
        return Response::json([$final, $totals]);
    }
    public function games()
    {
        $total = Account::count();
        $forms = Account::orderBy('id', 'desc')->get();
        $trashed = Account::onlyTrashed()->orderBy('id', 'desc')
            ->get()
            ->toArray();
        return view('newLayout.games', compact('total', 'forms', 'trashed'));
    }
       public function gameImage($id){
        if($id != ''){
            $game = Account::where('id',$id)->first();
            return view('newLayout.gameImages',compact('game'));
        }
        return back();
    }
      public function gameExtraImageStore(Request $request){
        // dd($request->file('file'));
        if ($request->hasFile('file'))
        {
            $game = Account::where('id',$request->id)->first();
            if($game->extra_images == ''){
                $array = [];
            }else{
                $array = explode(',',$game->extra_images);
            }

            foreach ($request->file('file') as $file) {
                $image_name = md5(rand(10,100));
                $ext = strtolower($file->getClientOriginalExtension());
                $image_full_name = $image_name.'.'.$ext;
                $file->move(base_path() . '/public/uploads/games/',$image_full_name);

                // $img = $request->file('file');
                // $name = time() . '.' . $img->extension().rand(10,100);
                // $img->move(base_path() . '/public/uploads/', $name);
                array_push($array,$image_full_name);
            }
            $game->extra_images = implode(',',$array);
            try{
                $game->save();
                return back()->with('success', 'Images Saved');

            }catch(\Exception $e){
                $bug = $e->getMessage();
                return back()->with('error', $bug);
            }
        }
    }
    public function gameImageDestroy($id,$key){
        try
        {
            $form = Account::where('id', $id)->first();
            $extra_images = $form->extra_images;
            if(!empty($extra_images)){
                $extra_images = explode(',',$extra_images);
                if(isset($extra_images[$key])){
                    unset($extra_images[$key]);
                    $form->extra_images = implode(',',$extra_images);
            // dd($extra_images);
                    $form->save();
                    return back()->with('message', " Deleted Successfully");
                }else{
                    return back()->with('error', 'Image Not Found');
                }
            }else{
                return back()->with('error', 'Images Empty');
            }
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return back()->with('error', $bug);
        }
    }
    public function gameDestroy($id)
    {
        try
        {
            $form = Account::findOrFail($id);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect(route('gamers'))
                ->with('error', $bug);
        }
        if ($form->delete() == true)
        {
            $delete_form_balance = FormBalance::where('form_id', $id)->delete();
            return Response::json('true');
        }
        else
        {
            return Response::json(['error' => $bug], 404);
        }
    }
    public function gameEdit($id)
    {
        $form = Account::where('id', $id)->first();
        $html = view('new.gameEditModal', compact('form'))->render();
        return Response::json($html);
    }

    public function gamerUpdateBalance(Request $request)
    {
        // $request = $_POST[];
        // return Response::json($id);
        $id = $request->game_id;
        try
        {
            $form = Account::findOrFail($id);
            $form->balance = isset($request['game_balance']) ? ($form->balance + $request['game_balance']) : null;
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()
                ->back()
                ->with('error', $bug);
        }
        if ($form->save() == true)
        {
            return redirect()
                ->back()
                ->with('success', 'Game Updated');
        }
        else
        {
            return redirect()
                ->back()
                ->with('error', $form);
        }
    }
    public function gameUpdate(Request $request, $id)
    {
        
        try
        {
            $form = Account::findOrFail($id);

            if (!(isset($request['name']) && !empty($request['name'])))
            {
                return Response::json(['error' => 'Game Name is Empty'], 404);
            }
            if (!(isset($request['title']) && !empty($request['title'])))
            {
                return Response::json(['error' => 'Title is Empty'], 404);
            }
            if (!(isset($request['balance']) && !empty($request['balance'])))
            {
                return Response::json(['error' => 'Balance is Empty'], 404);
            }
            $form->name = isset($request['name']) ? $request['name'] : null;
            $form->title = isset($request['title']) ? $request['title'] : null;
            $form->balance = isset($request['balance']) ? $request['balance'] : null;
            $form->game_url = isset($request['game_url']) ? $request['game_url'] : null;
            $form->status = isset($request['status']) ? $request['status'] : 'inactive';
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }
        if ($form->save() == true)
        {
            return back();
        }
        else
        {
            return Response::json(['error' => $form], 404);
        }
    }

    public function gameStore(Request $request)
    {
        // $request = $_POST;
        try
        {
            $game = new Account();
            $game->name = $request->name;
            $game->title = $request->title;
            $game->balance = $request->balance;
            $game->status = $request->status;
            $game->game_url = $request->game_url;
            if ($request->hasFile('file'))
            {
                $img = $request->file('file');
                $name = time() . '.' . $img->extension();
                $img->move(base_path() . '/public/uploads/', $name);
                $game->image = $name;
            }
            // $game = Account::create([
            //     'name' => $request->name,
            //     'title' => $request->title,
            //     'balance' => $request->balance,
            //     'status' => $request->status,
            // ]);
            $game->save();
            return redirect()
                ->back()
                ->with('success', 'Game Created');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()
                ->back()
                ->with('error', $bug);
            // return Response::json(['error' => $bug],404);

        }
    }
    public function gameImageStore(Request $request)
    {
        // $request = $_POST;
        try
        {
            $game = Account::find($request->id);
            if ($request->hasFile('file'))
            {
                $img = $request->file('file');
                $name = time() . '.' . $img->extension();
                $img->move(base_path() . '/public/uploads/', $name);
                $game->image = $name;
            }
            $game->save();
            return redirect()
                ->back()
                ->with('success', 'Image Updated');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()
                ->back()
                ->with('error', $bug);
            // return Response::json(['error' => $bug],404);

        }
    }
      public function updateForm(Request $request){
        try
        {
            $form = Form::findOrFail($request->cid);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }
        if($request->type == 'number'){
            Form::where('id',$request->cid)->update([
                'number' => $request->note
            ]);
        }else{
            Form::where('id',$request->cid)->update([
                'email' => $request->note
            ]);

        }
        return Response::json('true');
    }
    public function getHistory($id){
        $year = date('Y');
        $month = date('m');
        if($month != 1){
            $month = $month - 1;
        }else{
            $month = 12;

        }
        if($month >10){
            $month = '0'.$month;
        }
        $filter_start = $year.'-'.$month.'-01';

        $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
        $history = History::with('account')
                            ->where('form_id',$id)
                            ->with('form')
                            ->whereHas('form')
                            ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                            ->with('created_by')
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();

        $final = [];
        $forms = [];
        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];

                if (!(isset($final[$b['form_id']])))
                {
                    $final[$b['form_id']] = [];
                }
                $final[$b['form_id']]['form_id'] = $b['form_id'];
                $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                $final[$b['form_id']]['number'] = $b['form']['number'];
                $final[$b['form_id']]['email'] = $b['form']['email'];
                $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];

                if (isset($final[$b['form_id']]['totals']))
                {
                    $totals['tip'] = $final[$b['form_id']]['totals']['tip'];
                    $totals['load'] = $final[$b['form_id']]['totals']['load'];
                    $totals['redeem'] = $final[$b['form_id']]['totals']['redeem'];
                    $totals['refer'] = $final[$b['form_id']]['totals']['refer'];
                    $totals['cashAppLoad'] = $final[$b['form_id']]['totals']['cashAppLoad'];
                }

                ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);
                $final[$b['form_id']]['totals'] = $totals;
            }
        }
        // dd($final);
        return $final;
    }
    public function sendMessage(Request $request){
        $type = $request->type;
        $message = $request->message;
        $limit_amount = $this->limit_amount;
        $year = date('Y');
        $month = date('m');
        if($month != 1){
            $month = $month - 1;
        }else{
            $month = 12;

        }
        // if($month >10){
        //     $month = '0'.$month;
        // }
        $filter_start = $year.'-'.$month.'-01';
        // $filter_end = Carbon::now();
        $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
        // Log::info('filter_start: '.json_encode($filter_start));
        // Log::info('filter_end: '.json_encode($filter_end));

        // $month = date('m');
        // if($month >10){
        //     $month = '0'.$month;
        // }
        // $filter_start = '2022-'.$month.'-01';
        // $filter_end = Carbon::now();

        // $history = History::with('account')->with('form')
        //                     ->whereHas('form')
        //                     ->whereBetween('created_at',[date($filter_start),date($filter_end)])
        //                     ->with('created_by')
        //                     ->orderBy('id', 'desc')
        //                     ->get()
        //                     ->toArray();
        
        $history = History::where('type', 'load')
                                // ->where('created_at', '>', Carbon::now()
                                // ->subDays(30))                                
                                ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                                ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id'])
                                ->groupBy('form_id')
                                ->with('form')
                                ->whereHas('form')
                                ->get()->toArray();
        // try
        // {
             
        foreach($history as $history){
            $form = [
                    'name' => $history['form']['full_name'],
                    'message' => $message,
                    'message-end' => '',
                    'limit_amount' => $limit_amount,
                    'load' => 100,
                    'type' => $type,
                    'subject' => '',
                    'token_id' => $histry['form']['token'],
                    'load-remaining' => 0
                ];
            Mail::to("mangaletamang65@gmail.com")->send(new spinnerBulkMail(json_encode($form)));
            Log::channel('spinnerBulk')->info("Mail sent successfully to ".$history['form']['email'].'for type above-'.$limit_amount);
        }
        return back()->with("success","Mail send success");
            // Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
            
        // }catch(\Exception $e)
        // {
        //     $bug = $e->getMessage();
        //     Log::channel('spinnerBulk')->info($bug);
        //     return back()->with("error","Mail send success");

        // }

        $final = [];
        $forms = [];
        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
                // $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                // if (!empty($form_game))
                // {
                    // $form = Form::where('id', $b['form_id'])->first();
                    // if (!empty($form))
                    // {
                        // $form_game->toArray();
                        // $form->toArray();
                        if (!(isset($final[$b['form_id']])))
                        {
                            $final[$b['form_id']] = [];
                        }
                        $final[$b['form_id']]['form_id'] = $b['form_id'];
                        $final[$b['form_id']]['spinner_key'] = $b['form']['token'];
                        $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                        $final[$b['form_id']]['number'] = $b['form']['number'];
                        $final[$b['form_id']]['email'] = $b['form']['email'];
                        $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];
                    // }

                    if (isset($final[$b['form_id']]['totals']))
                    {
                        $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        // $totals['tip'] = $final[$b['form_id']]['totals']['tip'];
                        // $totals['redeem'] = $final[$b['form_id']]['totals']['redeem'];
                        // $totals['refer'] = $final[$b['form_id']]['totals']['refer'];
                        // $totals['cashAppLoad'] = $final[$b['form_id']]['totals']['cashAppLoad'];
                    }
                    ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);

                    // ($b['type'] == 'tip') ? ($totals['tip'] = $totals['tip'] + $b['amount_loaded']) : ($totals['tip'] = $totals['tip']);
                    // ($b['type'] == 'redeem') ? ($totals['redeem'] = $totals['redeem'] + $b['amount_loaded']) : ($totals['redeem'] = $totals['redeem']);
                    // ($b['type'] == 'refer') ? ($totals['refer'] = $totals['refer'] + $b['amount_loaded']) : ($totals['refer'] = $totals['refer']);
                    // ($b['type'] == 'cashAppLoad') ? ($totals['cashAppLoad'] = $totals['cashAppLoad'] + $b['amount_loaded']) : ($totals['cashAppLoad'] = $totals['cashAppLoad']);
                    $final[$b['form_id']]['totals'] = $totals;                    
                // }
            }
        }
        // $key = key($final);
        // $second = array_slice($final, 1, 1, true);
        // $second_key = key($second);
        foreach ($final as $a => $b){
            // if($a == 1024 || $a == 455 || $a == 784|| $a == 679|| $a == 866|| $a == 11|| $a == 732|| $a == 69|| $a == 226|| $a == 327|| $a == 415|| $a == 391|| $a == 403|| $a == 935|| $a == 43|| $a == 269|| $a == 1003|| $a == 982|| $a == 668|| $a == 756|| $a == 863|| $a == 547){
                // if($b['email'] == ''){

                // }else{

                // }
                $input['email'] = $b['email'];
                $input['name'] = $b['full_name'];
                $input['load'] = $b['totals']['load'];

                $token_id = $b['spinner_key'];
                $form = [
                    'name' => $input['name'],
                    'message' => $message,
                    'message-end' => '',
                    'limit_amount' => $limit_amount,
                    'load' => $input['load'],
                    'type' => $type,
                    'subject' => '',
                    'token_id' => $token_id,
                    'load-remaining' => 0
                ];

                if($type == 'above-'.$limit_amount){
                
                    if($b['totals']['load']  >= $limit_amount){
                        $form['subject'] = 'Handy Games - Eligible For Spinner';
                        try
                            {
                                // Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                Mail::to("mangaletamang65@gmail.com")->send(new spinnerBulkMail(json_encode($form)));
                                Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type above-'.$limit_amount);
                            }
                        catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                Log::channel('spinnerBulk')->info($bug);
                            }
                    }
                }elseif($type == 'below-'.$limit_amount){
                    // Log::channel('spinnerBulk')->info('Reached to else if');
                    if($b['totals']['load']  <  $limit_amount){
                        $form['subject'] = 'Handy Games - Spinner';
                        // $form['message-end'] = 'Noor Games - Eligible For Spinner';              
                        $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                        try
                        {
                            Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                            Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type below-'.$limit_amount);
                        }
                        catch(\Exception $e)
                        {
                            $bug = $e->getMessage();
                            Log::channel('spinnerBulk')->info($bug);
                        }
                    }
                }else{
                    // Log::channel('spinnerBulk')->info('Reached to else');
                    $limit_1 = $limit_amount - 200;
                    $limit_2 = $limit_amount;
                    if($b['totals']['load']  >= $limit_1){
                        if($b['totals']['load']  < $limit_2){  
                            $form['subject'] = 'Handy Games - Almost Eligible For Spinner';                    
                            $form['load-remaining'] = $limit_amount - $b['totals']['load'];
                            
                            try
                            {
                                Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type between-'.$limit_amount);
                            }
                            catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                Log::channel('spinnerBulk')->info($bug);
                            }
                        }
                    }
                }
            // }
        }
    }
    public function sendMessageold(Request $request){
        // dd($request->all());
        $type = $request->type;
        $message = $request->message;
        $limit_amount = $this->limit_amount;
        if($request->id > 0){
            try
                {
                    $input2 = self::getHistory($request->id);
                    dd($input2);
                    foreach($input2 as $a => $input){
                    $form = Form::where('id', $input['form_id'])->first()->toArray();
                    $token_id = $form['token'];
                    $form = [
                        'name' => $input['full_name'],
                        'message' => $message,
                        'message-end' => '',
                        'limit_amount' => $limit_amount,
                        'load' => $input['totals']['load'],
                        'type' => $type,
                        'subject' => '',
                        'token_id' => $token_id,
                        'load-remaining' => 0
                    ];
                    if($type == 'above-'.$limit_amount){
                        if($form['load']  >= $limit_amount){
                             $form['subject'] = 'Noor Games - Eligible For Spinner';
                             try
                                 {
                                     Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                     Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' individual');
                                     return redirect()->back()->withInput()->with('success', 'Mail Sent');
                                 }
                             catch(\Exception $e)
                                 {
                                     $bug = $e->getMessage();
                                     Log::channel('spinnerBulk')->info($bug);
                                     return redirect()->back()->withInput()->with('error', $bug);
                                 }
                         }
                     }elseif($type == 'below-'.$limit_amount){
                         if($form['load']  <  $limit_amount){
                             $form['subject'] = 'Noor Games - Spinner';
                             // $form['message-end'] = 'Noor Games - Eligible For Spinner';
                             $form['load-remaining'] = $limit_amount - $form['load'];

                             try
                             {
                                 Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                 Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' individual');
                                 return redirect()->back()->withInput()->with('success', 'Mail Sent');
                             }
                             catch(\Exception $e)
                             {
                                 $bug = $e->getMessage();
                                 Log::channel('spinnerBulk')->info($bug);
                                 return redirect()->back()->withInput()->with('error', $bug);
                             }
                         }
                     }else{
                         $limit_1 = $limit_amount - 50;
                         $limit_2 = $limit_amount;
                         if($form['load']  >= $limit_1){
                             if($form['load']  < $limit_2){
                                 $form['subject'] = 'Noor Games - Almost Eligible For Spinner';
                                 $form['load-remaining'] = $limit_amount - $form['load'];

                                 try
                                 {
                                     Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                     Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' individual');
                                     return redirect()->back()->withInput()->with('success', 'Mail Sent');
                                 }
                                 catch(\Exception $e)
                                 {
                                     $bug = $e->getMessage();
                                     Log::channel('spinnerBulk')->info($bug);
                                     return redirect()->back()->withInput()->with('error', $bug);
                                 }
                             }
                         }
                     }

                    }

                    // Mail::to($form['email'])->send(new spinnerBulkMail(json_encode($form)));
                    // Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email']);
                }
            catch(\Exception $e)
                {
                    $bug = $e->getMessage();
                    Log::channel('spinnerBulk')->info($bug);
                    return redirect()->back()->withInput()->with('error', $bug);
                }
        }

        $limit_amount = $this->limit_amount;
        $details = [
            'subject' => 'Weekly Notification',
            'type' => $type,
            'message'=> $message,
            'limit_amount' => $limit_amount
        ];

        try
        {
            $job = (new \App\Jobs\SpinnerBulkMessage($details))
                ->delay(
                    now()
                    ->addSeconds(2)
                );
            dispatch($job);
            return redirect()->back()->withInput()->with('success', 'Mail Sent');
            // \Artisan::call('queue:listen');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()->back()->withInput()->with('error',$bug);
        }
    }
     public function sendSMS(Request $request){
        // Yayyy ';
        $type = $request->type;
        $message = $request->message;
        $limit_amount = $this->limit_amount;

        if($request->id > 0){
            try
                {
                    $input2 = self::getHistory($request->id);

                    foreach($input2 as $a => $input){

                        $token_id = Str::random(32);
                        $form = Form::where('id', $input['form_id'])->update(['balance' => 1, 'token' => $token_id]);
                        $token = Config('app.url').'spinner/form/'.$token_id;
                        $form = [
                            'name' => $input['full_name'],
                            'message' => $message,
                            'number' => $input['number'],
                            'message-end' => '',
                            'limit_amount' => $limit_amount,
                            'load' => $input['totals']['load'],
                            'type' => $type,
                            'subject' => '',
                            'token_id' => $token_id,
                            'load-remaining' => 0
                        ];
                    $sendtext = 'Hello '.$form['name'].','.$form['message'].' ';

                    $settings = GeneralSetting::where('id',1)->first()->toArray();
                    $key = (string) $settings['api_key'];
                    $secret = (string) $settings['api_secret'];

                    $basic  = new \Vonage\Client\Credentials\Basic($key, $secret);
                    $client = new \Vonage\Client($basic);

                    if($type == 'above-'.$limit_amount){
                        if($form['load']  >= $limit_amount){
                             $form['subject'] = 'Noor Games - Eligible For Spinner';
                             $sendtext .= 'You have loaded a total of '.$form['load'].'Your spinner link is '.$token;
                         }
                     }elseif($type == 'below-'.$limit_amount){
                         if($form['load']  <  $limit_amount){
                             $form['subject'] = 'Noor Games - Spinner';
                             // $form['message-end'] = 'Noor Games - Eligible For Spinner';
                             $form['load-remaining'] = $limit_amount - $form['load'];
                             $sendtext .= 'Only '.$form['load-remaining'].' left to be eligible for the spinner.';
                         }
                     }else{
                         $limit_1 = $limit_amount - 50;
                         $limit_2 = $limit_amount;
                         if($form['load']  >= $limit_1){
                             if($form['load']  < $limit_2){
                                 $form['subject'] = 'Noor Games - Almost Eligible For Spinner';
                                 $form['load-remaining'] = $limit_amount - $form['load'];
                                 $sendtext .= 'Only '.$form['load-remaining'].' left to be eligible for the spinner.';
                             }
                         }
                     }

                    }
                    try
                    {
                        $message = $client->message()->send([
                        'to' => $form['number'],
                        'from' => '18337222376',
                        'text' => $sendtext
                        ]);
                        Log::channel('spinnerBulk')->info("SMS sent successfully to ".$input['number']);
                        return redirect()->back()->withInput()->with('success', 'SMS Sent');
                    }
                    catch(\Exception $e)
                    {
                        $bug = $e->getMessage();
                        Log::channel('spinnerBulk')->info($bug);
                        return redirect()->back()->withInput()->with('error', $bug);
                    }
                    return redirect()->back()->withInput()->with('success', 'SMS Sent');
                }
            catch(\Exception $e)
                {
                    $bug = $e->getMessage();
                    Log::channel('spinnerBulk')->info($bug);
                    return redirect()->back()->withInput()->with('error', $bug);
                }
        }
    }
      public function createPDF() {
        $limit_amount = $this->limit_amount;
            $year = date('Y');
            // $month = date('m');
            $month = 5;
                if($month != 1){
                    $month = $month - 1;
                }else{
                    $month = 12;
                    $year = $year - 1;
                }
            if($month  < 10){
                $month = '0'.$month;
            }


            $filter_start = $year.'-'.$month.'-01';
            $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
            $history = History::with('form')
                        ->whereHas('form')
                        ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                        ->orderBy('id', 'desc')
                        ->get()
                        ->toArray();

            $final = [];
            $forms = [];
            if (!empty($history))
            {
                foreach ($history as $a => $b)
                {
                    $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
                            $token_id = $b['form']['token'];

                            $form_update = Form::find($b['form_id']);
                            if(empty($token_id)){
                                $token_id = Str::random(32);
                                $form_update->token = $token_id;
                            }
                            $form_update->save();

                            if (!(isset($final[$b['form_id']])))
                            {
                                $final[$b['form_id']] = [];
                            }
                            $final[$b['form_id']]['form_id'] = $b['form_id'];
                            $final[$b['form_id']]['spinner_key'] = $token_id;
                            $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                            $final[$b['form_id']]['number'] = $b['form']['number'];
                            $final[$b['form_id']]['email'] = $b['form']['email'];
                            $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];

                        if (isset($final[$b['form_id']]['totals']))
                        {
                            $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        }

                        ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                        $final[$b['form_id']]['totals'] = $totals;
                }
            }
            $limit = 0;
            $final_2 = [];
            if(!empty($final)){
                // $key = key($final);
                // $second = array_slice($final, 1, 1, true);
                // $second_key = key($second);
                $count = 0;
                foreach ($final as $a => $b){
                    $count++;
                    // if($a == $key || $a == $second_key){
                            if($b['totals']['load']  >= $limit_amount){
                                // if($count > 101){

                                array_push($final_2,$b);
                                // }
                            }
                            $limit_1 = $this->limit_amount - 200;
                            $limit_2 = $this->limit_amount;
                            if($b['totals']['load']  >= $limit_1){
                                if($b['totals']['load']  < $limit_2){
                                    array_push($final_2,$b);
                                }
                            }
                    // }
                }
            }
            // dd($forms);
            $final = $final_2;

            $limit_amount = $this->limit_amount;
    $pdf = Pdf::loadView('gamersgamepdf',compact('final'));
    Storage::put('pdf/pdf1.pdf', $pdf->output());
    $data["email"] = "mangaletamang65@gmail.com";
        $data["title"] = "From ItSolutionStuff.com";
        $data["body"] = "This is Demo";
 
        $files = [
            public_path('pdf/pdf1.pdf'),
        ];
  
        Mail::send('gamersgamemail', $data, function($message)use($data, $files) {
            $message->to($data["email"], $data["email"])
                    ->subject($data["title"]);
 
            foreach ($files as $file){
                $message->attach($file);
            }
            
        });
 
        dd('Mail sent successfully');
    return $pdf->stream();
      }
    public function gamerGames($id)
    {

        // dd($this->limit_amount);
        // $year = date('Y');
        // $month = date('m');
        // $month_prev = $month - 2;

        // if($month  < 10){
        //     $month = '0'.$month;
        // }


        // $filter_start = date("Y-m-t", strtotime($year.'-'.$month_prev.'-01'));
        // $history = History::where('created_at', '>=', date(($year.'-'.$month_prev.'-30')))->get();
        // $history = History::where('created_at','<',date($filter_start))->get();
        // dd($history);
        // ini_set('max_execution_time', '300');
        $limit_amount = $this->limit_amount;
        // dd($id);
        $type = $id;
        // $limit_amount = 3000;
        $prev = isset($_GET['month'])?$_GET['month']:'';
        // dd($prev);
        if($type == 'all'){
            $year = date('Y');
            $month = date('m');
            $month_prev = $month - 1;

            if($month  < 10){
                $month = '0'.$month;
            }
            if($month_prev  < 10){
                $month_prev = '0'.$month_prev;
            }


            $filter_start = $year.'-'.$month_prev.'-02';
            $filter_end = Carbon::now();

            // $history = History::with('form')
            //     ->whereHas('form')
            //     ->whereBetween('created_at',[date($filter_start),date($filter_end)])
            //     ->orderBy('id', 'desc')
            //     ->get()
            //     ->toArray();

            $history = History::where('type', 'load')
                                // ->where('created_at', '>', Carbon::now()
                                // ->subDays(30))
                                // ->orderBy('id','desc')
                                // ->whereDate('created_at', '>=', date(($filter_start)))
                                ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id',])
                                ->groupBy('form_id')
                                ->with('form')
                                ->whereHas('form')
                                ->get()->toArray();
            // $history = History::with('form')
            //                     ->whereHas('form')
            //                     ->where('type','load')
            //                     ->whereDate('created_at', '>=', date(($filter_start)))->get();
            // $history = FormBalance::with('account')->with('form')
            // ->whereHas('form')
            // ->with('created_by')
            // ->whereBetween('created_at',[date($filter_start),date($filter_end)])
            // ->orderBy('id', 'desc')
            // ->get()
            // ->toArray();
            // dd($history);
            $final = [];
            $forms = [];

            // $data = [
            //     ['SN', 'Date', 'FB Name','Game','Game ID','Amount','Type','Creator']
            // ];
            if (!empty($history))
            {
                foreach ($history as $a => $b)
                {
                    $totals = ['load' => 0];


                    $form = Form::where('id', $b['form_id'])->first();
                    if (!empty($form))
                    {
                        $form->toArray();
                        if (!(isset($final[$b['form_id']])))
                        {
                            $final[$b['form_id']] = [];
                        }
                        $final[$b['form_id']]['spinner_key'] = $form['token'];
                        $final[$b['form_id']]['form_id'] = $b['form_id'];
                        $final[$b['form_id']]['full_name'] = $form['full_name'];
                        $final[$b['form_id']]['number'] = $form['number'];
                        $final[$b['form_id']]['email'] = $form['email'];
                        $final[$b['form_id']]['facebook_name'] = $form['facebook_name'];
                    }
                    // if (isset($final[$b['form_id']]['totals']))
                    // {
                    //     $totals['load'] = $final[$b['form_id']]['totals']['load'];
                    // }
                    // $totals['load'] = $totals['totals'];
                    // $totals['load'] = $totals['load'] + $b['amount_loaded'];
                    $final[$b['form_id']]['totals']['load'] = $b['total'];
                }
            }

            $forms = $final;
            // echo "<pre>";
            // print_r($forms);
            // die;
            $limit_amount = $this->limit_amount;
            $filter_start = 'all';
            $filter_end = 'all';
        }
        else{
            $year = date('Y');
            $month = date('m');
            if(!empty($prev) && $prev == 'previous'){
                if($month != 1){
                    $month = $month - 1;
                }else{
                    $month = 12;
                    $year = $year - 1;
                }

            }
            if($month  < 10){
                $month = '0'.$month;
            }


            $filter_start = $year.'-'.$month.'-01';
            if(!empty($prev) && $prev == 'previous'){
                $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
            }
            else{
                $filter_end = Carbon::now();
            }

            // $history = History::where('type', 'load')
            //                     // ->where('created_at', '>', Carbon::now()
            //                     // ->subDays(30))
            //                     ->orderBy('id','desc')
            //                     // ->whereDate('created_at', '>=', date(($filter_start)))
            //                     ->select([DB::raw("SUM(amount_loaded) as total") , 'form_id as form_id',])
            //                     ->groupBy('form_id')
            //                     ->with('form')
            //                     ->whereHas('form')
            //                     ->get()->toArray();

            $history = History::with('form')
                        ->whereHas('form')
                        ->whereBetween('created_at',[$filter_start,$filter_end])
                        ->orderBy('id', 'desc')
                        ->get()
                        ->toArray();

            $final = [];
            $forms = [];

            // $data = [
            //     ['SN', 'Date', 'FB Name','Game','Game ID','Amount','Type','Creator']
            // ];
            // dd($history);
            if (!empty($history))
            {
                foreach ($history as $a => $b)
                {
                    $totals = ['tip' => 0, 'load' => 0, 'redeem' => 0, 'refer' => 0, 'cashAppLoad' => 0];
                            $token_id = $b['form']['token'];

                            $form_update = Form::find($b['form_id']);
                            if(empty($token_id)){
                                $token_id = Str::random(32);
                                $form_update->token = $token_id;
                            }
                            $form_update->save();

                            if (!(isset($final[$b['form_id']])))
                            {
                                $final[$b['form_id']] = [];
                            }
                            $final[$b['form_id']]['form_id'] = $b['form_id'];
                            $final[$b['form_id']]['spinner_key'] = $token_id;
                            $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                            $final[$b['form_id']]['number'] = $b['form']['number'];
                            $final[$b['form_id']]['email'] = $b['form']['email'];
                            $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];

                        if (isset($final[$b['form_id']]['totals']))
                        {
                            $totals['load'] = $final[$b['form_id']]['totals']['load'];
                        }

                        ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);
                        $final[$b['form_id']]['totals'] = $totals;
                }
            }
            $limit = 0;
            $final_2 = [];
            if(!empty($final)){
                // $key = key($final);
                // $second = array_slice($final, 1, 1, true);
                // $second_key = key($second);
                $count = 0;
                foreach ($final as $a => $b){
                    $count++;
                    // if($a == $key || $a == $second_key){
                        if($type == 'above-'.$limit_amount){

                            if($b['totals']['load']  >= $limit_amount){
                                // if($count > 101){

                                array_push($final_2,$b);
                                // }
                            }
                        }elseif($type == 'below-'.$limit_amount){
                            if($b['totals']['load']  <  $limit_amount){
                                array_push($final_2,$b);
                            }
                        }else{
                            $limit_1 = $this->limit_amount - 200;
                            $limit_2 = $this->limit_amount;
                            if($b['totals']['load']  >= $limit_1){
                                if($b['totals']['load']  < $limit_2){
                                    array_push($final_2,$b);
                                }
                            }
                        }
                    // }
                }
            }
            // dd($forms);
            $forms = $final_2;

            $limit_amount = $this->limit_amount;

        }
        // dd($forms);
        return view('newLayout.gamers-games', compact('forms','limit_amount','filter_start','filter_end','type'));
    }
    public function settings(){
        $settings = GeneralSetting::first()->toArray();
        return view('newLayout.settings',compact('settings'));
    }
   public function settingStore(Request $request){
        try
        {
            if(Route::is('settingStore')){
                //dd($request->all());
                $between_limit_text = $request->only('between_limit_text_1','between_limit_text_2','between_limit_text_3','between_limit_text_4');
                $above_limit_text = $request->only('above_limit_text_1','above_limit_text_2','above_limit_text_3','above_limit_text_4');
                $below_limit_text = $request->only('below_limit_text_1','below_limit_text_2','below_limit_text_3','below_limit_text_4');
                $gamergames = $request->only('gameregames_date','gameregames_time');
                $setting = GeneralSetting::first();
                $bulk_mail_details = json_decode($setting->bulk_mail, true);
                $bulk_mail_image = $bulk_mail_details['image'];
                $background_image = $bulk_mail_details['background_image'];
                if($request->hasFile('bulk_mail_image')){
                    $image = $request->file('bulk_mail_image');
                    $name = time().'.'.$image->extension();
                    $image->move(public_path('uploads/'),$name);
                    $bulk_mail_image = $name;
                }
                if($request->hasFile('background_image')){
                    $image = $request->file('background_image');
                    $background_name = time().'.'.$image->extension();
                    $image->move(public_path('uploads/'),$background_name);
                    $background_image = $background_name;
                }
                
                $bulk_mail = [
                    'subject'=>$request->bulk_mail_subject,
                    'message'=>$request->bulk_mail_message,
                    'image'=>$bulk_mail_image,
                    'background_image'=>$background_image,
                    'coopyright_text'=>$request->copyright_text,
                    'app_name'=>$request->app_name,
                    'enable_logo'=>$request->enable_logo ? '1' : '0',
                    ];
                
                $settings = GeneralSetting::first()->update([
                    'bonus_report_emails' => ($request->bonus_report_emails[0] != null)?$request->bonus_report_emails[0]:null,
                    'new_register_mail' => ($request->new_register_mail[0] != null)?$request->new_register_mail[0]:null,
                    'emails' => ($request->emails[0] != null)?$request->emails[0]:null,
                    'limit_amount' => $request->limit_amount,
                    'spinner_message_monthly' => $request->spinner_message_monthly,
                    'spinner_message' => $request->spinner_message,
                    'above_limit_text' => json_encode($above_limit_text),
                    'between_limit_text' => json_encode($between_limit_text),
                    'below_limit_text' => json_encode($below_limit_text),
                    'captcha' => $request->captcha,
                    'captcha_type' => $request->captcha_type,
                    'api_key' => $request->api_key,
                    'api_secret' => $request->api_secret,
                    'theme' => $request->theme,
                    'registration_email' => $request->registration_email,
                    'registration_sms' => $request->registration_sms,
                    'mail_text' => $request->mail_text,
                    'spinner_date' => $request->spinner_date,
                    'spinner_time' => $request->spinner_time,
                    'sms_text' => $request->sms_text,
                    'spinner_winner_day' => $request->spinner_winner_day,
                    'spinner_time_cron' => $request->spinner_time_cron,
                    'inactive_mail_type' => $request->inactive_mail_type,
                    'inactive_mail_time' => $request->inactive_mail_time,
                    'inactive_mail_day' => $request->inactive_mail_day,
                    'inactive_mail_message' => $request->inactive_mail_message,
                    'gameregames' => json_encode($gamergames),
                    'bulk_mail' => json_encode($bulk_mail),
                    'same_device' => (int)$request->same_device,
                    

                ]);
                $settings = GeneralSetting::first();
                // $path = asset('public/images/'.$settings->theme.'/logo.jpg');
                if ($request->hasFile('file'))
                {
                    $img = $request->file('file');
                    $name = time() . '.' . $img->extension();
                    $img->move(base_path() . '/images/'.$request->theme.'/', $name);
                    $theme = Theme::where('name',$request->theme)->first();
                    $theme->update(['logo'=> $name]);
                }
            }elseif(Route::is('email_id_counter')){
                GeneralSetting::first()->update([
                    'email_id_counter'=>$request->email_id_counter,
                    'page_link' => $request->page_link,
                ]);
            }


            // dd($img);
            // $game->image = $name;
            // $settings = GeneralSetting::first()->toArray();
            return redirect()->back()->withInput()->with('success', 'Settings Updated');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()->back()->withInput()->with('error', $bug);
        }
    }
    public function userDetails($id){
        // dd('hi');
        $form_id = $id;
        $form_games = FormGame::where('form_id',$form_id)->with('account')->get()->toArray();
        $form = Form::where('id',$form_id)->first()->toArray();
        // dd($form_games);
        return view('newLayout.userDetails', compact('form_games','form'));

    }
    
    // public function userDetailsApi(Request $request, $id)
    // {
    //     $form = Form::where('messenger_id',$id)->first();
    
    //     if (!$form) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'User not found',
    //         ], 404);
    //     }
    //     $game_ids = [];
    //     $form_games = FormGame::where('form_id', $form->id)->get();
    //     foreach($form_games as $key=>$item){
    //         $game_ids[] = $item->geme_id;
    //     }
    //     if ($form_games->isEmpty()) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'No games found for this user',
    //         ], 404);
    //     }
    
    //     // Generate JWT Token for the user (Form model)
    //     $token = JWTAuth::fromUser($form);
    
    //     return response()->json([
    //         'success' => true,
    //         'message' => 'User details fetched successfully',
    //         'data' => [
    //             'user_details' => [
    //                     'full_name' => $form->full_name,
    //                     'email' => $form->email,
    //                     'facebook_name' => $form->facebook_name,
    //                     'messenger_id' => $form->messenger_id,
    //                 ],
    //             'form_games' => $game_ids,
    //             'token' => $token,
    //         ]
    //     ], 200);
    // }
    public function userDetailsApi(Request $request, $id)
    {
        try {
            $form = Form::where('messenger_id', $id)->first();
    
            if (!$form) {
                return response()->json([
                    'success' => false,
                    'message' => 'User not found',
                ], 404);
            }
    
            // Fetch game details
            $game_details = [];
            $formgames = FormGame::where('form_id', $form->id)
                                ->with('account')
                                ->get(); // Fetch as a collection
    
            if ($formgames->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No games found for this user',
                ], 404);
            }
    
            foreach ($formgames as $game) {
                $game_details[] = [
                    "game" => $game->account->name ?? 'Unknown', // Prevent errors if account is null
                    'game_id' => $game->game_id,
                ];
            }
    
            // Generate JWT Token
            $token = JWTAuth::fromUser($form);
    
            return response()->json([
                'success' => true,
                'message' => 'User details fetched successfully',
                'data' => [
                    'user_details' => [
                        'full_name' => $form->full_name,
                        'email' => $form->email,
                        'facebook_name' => $form->facebook_name,
                        'messenger_id' => $form->messenger_id,
                    ],
                    'game_details' => $game_details,
                    'token' => $token,
                ]
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred',
                'error' => $e->getMessage(),
            ], 500);
        }
    }


    public function messengerId(Request $request){
        $id = $request->form_id;
        $form = Form::find($id);
        $form->messenger_id = $request->messenger_id;
        $form->save();
        return response()->json([
        'success' => true,
        'message' => 'Messenger ID updated successfully!',
    ]);
    }
    public function updateGameId(Request $request){
        $form_id = $request->cid;
        $accountId = $request->accountId;
        $gameId = $request->gameId;

        try
        {
            $form_games = FormGame::where(['form_id' => $form_id,'account_id' => $accountId])->update(['game_id' => $gameId]);
            return Response::json(true);
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return Response::json(['error' => $bug], 404);
        }
    }
    public function gameids(Request $request){
        $form_id = $request->userId;
        $form_games = FormGame::where('form_id',$form_id)->with('account')->get()->toArray();
        return Response::json($form_games);

    }
    public function gameData(){
        $year = isset($_GET['year']) ? $_GET['year'] : '';
        $month = isset($_GET['month']) ? $_GET['month'] : '';
        $day = isset($_GET['day']) ? $_GET['day'] : '';

        if (empty($year))
        {
            $year = date('Y');
        }
        if (empty($month))
        {
            $month = date('m');
        }
        if (empty($day))
        {
            // echo 's';
        $history = History::whereDate('created_at', '>=', date($year.'-'.$month.'-01'))
                            ->whereDate('created_at', '<=', date($year.'-'.$month.'-31'))
                            ->count();
        }else{
            // echo 'no';
            $history = History::whereDate('created_at', '>=', date($year . '-' . $month . '-'.$day))
            ->whereDate('created_at', '<=', date($year . '-' . $month . '-'.$day))
            ->count();
        }
        // dd($month,$history,date($year.'-'.$month.'-01'),date($year.'-'.$month.'-32'));

        $grouped = [];
        if (($history > 0)){
            if (empty($day))
            {
                $history = History::whereHas('form')
                                ->whereDate('created_at', '>=', date($year . '-' . $month . '-01'))
                                ->whereDate('created_at', '<=', date($year . '-' . $month . '-31'))
                                ->orderBy('created_at', 'asc')
                                ->with('account')
                                ->whereHas('account')
                                    ->get()
                                    ->toArray();
            }else{
                $history = History::whereHas('form')
                                ->whereDate('created_at', '>=', date($year . '-' . $month . '-'.$day))
                                ->whereDate('created_at', '<=', date($year . '-' . $month . '-'.$day))
                                ->orderBy('created_at', 'asc')
                                ->with('account')
                                ->whereHas('account')
                                    ->get()
                                    ->toArray();
            }
            // dd($history);
            $totals = [
                'tip' => 0,
                'load' => 0,
                'redeem' => 0,
                'refer' => 0,
                'cashAppLoad' => 0,
            ];
            foreach ($history as $a => $b) {
                $created_at = explode('-', date('Y-m-d', strtotime($b['created_at'])));
                if (!(isset($grouped[$created_at[2]][$b['account_id']])))
                {
                    $grouped[$created_at[2]][$b['account_id']] =
                    [
                        'game_id' => $b['account']['id'],
                        'game_name' => $b['account']['name'],
                        'game_title' => $b['account']['title'],
                        'game_balance' => $b['account']['balance'],
                        'histories' => [],
                        'totals' => $totals,
                        'total_transactions' => 0
                    ];
                }

                ($b['type'] == 'tip') ? ($grouped[$created_at[2]][$b['account_id']]['totals']['tip'] = $grouped[$created_at[2]][$b['account_id']]['totals']['tip'] + $b['amount_loaded']) : ($grouped[$created_at[2]][$b['account_id']]['totals']['tip'] = $grouped[$created_at[2]][$b['account_id']]['totals']['tip']);
                ($b['type'] == 'load') ? ($grouped[$created_at[2]][$b['account_id']]['totals']['load'] = $grouped[$created_at[2]][$b['account_id']]['totals']['load'] + $b['amount_loaded']) : ($grouped[$created_at[2]][$b['account_id']]['totals']['load'] = $grouped[$created_at[2]][$b['account_id']]['totals']['load']);
                ($b['type'] == 'redeem') ? ($grouped[$created_at[2]][$b['account_id']]['totals']['redeem'] = $grouped[$created_at[2]][$b['account_id']]['totals']['redeem'] + $b['amount_loaded']) : ($grouped[$created_at[2]][$b['account_id']]['totals']['redeem'] = $grouped[$created_at[2]][$b['account_id']]['totals']['redeem']);
                ($b['type'] == 'refer') ? ($grouped[$created_at[2]][$b['account_id']]['totals']['refer'] = $grouped[$created_at[2]][$b['account_id']]['totals']['refer'] + $b['amount_loaded']) : ($grouped[$created_at[2]][$b['account_id']]['totals']['refer'] = $grouped[$created_at[2]][$b['account_id']]['totals']['refer']);
                ($b['type'] == 'cashAppLoad') ? ($grouped[$created_at[2]][$b['account_id']]['totals']['cashAppLoad'] = $grouped[$created_at[2]][$b['account_id']]['totals']['cashAppLoad'] + $b['amount_loaded']) : ($grouped[$created_at[2]][$b['account_id']]['totals']['cashAppLoad'] = $grouped[$created_at[2]][$b['account_id']]['totals']['cashAppLoad']);

                $grouped[$created_at[2]][$b['account_id']]['total_transactions'] = $grouped[$created_at[2]][$b['account_id']]['total_transactions'] + 1;
                array_push($grouped[$created_at[2]][$b['account_id']]['histories'], $b);
            }
        }else{

        }
        $all_months = ['1' => 'January', '2' => 'February', '3' => 'March', '4' => 'April', '5' => 'May', '6' => 'June', '7' => 'July', '8' => 'August', '9' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'];
    //  dd($month);
        return view('newLayout.gameData', compact('grouped', 'month', 'year','day','all_months'));
            //  dd($grouped);
    }

      public function addHistory(Request $request){
        try
        {
            if(isset($request->yesterday) && $request->yesterday == 1){
                $history = History::create([
                    'created_at' => Carbon::yesterday(),
                    'form_id' => $request->id,
                    'account_id' => $request->account,
                    'amount_loaded' => $request->amount_loaded,
                    'type' => $request->type,
                    'created_by' => Auth::user()->id
                ]);
            }else{
                $history = History::create([
                    'created_at' => $request->date,
                    'form_id' => $request->id,
                    'account_id' => $request->account,
                    'amount_loaded' => $request->amount_loaded,
                    'type' => $request->type,
                    'created_by' => Auth::user()->id
                ]);
            }
            return redirect()->back()->withInput()->with('success', 'History Added');
        }
        catch(\Exception $e)
        {
            $bug = $e->getMessage();
            return redirect()->back()->withInput()->with('error', $bug);
        }
    }
    public function sendMailAboveLimit(){
        $settings = GeneralSetting::first()->toArray();
        $limit_amount = $settings['limit_amount'];
        $message = $settings['above_limit_text'];
        $type = 'above-'.$limit_amount;


        $year = date('Y');
        $month = date('m');

        if($month != 1){
            $month = $month - 1;
        }else{
            $month = 12;
        }

        $filter_start = $year.'-'.$month.'-01';
        $filter_end = date("Y-m-t", strtotime($year.'-'.$month.'-01'));
        // Log::info('filter_start: '.json_encode($filter_start));
        //dd($filter_end, ' ', $filter_start);
        // $history = History::with('form')->get();
        $history = History::with('form')
                            ->whereHas('form')
                            ->whereBetween('created_at',[date($filter_start),date($filter_end)])
                            ->orderBy('id', 'desc')
                            ->get()
                            ->toArray();
        $spinner_winner = SpinnerWinner::whereBetween('created_at',[date($filter_start),date($filter_end)]);
        $final = [];
        $forms = [];

        if (!empty($history))
        {
            foreach ($history as $a => $b)
            {
                $totals = ['load' => 0];

                if (!(isset($final[$b['form_id']])))
                {
                    $final[$b['form_id']] = [];
                }
                $final[$b['form_id']]['form_id'] = $b['form_id'];
                $final[$b['form_id']]['spinner_key'] = $b['form']['token'];
                $final[$b['form_id']]['full_name'] = $b['form']['full_name'];
                $final[$b['form_id']]['number'] = $b['form']['number'];
                $final[$b['form_id']]['email'] = $b['form']['email'];
                $final[$b['form_id']]['facebook_name'] = $b['form']['facebook_name'];

                if (isset($final[$b['form_id']]['totals']))
                {
                    $totals['load'] = $final[$b['form_id']]['totals']['load'];
                }
                ($b['type'] == 'load') ? ($totals['load'] = $totals['load'] + $b['amount_loaded']) : ($totals['load'] = $totals['load']);

                $final[$b['form_id']]['totals'] = $totals;

            }
        }
        // echo '<pre>';
        // print_r($final);
        // echo '</pre>';
        // $array = ['prasundahal@gmail.com','bpc0421@gmail.com','Kevgullo1@yahoo.com','christopherbowling43@gmail.com','parksvon30@gmail.com1','lonniecarney42@gmail.com','william23smith@gmail.com','ufoundarida@gmail.com','done4now79@gmail.com','Maeio.Estrada714@Yaboo.com','83hallendorris@gmail.com','leslie.capistran14@gmail.com','candy316kisses@gmail.com','melissafellhauer1@gmail.com','kwgrimet@yahoo.com','manwellc@outlook.com','angelalundy17@gmail.com','tlkaestner@gmail.com','toryphillips93@icloud.com','trinaneedshelp@gmail.com','jwilliams5858@yahoo.comj','iansoto911@gmail.com','robertweiser35@gmail.com','paul.28martin@gmail.com','e.baptiste1985@gmail.com','turnerchris6900@gmail.com','geromettalisa84@gmail.com','larryhirsch.651@gmail.com','ok2open2@icloud.com','marcushawkins56@gmail.com','df482169@gmail.com','poochiebabym@gmail.com','skylitdrop@gmail.com','elizabethcaffee@gmail.com','pricecynthia628@gmail.com','angusnelexia2020@gmail.com','alicia0798@yahoo.com','jivey985@gmail.com','joejoe199613@gmail.com','snaxx83@gmail.com','dion1967m@gmail.com','larryminx70@gmail.com','misskittycat007@gmail.com','angiesmims@yahoo.com','bxsullivan@outlook.com','smiller_28@yahoo.com','tylar352@gmail.com','justabiggun@gmail.com','2811skrappy@gmail.com','cox.terek2.0@gmail.com','desesca10@yahoo.com','lowkeylisag@gmail.com','dede.hulsey@yahoo.com','carol55evans@gmail.com','Reynoldsfrancisca117@gmail.com','lmb6971@gmail.coml','danielweikel5@gmail.com','ladyboss8338@gmail.com','madduxdanielle1@gmail.com','714slugger34@gmail.com','freetobemesince0823@gmail.com','therealeezlup@gmail.com','richiesativa21@gmail.com','liza_waugh@yahoo.com','tamaritkatelynn@gmail.com','thistimewillbethasttime@gmail.com','kmshaven1111@gmail.com','ogcastillo213@gmail.com','emelf11268@gmail.com','rogersallen332@gmail.com','abmarchetti93@gmail.com','wgill440376@gmail.com','crissynuernberg@gmail.com','francesrankin3@gmail.com','savagedriver70@gmail.com','liza.glane@gmail.com','yulanda_abner@yahoo.com'];
        foreach ($final as $a => $b){

            if($a==4){
                $input['email'] = $b['email'];
                $input['name'] = $b['full_name'];
                $input['load'] = $b['totals']['load'];

                $token_id = $b['spinner_key'];
                if($token_id == ''){
                    $token_id = Str::random(32);
                    $form = Form::where('id',$b['form_id'])->update([
                        'token' => $token_id
                    ]);
                }
                $form = [
                    'name' => $input['name'],
                    'message' => $message,
                    'message-end' => '',
                    'limit_amount' => $limit_amount,
                    'load' => $input['load'],
                    'type' => $type,
                    'subject' => '',
                    'token_id' => $token_id,
                    'load-remaining' => 0
                ];

                if($type == 'above-'.$limit_amount){

                    if($b['totals']['load']  >= $limit_amount){
                        $form['subject'] = 'Noor Games - Eligible For Spinner';
                        try
                            {
                                // if(!(in_array($input['email'],$array))){
                                    Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                                    Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].' for type above-'.$limit_amount);

                                // }
                            }
                        catch(\Exception $e)
                            {
                                $bug = $e->getMessage();
                                Log::channel('spinnerBulk')->info($bug);
                            }
                    }
                }elseif($type == 'below-'.$limit_amount){
                    // if($b['totals']['load']  <  $limit_amount){
                    //     $form['subject'] = 'Noor Games - Spinner';
                    //     $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                    //     try
                    //     {
                    //         Mail::to($input['email'])->send(new spinnerBulkMail(json_encode($form)));
                    //         Log::channel('spinnerBulk')->info("Mail sent successfully to ".$input['email'].'for type below-'.$limit_amount);
                    //     }
                    //     catch(\Exception $e)
                    //     {
                    //         $bug = $e->getMessage();
                    //         dd($bug);
                    //         Log::channel('spinnerBulk')->info($bug);
                    //     }
                    // }
                }else{
                    // echo '<pre>';
                    // print_r($b['email']);
                    // echo '</pre>';
                    // $limit_1 = $limit_amount - 200;
                    // $limit_2 = $limit_amount;
                    // if($b['totals']['load']  >= $limit_1){
                    //     if($b['totals']['load']  < $limit_2){
                    //         $form['subject'] = 'Noor Games - Almost Eligible For Spinner';
                    //         $form['load-remaining'] = $limit_amount - $b['totals']['load'];

                    //         try
                    //         {
                    //             Mail::to($b['email'])->send(new spinnerBulkMail(json_encode($form)));
                    //             Log::channel('spinnerBulk')->info("Mail sent successfully to ".$b['email'].' for type between-'.$limit_amount);
                    //         }
                    //         catch(\Exception $e)
                    //         {
                    //             $bug = $e->getMessage();
                    //             Log::channel('spinnerBulk')->info($bug);
                    //         }
                    //     }
                    // }
                }
            }


        }
        // $form = [
        //     'name' => 'Prasun Dahal',
        //     'message' => 'Custom Text',
        //     'message-end' => '',
        //     'limit_amount' => $limit_amount,
        //     'load' => 800,
        //     'type' => $type,
        //     'subject' => '',
        //     'token_id' => 'asdfasdfasdfa',
        //     'load-remaining' => 0
        // ];
        // Mail::to('prasundahal@gmail.com')->send(new spinnerBulkMail(json_encode($form)));

        if($spinner_winner->count() <= 0){
            // $history->delete();

            $shuffle = array_rand($final);
            $f1 = Form::where('id',$final[$shuffle]['form_id'])->first();
            $winner = SpinnerWinner::create([
                'form_id' => $final[$shuffle]['form_id'],
                'full_name' => $final[$shuffle]['full_name'],
                'created_at' => $year.'-'.$month.'-15'
            ]);
        }
    }
}
