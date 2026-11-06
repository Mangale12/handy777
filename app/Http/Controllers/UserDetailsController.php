<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Imports\UserDetailsImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\UserDetails;
class UserDetailsController extends Controller
{
    public function index(){
        $forms = UserDetails::get()->toArray();
        return view('newLayout.user_details', compact('forms'));
    }
    public function store(Request $request){
        $request->validate([
            'file'=>'required',
            ]);
        $file = $request->file('file');
        // $headingRow = Excel::toArray(new UserDetailsImport(), $file);
        Excel::import(new UserDetailsImport(), $file);
        // dd("uploaded");
        return redirect()->back()->with('message','File Uploaded Successfully !!');
    }
}
