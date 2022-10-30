<?php

use App\Events\UserRegisterd;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\PadController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

//login
Route::get('/login', [LoginController::class, 'showLoginForm']);
Route::post('/login', [LoginController::class, 'login'])->name('login');

//logout
Route::post('/logout', [LogoutController::class, 'logout'])->name('logout');

//register
Route::get('/register', [RegisterController::class, 'showRegisterForm']);
Route::post('/register', [RegisterController::class, 'register'])->name('register');

//reset password
Route::get('/password/reset', [ForgotPasswordController::class, 'showResetForm'])->name('forgot-password');

//verify email
Route::get('/email/verify', [VerificationController::class, 'notice'])->name('verification.notice');
Route::post('/email/verification-notification', [VerificationController::class, 'sendEmailVeri'])->middleware(['auth', 'throttle:6,1'])->name('verification.send');
Route::get('email/verify/{id}', [VerificationController::class, 'verify'])->name('verification.verify');
Route::get('email/resend', [VerificationController::class, 'resend'])->name('verification.resend');

//admin
Route::get('/home', [UserController::class, 'redirect'])->name('home');

// Route::group(['middleware' => 'auth'], function () {
//     Route::group(['prefix' => 'interviewer', 'as' => 'interviewer.'], function () {

//     });
// });
Route::group(['prefix' => 'pad', 'as' => 'pad.'], function () {
    Route::get('/', [PadController::class, 'index'])->name('index');
    Route::post('/new', [PadController::class, 'store'])->name('create');
});
Route::get('pad/{id}', [PadController::class, 'show'])->name('pad.show');

Route::get('/send', function() {
    event(new UserRegisterd("hallo"));
});
