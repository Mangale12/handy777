<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\CashApp;
use App\Models\CashierFrontend;
use Response;
use DB;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier.dashboard');
    }

    public function login()
    {
        $frontsetting = CashierFrontend::first();
        return view('cashier.login',compact('frontsetting'));
    }

    public function showToday()
    {
        $mytime = Carbon::today();
        
        $role = date($mytime);
        // $role = '2021-06-27 00:00:00';
        $users = DB::table('forms')
            ->when($role, function ($query, $role) {
                return $query->where('intervals', $role);
            })
            ->get();

        return view('cashier.pages.show_today', compact('users'))->with('i', (request()->input('page', 1) - 1) * 5);;
    }

    public function showCashApp()
    {
        $cashapp = CashApp::all();
        return view('cashier.pages.cashapp.index',compact('cashapp'));
    }

    public function updateCashAppBalance(Request $request)
    {
        $cashapp = array(
            'balance' => isset($request->balance)?($request->balance):null,
        );
        $balance = CashApp::find($request->cid);
        $balance->balance = isset($request->balance)?($request->balance):null;
        if(!$balance->save())
        {
            return Response::json(['error' => $balance],404);
        }
        return Response::json('Balance Changed');
    }
}
