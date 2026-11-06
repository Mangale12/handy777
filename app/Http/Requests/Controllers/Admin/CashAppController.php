<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CashApp;

class CashAppController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cashapp = CashApp::all();
        return view('admin.pages.cashapp.index',compact('cashapp'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.pages.cashapp.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cashapp = new CashApp;
        $cashapp->title = $request->title;
        $cashapp->balance = $request->balance;
        $cashapp->status = 1;
        $cashapp->save();
        return redirect()->route('cashapp.index')->with('success','CashApp has been added');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $cashapp = CashApp::findOrFail($id);
        return view('admin.pages.cashapp.edit',compact('cashapp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $cashapp = CashApp::find($id);
        $cashapp->title = $request->title;
        $cashapp->balance = $request->balance;
        $cashapp->update();
        return redirect()->route('cashapp.index')->with('success','CashApp has been updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $cashapp = CashApp::find($id);
        $cashapp->delete();
        return redirect()->route('cashapp.index')->with('success','CashApp has been deleted');
    }

    public function trashCashapp()
    {
        $cashapp = CashApp::onlyTrashed()->get();
        return view('admin.pages.cashapp.cashapp_trash',compact('cashapp'));
    }

    public function restoreCashapp($id)
    {
        $cashapp = CashApp::withTrashed()->find($id);
        if(!is_null($cashapp))
        {
            $cashapp->restore();
        }

        return redirect()->route('cashapp.index')->with('success','CashApp has been deleted');
    }

    public function forceDelCashapp($id)
    {
        $cashapp = CashApp::withTrashed()->find($id);
        if(!is_null($cashapp))
        {
            $cashapp->forceDelete();
        }
        return redirect()->route('cashapp.index')->with('success','CashApp has been deleted');
    }
  
}
