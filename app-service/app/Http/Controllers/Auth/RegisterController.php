<?php

namespace App\Http\Controllers\Auth;

use App\Events\UserRegisterd;
use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function showRegisterForm()
    {
        return view("frontend.auth.register");
    }

    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'banned' => 0,
        ]);
        event(new Registered($user));
        $token = $user->createToken('auth_token')->plainTextToken;

        $noti = "User {$request->name} with email {$request->email} want to register.";

        // Create notification in db
        $new_noti = Notification::create([
            'description' => $noti,
            'user_id' => 1
        ]);

        // Event for admin
        $admin_noti = array(
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'noti_id' => $new_noti->id
        );

        // pass to JS
        $js_noti = json_encode($admin_noti);

        //Create event for admin
        event(new UserRegisterd($js_noti));
        return redirect()->route('verification.notice');
    }
}
