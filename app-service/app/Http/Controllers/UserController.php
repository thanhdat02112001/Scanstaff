<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    public function redirect()
    {
        if (Auth::user()->isAdmin()) {
            return view('backend.admin.home');
        }
        return view('backend.interviewer.home');
    }
}
