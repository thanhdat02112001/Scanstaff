<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        if (!Auth::attempt($request->only('email', 'password')))
        {
            return response()
                ->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();

        if ($user->approved_at == null) {
            return response()
                ->json(['message' => 'You need admin approved to login'], 401);
        }

        if ($user->banned == 1) {
            return response()
                ->json(['message' => 'Your account has been banned'], 401);
        }

        $token = $user->createToken('auth_token')->plainTextToken;
        return response()
            ->json(['user' => $user, 'access_token' => $token, 'token_type' => 'Bearer', 'status' => 200, 'isAdmin' => $user->isAdmin()]);
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

        return response()
            ->json(['data' => $user, 'access_token' => $token, 'token_type' => 'Bearer',]);
    }

    public function resend(Request $request)
    {
        $request->user()->sendEmailVerificationNotification();
        return response()->json(['status' => 200, 'message' => 'we have sent you email verification!']);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'You have successfully logged out and the token was successfully deleted',
            'status' => 200,
        ];
    }
}
