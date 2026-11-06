<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    function index(){


        $users = User::get();
        return view('newLayout.user.index',compact('users'));
    }
    function create(){
        $roles = Role::get();
        return view('newLayout.user.create', compact('roles'));
    }
    function store(Request $request){
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|same:confirmPassword',
            'role' => 'required'
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role'=>$request->role,
        ]);
        $user->assignRole($request->input('role'));
        // dd($user);
        return redirect()->route('user.index')->with('success', 'User Created Successfully');
    }
    function edit($id){
        $user = User::where('id',$id)->first();
        $roles = Role::get();
        return view('newLayout.user.edit',compact('user','roles'));
    }
    function update(Request $request, $id){
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,id,' . $id,
            'role' => 'required'
        ]);
        if (Auth::user()->hasRole('Super Admin|admin')) {
            $user = User::findOrFail($id);
            $user->name = $request['name'];
            $user->email = $request['email'];
            $user->role=$request['role'];
            $user->assignRole($request->input('role'));
            $user->update();

            return redirect()->route('user.index')->with('success', 'User has been updated successfully');
        } else {
            return redirect()->route('user.index')->with('error', 'Only authenticated user can edit');
        }
    }
    function destroy($id){
        $user = User::findOrFail($id);
        $user->delete();
        return back()->with('success', 'User has been deleted successfully');
    }
    function status(Request $request){
        User::where('id', $request->user_id)->update([
            'status'=>$request->status,
        ]);
        return response()->json(['message','Status Updated Successfully']);
    }
}
