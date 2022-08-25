<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function notice()
    {
        return view('frontend.auth.verify-email');
    }

    public function sendEmailVeri(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('message', 'Verification link sent!');
    }

    public function verify(Request $request)
    {
        $user = User::find($request->route('id'));
        if ($user->markEmailAsVerified()) {
            event(new Verified($user));
        }
        return redirect()->route('login')->with('success', 'Your email is verified successfully');
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return back()->with('success', 'We have resent you a verify email');
    }
}
