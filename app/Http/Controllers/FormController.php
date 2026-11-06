<?php

namespace App\Http\Controllers;

use App\Mail\customMail;
use App\Mail\monthlyMail;
use App\Models\Form;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Response;
use Illuminate\Support\Facades\Mail;
// use App\Mail\UserNoticMail;
use App\Mail\UserNoticMail as UserNoticMail;
use App\Mail\NoticeUserMail as NoticeUserMail;
use App\Mail\UnsubscribeMail;
use App\Models\FormGame;
use Illuminate\Support\Str;
use App\Models\Account;
use Illuminate\Support\Facades\DB;
use App\Models\GeneralSetting;
use App\Models\History;
use App\Models\Unsubmail;
use Exception;
use App\Models\Theme;
use Illuminate\Support\Facades\Log;
use App\Mail\MassEmailFile;
use App\Models\SameDevice;
use App\Mail\SameDeviceMail;

class FormController extends Controller
{
    public function __construct() {
        // $this->middleware('auth', ['except' => [
        //     'store','checkCaptcha','go','unsubStore',
        //     'unsubscribe'
        // ]]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    // public function fetchHistory(Request $request)
    // {
    //     // Fetch the player with histories relationship and filter dates if provided
    //     $player = Form::where('id', $request->id)
    //         ->with(['histories' => function($query) use ($request) {
    //             if ($request->filled('start_date')) {
    //                 $query->whereDate('created_at', '>=', $request->start_date);
    //             }
    //             if ($request->filled('end_date')) {
    //                 $query->whereDate('created_at', '<=', $request->end_date);
    //             }
    //         }])
    //         ->firstOrFail();



    //     // Return the player with filtered histories and account data
    //     return response($player);
    // }

    public function chat(Request $request)
    {
        $user = $this->chatUser($request);

        return view('frontend.cloud.chat', [
            'email' => optional($user)->email,
            'user' => $user,
        ]);
    }

    /**
     * POST /chat — validate the email, then open the chat UI.
     */
    public function chatPost(Request $request)
    {
        $authenticatedUser = $this->authenticatedChatUser();
        if ($authenticatedUser) {
            // A signed-in user cannot switch the account used for chat by
            // changing the email field in the browser.
            $email = $authenticatedUser->email;
            $user = $authenticatedUser;
        } else {
            $validated = $request->validate([
                'email' => ['required', 'email'],
            ]);
            $email = strtolower(trim($validated['email']));

            $user = Form::whereRaw('LOWER(TRIM(email)) = ?', [$email])->first();
            if (!$user) {
                return redirect()
                    ->route('chat')
                    ->withErrors(['email' => 'No account was found with this email address.'])
                    ->withInput();
            }
        }

        if ($email) {
            session(['chat_email' => $email]);
        }

        return view('frontend.cloud.chat_start', [
            'email' => $email,
            'user' => $user,
        ]);
    }

    /**
     * POST /chat/logout — clear only the visitor's chat account selection.
     */
    public function chatLogout(Request $request)
    {
        $request->session()->forget('chat_email');

        return redirect()->route('chat');
    }

    private function chatUser(Request $request): ?Form
    {
        $authenticatedUser = $this->authenticatedChatUser();
        if ($authenticatedUser) {
            return $authenticatedUser;
        }
        $email = strtolower(trim((string) $request->input('email', session('chat_email', ''))));
        return $email ? Form::whereRaw('LOWER(TRIM(email)) = ?', [$email])->first() : null;
    }

    private function authenticatedChatUser(): ?Form
    {
        $email = null;

        try {
            $webUser = auth()->user();
            $email = $webUser && !empty($webUser->email) ? $webUser->email : null;
        } catch (\Throwable $exception) {
            $email = null;
        }

        if (!$email) {
            try {
                $apiUser = auth('api')->user();
                $email = $apiUser && !empty($apiUser->email) ? $apiUser->email : null;
            } catch (\Throwable $exception) {
                $email = null;
            }
        }

        return $email
            ? Form::whereRaw('LOWER(TRIM(email)) = ?', [strtolower(trim($email))])->first()
            : null;
    }

    public function getHistoryByDate(Request $request)
    {
        $startDate = $request->first_date;
        $endDate = $request->end_date;

        // Fetch the history records filtered by date range and grouped by account_id and type
        $history = History::select('account_id', 'type', DB::raw('SUM(amount_loaded) as total_loaded'))
            ->where('form_id', $request->id)
            ->groupBy('account_id', 'type')
            ->with('account');

        // Apply date filters if provided
        if ($startDate) {
            $history->whereDate('created_at', '>=', $startDate);
        }
        if ($endDate) {
            $history->whereDate('created_at', '<=', $endDate);
        }

        $history = $history->groupBy('type')->get();

        // Calculate the total sum
        $totalSum = $history->sum('total_loaded');

        return response($history);
    }



     public function massMail(){
         $users = Form::get()->toArray();
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);
         try{
            foreach($users as $user){
                if($user['id'] > 214){

                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     'background_image'=>$bulk_mail['background_image'],
                     ];
                    Mail::to($user['email'])->send(new MassEmailFile($details));
                    // Mail::to('americangamingclub@gmail.com')->send(new MassEmailFile($details));
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                }

            }

            dd("mail send success");

         }catch(\Exception $e)
            {
                $bug = $e->getMessage();
                dd($e);
                Log::channel('spinnerBulk')->info($bug);

            }



     }

     function testSms(){
         $basic  = new \Vonage\Client\Credentials\Basic("b63e05b5", "nIzBhAChI1mXZfza");
         $client = new \Vonage\Client($basic);
         $response = $client->sms()->send(
    new \Vonage\SMS\Message\SMS("9779849649679", American_Cashino, 'A text message sent using the Nexmo SMS API')
        );

        $message = $response->current();

        if ($message->getStatus() == 0) {
            echo "The message was sent successfully\n";
        } else {
            echo "The message failed with status: " . $message->getStatus() . "\n";
        }
     }
     public function testmassMail(){
         $users = DB::table("noor_jan_active_user")->get()->toArray();
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);

         try{
            foreach($users as $user){
                $user = (array)$user;
                if($user['id'] > 0 && $user['id']<2){

                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'background_image'=>$bulk_mail['background_image'],
                     'copyright_text'=>$bulk_mail['coopyright_text'],
                     'app_name'=>$bulk_mail['app_name'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     ];
                    Mail::to('mangaletamang65@gmail.com')->send(new MassEmailFile($details));
                 Mail::to('americangamingclub@gmail.com')->send(new MassEmailFile($details));
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                    return back()->with('success','mail send');
                }

            }



         }catch(\Exception $e)
            {
                $bug = $e->getMessage();
                dd($e);
                Log::channel('spinnerBulk')->info($bug);

            }



     }
     public function noorMassMail(){
        //  dd("test");
         $users = DB::table("noor_emails")->orderBy('id', 'desc')->get()->toArray();
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);
         try{
            foreach($users as $user){
                $user=(array)$user;
                    if($user['is_mail_send'] == 0){


                    // $details = [
                    //  'user'=>$user,
                    //  'message'=>$bulk_mail['message'],
                    //  'subject'=>$bulk_mail['subject'],
                    //  'image'=>$bulk_mail['image'],
                    //  'background_image'=>$bulk_mail['background_image'],
                    //  ];
                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'background_image'=>$bulk_mail['background_image'],
                     'copyright_text'=>$bulk_mail['coopyright_text'],
                     'app_name'=>$bulk_mail['app_name'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     ];

                    Mail::to($user['email'])->send(new MassEmailFile($details));
                    DB::table('noor_emails')->where('id', $user['id'])->update(['is_mail_send' => 1]);
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                    }
            }

            dd("mail send success");

         }catch(\Exception $e)
            {
                $bug = $e->getMessage();
                dd($e);
                Log::channel('spinnerBulk')->info($bug);

            }



     }
     function noorJanActiveUsers(){
         $users = DB::table("noor_jan_active_user")->orderBy('id', 'desc')->get()->toArray();
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);
         try{
            foreach($users as $user){
                $user=(array)$user;
                    if($user['is_mail_send'] == 0){

                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'background_image'=>$bulk_mail['background_image'],
                     'copyright_text'=>$bulk_mail['coopyright_text'],
                     'app_name'=>$bulk_mail['app_name'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     ];

                    Mail::to($user['email'])->send(new MassEmailFile($details));
                    DB::table('noor_jan_active_user')->where('id', $user['id'])->update(['is_mail_send' => 1]);
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                    }
            }

            dd("mail send success");

         }catch(\Exception $e){
            $bug = $e->getMessage();
            dd($e);
            Log::channel('spinnerBulk')->info($bug);

        }
     }
     function woodsJanActiveUsers(){
         $users = DB::table("woods_jan_active_user")->orderBy('id', 'desc')->get()->toArray();
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);
         try{
            foreach($users as $user){
                $user=(array)$user;
                    if($user['is_mail_send'] == 0){

                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'background_image'=>$bulk_mail['background_image'],
                     'copyright_text'=>$bulk_mail['coopyright_text'],
                     'app_name'=>$bulk_mail['app_name'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     ];

                    Mail::to($user['email'])->send(new MassEmailFile($details));
                    DB::table('woods_jan_active_user')->where('id', $user['id'])->update(['is_mail_send' => 1]);
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                    }
            }

            dd("mail send success");

         }catch(\Exception $e){
            $bug = $e->getMessage();
            dd($e);
            Log::channel('spinnerBulk')->info($bug);

        }
     }
     public function noorActiveMassMail(){
        //  dd("test");
         $users = DB::table("noor_active_user")->orderBy('id', 'desc')->get()->toArray();
         dd($users);
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);
         try{
            foreach($users as $user){
                $user=(array)$user;
                    if($user['is_mail_send'] == 0){


                    // $details = [
                    //  'user'=>$user,
                    //  'message'=>$bulk_mail['message'],
                    //  'subject'=>$bulk_mail['subject'],
                    //  'image'=>$bulk_mail['image'],
                    //  'background_image'=>$bulk_mail['background_image'],
                    //  ];
                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'background_image'=>$bulk_mail['background_image'],
                     'copyright_text'=>$bulk_mail['coopyright_text'],
                     'app_name'=>$bulk_mail['app_name'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     ];

                    Mail::to($user['email'])->send(new MassEmailFile($details));
                    DB::table('noor_active_user')->where('id', $user['id'])->update(['is_mail_send' => 1]);
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                    }
            }

            dd("mail send success");

         }catch(\Exception $e)
            {
                $bug = $e->getMessage();
                dd($e);
                Log::channel('spinnerBulk')->info($bug);

            }



     }
     public function woodsMassMail(){
          $users = DB::table("woods_email")->orderBy('id', 'asc')->get()->toArray();
         $settings = GeneralSetting::first()->toArray();
         $bulk_mail = json_decode($settings['bulk_mail'], true);
         try{
            foreach($users as $user){
                $user=(array)$user;
                    if($user['is_mail_send'] == 0){


                    // $details = [
                    //  'user'=>$user,
                    //  'message'=>$bulk_mail['message'],
                    //  'subject'=>$bulk_mail['subject'],
                    //  'image'=>$bulk_mail['image'],
                    //  'background_image'=>$bulk_mail['background_image'],
                    //  ];
                    $details = [
                     'user'=>$user,
                     'message'=>$bulk_mail['message'],
                     'subject'=>$bulk_mail['subject'],
                     'image'=>$bulk_mail['image'],
                     'background_image'=>$bulk_mail['background_image'],
                     'copyright_text'=>$bulk_mail['coopyright_text'],
                     'app_name'=>$bulk_mail['app_name'],
                     'enable_logo'=>$bulk_mail['enable_logo'],
                     ];

                    Mail::to($user['email'])->send(new MassEmailFile($details));
                    DB::table('woods_email')->where('id', $user['id'])->update(['is_mail_send' => 1]);
                    Log::channel('spinnerBulk')->info("mail send success fully to ".$user['email']." id = ".$user['id']);
                    }
            }

            dd("mail send success");

         }catch(\Exception $e)
            {
                $bug = $e->getMessage();
                dd($e);
                Log::channel('spinnerBulk')->info($bug);

            }
     }
    public function test(){
            $limit_amount = 10;
            $history = History::with('account')->with('form')
                                ->whereHas('form')
                                // ->whereBetween('created_at', [Carbon::now()->subMinutes(1440), now()])
                                ->orderBy('id', 'desc')
                                ->get()
                                ->toArray();

            $final = [];
            $forms = [];

            if (!empty($history))
            {
                foreach ($history as $a => $b)
                {
                    $totals = [
                        'tip' => 0,
                        'load' => 0,
                        'redeem' => 0,
                        'refer' => 0,
                        'cashAppLoad' => 0
                    ];

                    $form_game = FormGame::where('form_id', $b['form_id'])->where('account_id', $b['account_id'])->first();
                    if (!empty($form_game))
                    {
                        $form = Form::where('id', $b['form_id'])->first();
                        if (!empty($form))
                        {
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

                    }
                }
            }
            $limit = 0;
            $final_redeem = [];
            $final_tip = [];
            if(!empty($final)){
                foreach ($final as $a => $b){
                    if($b['totals']['redeem']  >= $limit_amount){
                        array_push($final_redeem,$b);
                    }
                    if($b['totals']['tip']  >= $limit_amount){
                        array_push($final_tip,$b);
                    }
                }
                // dd($final_redeem,$final_tip);
                if(empty($final_redeem)){
                    Log::channel('cronLog')->info('Empty Data Today For Mail of Redeem');
                }else{
                    $details = [
                        'subject' => 'Total Players this month who redeemed more than '.$limit_amount,
                        'type' => 'redeem',
                        'data' => $final_redeem
                    ];
                    //git check
                    // Mail::to('joshibipin2052@gmail.com')->send(new monthlyMail(json_encode($details)));
                }

                if(empty($final_tip)){
                    Log::channel('cronLog')->info('Empty Data Today For Mail of Tip');
                }else{
                    $details = [
                        'subject' => 'Total Players this month who tipped more than '.$limit_amount,
                        'type' => 'tip',
                        'data' => $final_redeem
                    ];
                    Mail::to('joshibipin2052@gmail.com')->send(new monthlyMail(json_encode($details)));

                }
            }else{
                //empty all data
                echo 'a';
                Log::channel('cronLog')->info('Empty Data Today For Mail of Redeem & Tip');
            }
            // dd('l');


    }

    public function finalunsub($token){
        $form = Form::where('unsub_token',$token);
        if($form->count() > 0){
            $form2 = $form->first();
        // dd($form->get());
            $form->update([
                'unsub_token' => null
            ]);
            Form::where('id',$form2->id)->delete();
            return redirect()->route('homePage');
        }else{
            Log::channel('spinnerBulk')->info("Someone tried to unscubscribe with the token ".$token);
            return redirect()->route('homePage');
        }
    }
    public function unsubSuccess(){
        return view('frontend.unsubSuccess');
    }
    public function unsubStore(Request $request){
        $id = $request->id;
        Unsubmail::where('form_id',$id)->update([
            'status' => 0
        ]);
        Form::where('id',$id)->delete();
        return redirect(route('unsubSuccess'));
    }
    public function unsubStore1(Request $request){
        $full_name = $request->full_name;
        $number = $request->number;
        $email = $request->email;
        if(Form::where(['full_name' => $full_name,'number' => $number,'email' => $email])->count() > 0){
            $token_id = Str::random(32);
            $form = Form::where(['full_name' => $full_name,'number' => $number,'email' => $email])->update([
                'unsub_token' => $token_id
            ]);
            $form = Form::where(['full_name' => $full_name,'number' => $number,'email' => $email])->first()->toArray();
            // $message = "<h2>It's not the same without you !</h2><br><p>You've been successfully unsubscribed.</p>";
            $settings = GeneralSetting::where('id',1)->first();
            $message = "<h2>It's not the same without you !</h2>";
            $data = [
                'message' => $message,
                'subject' => 'Unsubscribe Email',
                'theme' => ($settings->theme),
                'unsub_token' => $token_id
            ];
            try
            {
                Mail::to($form['email'])->send(new UnsubscribeMail(json_encode($data)));
                Log::channel('spinnerBulk')->info("Unscubscribe mail sent successfully to ".$form['email']);
                // return redirect()->route('forms.unsubscribe')->withSuccess(['success' => 'Please check your email for further process.']);
                return redirect()->back()->withInput()->with('success', 'Please check your email for further process.');
            }
            catch(\Exception $e)
            {
                $bug = $e->getMessage();
                Log::channel('spinnerBulk')->info($bug);
                return redirect()->back()->withInput()->with('error', $bug);
            }
        }else{
            return redirect()->route('forms.unsubscribe')->withErrors(['error' => 'Sorry We could not identify you.']);
        }
    }
    public function unsubscribe()
    {
        return view('frontend.unsub');
    }

    public function index()
    {
      //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('welcome');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
     public function checkCaptcha(Request $request){
         $entered_captcha = strtoupper(trim((string) $request->input('captcha')));
         $generated_captcha = session('captcha_token');

         // captcha_image.php uses PHP's native session because it runs outside Laravel.
         if (!$generated_captcha) {
             if (session_status() !== PHP_SESSION_ACTIVE) {
                 @session_start();
             }
             $generated_captcha = $_SESSION['captcha_token'] ?? null;
         }

         $is_valid = $entered_captcha !== ''
             && $generated_captcha
             && hash_equals(strtoupper((string) $generated_captcha), $entered_captcha);

         return Response::json($is_valid ? 'true' : 'false');
     }
    public function store(Request $request)
{
    $request->validate([
        'full_name' => 'required|min:3|max:20',
        'facebook_name' => 'required|min:7',
        'game_id' => 'required|min:7|unique:forms,game_id',
        'number' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|unique:forms,number',
        'mail' => 'required',
        'email' => 'required|regex:/(.+)@(.+)\.(.+)/i|min:6|unique:forms,email',
        'account' => 'required',
    ]);

    DB::beginTransaction();

    try {
        $settings = GeneralSetting::first();
        $interval = Carbon::today()->addDays(30);
        $final = date($interval);
        $count = 0;

        $ip = request()->ip(); // <-- Set IP here
        $device_id = request()->header('User-Agent'); // <-- Example for device_id

        $formdata = [
            'full_name'      => $request->full_name,
            'number'         => $request->number,
            'email'          => $request->email,
            'mail'           => $request->mail,
            'r_id'           => $request->r_id,
            'game_id'        => $request->game_id,
            'facebook_name'  => $request->facebook_name,
            'intervals'      => $final,
            'count'          => $count,
            'ip'             => $ip,
            'device_id'      => $device_id,
            'user_id'        => $request->user_id,
        ];

        $form = Form::create($formdata);

        FormGame::create([
            'form_id'   => $form->id,
            'account_id'=> $request->account,
            'game_id'   => $request->game_id,
        ]);

        $boyname = $request->full_name;
        $mail_text = $settings->mail_text;
        $sms_text = $settings->sms_text;
        $game_name = strtoupper($settings->theme == 'default' ? 'Handy' : $settings->theme);
        $logo = Theme::where('name', $settings->theme)->first('logo');

        $sendtext = 'Hello Admin, ' . $boyname . ' ' . $mail_text;
        $sendtextuser = $game_name . ' Games Club. ' . $sms_text;

        $data = [
            'logo'             => $logo,
            'text'             => $sendtext,
            'user_notice_text' => $settings->sms_text,
            'name'             => $boyname,
            'game'             => $game_name,
            'theme'            => $game_name,
            'phone'            => $request->number,
            'email'            => $request->email,
            'face_book'        => $request->facebook_name,
            'ip'               => $ip,
        ];

        $user['to'] = $request->email;

        // Send user confirmation mail
        Mail::send('mails.noticeuser', $data, function ($message) use ($user) {
            $message->to($user['to']);
            $message->subject('New Registration');
        });

        // Send admin notification mail
        Mail::to("redninoteat@gmail.com")->send(new UserNoticMail(json_encode($data)));

        if (!empty($settings['new_register_mail'])) {
            $emails = explode(',', $settings['new_register_mail']);
            foreach ($emails as $a) {
                Mail::to($a)->send(new UserNoticMail(json_encode($data)));
                Log::channel('cronLog')->info("New registration mail sent to: {$a}");
            }
        }

        DB::commit();


            return redirect(route('success'));

    } catch (\Exception $e) {
        DB::rollBack();
        Log::channel('cronLog')->error('Registration failed: ' . $e->getMessage());

        return back()->with('error', 'Something went wrong. Please try again.');
    }
}




    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function show(Form $form)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    // public function edit(Form $form)
    // {

    //     return view('forms.edit', compact('form'));
    // }
      public function edit($id)
    {
        $form = Form::where('id',$id)->first();

        return view('forms.edit', compact('form'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {

        $form = Form::find($id);
        $this->validate($request, [
            'full_name' => 'required',

            'number' => 'required',

        ]);
        $form->full_name = $request->full_name;
        $form->email = $request->email;
        $form->intervals = $request->intervals;

        $form->number = $request->number;
          $form->count = $request->count;
        $form->note = $request->note;
        $form->facebook_name = $request->facebook_name;
        $form->game_id = $request->game_id;
        $form->save();
        return redirect(route('home'))->with('message', " Updated Successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Form  $form
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {

        $form = Form::where('id',$id)->delete();
    //   Form::find($id)->delete($id);

   return redirect(route('home'))->with('message', " Deleted Successfully");
    }

      public function saveNote(Request $request)
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

    public function restorePlayers($id)
    {
        $form = Form::withTrashed()->find($id);
        if(!is_null($form))
        {
            $form->restore();
        }
          return redirect(route('home'))->with('message', " Player restored Successfully");
    }

     public function forceDeletePlayers($id)
    {
        $form = Form::withTrashed()->find($id);
        if(!is_null($form))
        {
            $form->forceDelete();
        }
          return redirect(route('home'))->with('message', " Player deleted Successfully");
    }

}
