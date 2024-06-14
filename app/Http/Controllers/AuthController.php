<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'email' => 'required|email:rfc,dns',
            'password' => 'required',
        ]);

        if (Auth::attempt($request->only('email', 'password'))) {

            Session::put('login', 'login');

            $request->session()->regenerate();

            Session::flash('success', 'Kamu berhasil login');
            return redirect()->route('landing');
        }
        Session::flash('failed', 'Maaf email atau password anda masukan salah');
        return redirect()->route('login');
    }

    public function logout()
    {
        Auth::logout();

        session()->regenerateToken();
        session()->pull('login');

        session()->flash('success', 'Kamu berhasil logout');
        return redirect()->route('landing');
    }
}
