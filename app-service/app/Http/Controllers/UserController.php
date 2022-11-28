<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function redirect()
    {
        if (session('success')) {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.home')->with('success', session('success'));
            }
            return redirect()->route('interviewer.home')->with('success', session('success'));
        } else {
            if (Auth::user()->isAdmin()) {
                return redirect()->route('admin.home');
            }
            return redirect()->route('interviewer.home');
        }
    }
}
