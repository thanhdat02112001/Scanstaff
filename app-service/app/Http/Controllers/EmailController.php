<?php

namespace App\Http\Controllers;

use App\Mail\CustomEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class EmailController extends Controller
{
    public function send(Request $request)
    {
        Mail::to($request->email)->send(new CustomEmail($request->link));
        return 'ok';
    }
}
