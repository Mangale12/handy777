<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Halloin;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;
use App\Mail\HalloinMail;
use Carbon\Carbon;
use App\Models\GeneralSetting;

class HalloinController extends Controller
{
    public function index(){
        return view('halloin.halloin');
    }
    
   public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:halloins,email',
        ]);
    
        // Create the Halloin record with a 16-character random key for 'record'
        try{
            $data = Halloin::create([
                'full_name' => $request->name,
                'email' => $request->email,
                'record_key' => Str::random(16), // Generates a 16-character random string
            ]);
            Mail::to($data->email)->send(new HalloinMail($data->full_name));
        }catch(Exception $e){
            
        }
        
        return redirect()->route('halloin.success');
    }
    public function success(){
        return view('halloin.success');
    }
    
    public function spinner(){
        $final = Halloin::first();
        $final['players_list'] = Halloin::all();
        $final['winner_info'] = [
                            'player_name' => 'mangal tamang',
                            'player_id' => 10
                        ];
        $players_list = Halloin::all();
        $carbon_now = Carbon::now();
        $old_list = null;
        $settings = GeneralSetting::first();
        return view('halloin.spinner', compact('final', 'old_list', 'settings', 'carbon_now'));
    }
}
