<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
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
        $newUser = [
            'email' => $request->email,
            'name' => $request->name,
            'password' => Hash::make($request->password),
            'banned' => 0,
        ];
        $user = User::create($newUser);
        if ($user) {
            event(new Registered($user));
        }
        return redirect()->route('verification.notice');
    }
}
