<?php

namespace App\Http\Controllers;

use App\Models\Form;
use App\Models\FormNumber;
use Illuminate\Http\Request;
use Datatables;
use Carbon\Carbon;
use App\Models\Image;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\customMail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth',['except' => 'apiUsers','apiStore']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'All Noor Gamers';
        $i = 0;
        $total = Form::count();
        $forms = Form::orderBy('id','desc')->get();
        
        // if (request()->ajax()) {
        //     return datatables()->of(Form::select('*'))
        //         ->addColumn('action', 'action')
        //         ->rawColumns(['action'])
        //         ->addIndexColumn()
        //         ->make(true);
        // }
        return view('home',compact('total','title','forms'));
    }
    
public function colab()
{
    // $forms = Form::whereDate('intervals', Carbon::today())->get();
    // if(count($forms)>0){
    //      Mail::to('om9crusvzd@cashflow35.com')->send(new customMail(json_encode($forms)));
    //     // echo count($forms);
    // }
      $title = 'All Collabration';
    $number = FormNumber::orderBy('id','desc')->get();
     $total = FormNumber::count();
    return view('colab',compact('number','total','title'));
}
    public function day()
    {

        $mytime = Carbon::today();
        
        $role = date($mytime);
        // $role = '2021-06-27 00:00:00';
        $users = DB::table('forms')
            ->when($role, function ($query, $role) {
                return $query->where('intervals', $role);
            })
            ->get();

        return view('dayscount', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    
    
    public function yesterday()
    {
       

        $mytime = Carbon::yesterday();
        
        $role = date($mytime);
        
        // $role = '2021-06-27 00:00:00';
        $users = DB::table('forms')
            ->when($role, function ($query, $role) {
                return $query->where('intervals', $role);
            })
            ->get();

        return view('dayscount', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);;
    }
   public function tommorow()
    {
       

        $mytime = Carbon::tomorrow();
        
        $role = date($mytime);
        
        // $role = '2021-06-27 00:00:00';
        $users = DB::table('forms')
            ->when($role, function ($query, $role) {
                return $query->where('intervals', $role);
            })
            ->get();

        return view('dayscount', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);;
    }
    
    public function imageUpload()
    {
        $users = DB::table('forms')
            ->get();
        return view('image-upload',compact('users'));
    }
    
    public function showImage()
    {
        $image = Image::all();
        return view('show-image',compact('image'));
    }
    
    public function deletedPlayers()
    {
        $forms = Form::onlyTrashed()->get();
        $count = $forms->count();
        return view('deleted-players',compact('forms','count'));
    }
    
    public function sendsms($id)
    {
        dd($id);
    }
    public function sendemail(Request $request, $id)
    {
        $interval = Carbon::today();
        $daysToAdd = 30;
        $interval = $interval->addDays($daysToAdd);
        $final = date($interval);



        $form = Form::find($id);


        $count = $form->count;
        $count = $count + '1';

        
        $form->count = $count;
        $form->intervals = $interval;
        $form->save();

        //   $basic  = new \Vonage\Client\Credentials\Basic("e20bd554", "M5arJoXIrJ8Kat1r");
        //         $client = new \Vonage\Client($basic);

 

        // $message = $client->message()->send([
        //     'to' => $form->number,
        //     'from' => '18337222376',
        //     'text' => 'Congratulations! you have now successfully completed a month as a Nooregames family member. You have received 20$ as your monthly reward. Please do check your account.'
        // ]);




        return redirect(route('day'))->with('message', " Successfully Data Saved with the next date");
    }
    
    function apiUsers(){
        if(isset($_GET['sheet_id'])){
            $users = DB::table('noor_emails')->where('is_mail_send', 0)->get();
        }else{
            $users = DB::table('noor_emails')->get();
        }
        
        return response()->json(['users' => $users]);
    }
    
    function apiStore(Request $request){
        $data = [
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email'=>$request->email,
            ];
            DB::table('payments')->insert($data);
            return response();
    }
}
