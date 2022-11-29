<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('frontend.auth.login');
    }

    public function login(LoginRequest $request)
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]) && Auth::user()->email_verified_at == null) {
            Auth::logout();
            return redirect()->route('verification.notice');
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password]) && Auth::user()->banned == 1) {
            Auth::logout();
            return redirect('/login')->with('warning', 'Your account has been banned');
        }
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            return redirect()->route('home')->with('success', 'Login success');
        }
        return redirect('/login')->with('error', 'Invalid Credentials');
    }
}
