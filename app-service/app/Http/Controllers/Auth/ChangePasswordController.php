<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ChangePasswordController extends Controller
{
    public function changePassword(Request $request)
    {
        $user = Auth::user();

        if (!(Hash::check($request->current_password, Auth::user()->password))) {
            // Check if current password matches
            return redirect()->back()->with("error", "Your current password does not matches with the password you provided. Please try again.");
        }

        if (strcmp($request->current_password, $request->password) === 0) {
            // If current password is the same as new password
            return redirect()->back()->with("error", "New password cannot be same as your current password. Please choose a different password.");
        }
        // Validate input
        $request->validate([
            'current_password' => 'required',
            'password' => 'required|confirmed',
        ]);

        //Change Password
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('home')->with("success", "Password changed successfully !");
    }
}
