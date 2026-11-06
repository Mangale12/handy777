<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\FrontSetting;

class FrontendSettingController extends Controller
{
    public function storeGeneralSetting(Request $request)
    {
        $frontSetting = FrontSetting::first();

        if($request->hasFile('logo')){
            $frontSetting->logo = $request->file('logo')->store('uploads/logo');
        }

        if($request->hasFile('admin_logo')){
            $frontSetting->admin_logo = $request->file('admin_logo')->store('uploads/admin_logo');
        }

        if($request->hasFile('favicon')){
            $frontSetting->favicon = $request->file('favicon')->store('uploads/favicon');
        }

        if($request->hasFile('admin_login_background')){
            $frontSetting->admin_background = $request->file('admin_login_background')->store('uploads/admin_login_background');
        }

        if($request->hasFile('admin_login_sidebar')){
            // $imgName = time().'.'.$request->admin_login_sidebar->extension();
            // $frontSetting->admin_login_sidebar = $request->admin_login_sidebar->move(public_path('/buploads/admin_login_sidebar'),$imgName);
             $frontSetting->admin_login_sidebar = $request->file('admin_login_sidebar')->store('uploads/admin_login_sidebar');
        }

        if($frontSetting->save()){
            return redirect()->route('admin.index');
        }
        else{
            return back();
        }
    }

    public function image()
    {
        return view('image');
    }
}
