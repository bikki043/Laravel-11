<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthenController extends Controller
{
    public function register()
    {
        return view('register');
    }
    public function store(Request $request)
    {
        $request->validate([
            "name" => ["required", "string", "min:3", "max:255"],
            "email" => ["required", "email", "unique:users,email"],
            "password" => ["required", "min:6"]

        ]);

        $user = User::create([
            "name" => $request->name,
            "email" => $request->email,
            "password" => Hash::make($request->password)
        ]);

        Auth::login($user);
        return redirect()->route('dashboard');
    }

    ///login 
    public function login()
    {
        return view('login');
    }
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            "email" => "required",
            "password" => "required"
        ]);

        $autherticated = Auth::attempt($credentials);
        if (!$autherticated) {
            Session::flash('error', 'Credential does not match!');
            return Redirect::back();
        } else {
            return redirect()->route('dashboard');
        }
    }
    public function logout()
    {
       Session::flush();
       Auth::logout();
         return redirect()->route('login');
    }
}
