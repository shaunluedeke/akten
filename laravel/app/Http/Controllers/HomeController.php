<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        return view('home');
    }

    public function updateeditpw(Request $request){
        Validator::make($request->all(),[
            'old_password' => 'required',
            'new_password' => 'required|min:8|confirmed',
            'new_password_confirmation' => 'required|min:8',
        ])->validate();
        if($request->input('old_password') === $request->input('new_password')){
            return redirect()->back()->withErrors(['error' => 'New password cannot be the same as the old password.'])->withInput();
        }
        if(!(Hash::check($request->input('old_password'), Auth::user()->password))){
            return redirect()->back()->withErrors(['error' => "Your current password does not matches with the password you provided. Please try again."])->withInput();
        }
        $user = Auth::user();
        $user->password = Hash::make($request->input('new_password',"test123"));
        $user->update();
        return redirect()->back()->withErrors(['success' => 'Password changed successfully']);

    }
}
