<?php

use App\Events\UserRegisterd;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\LogoutController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\VerificationController;
use App\Http\Controllers\EmailController;
use App\Http\Controllers\InterviewerController;
use App\Http\Controllers\PadController;
use App\Http\Controllers\RequestController;
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

Route::group(['middleware' => 'auth'], function () {
    //interviewer
    Route::group(['prefix' => 'interviewer', 'as' => 'interviewer.'], function () {
        Route::get('/', [InterviewerController::class, 'home'])->name('home');
        Route::get('/questions', [InterviewerController::class, 'questions'])->name('question');
        Route::get('/interviewees',[InterviewerController::class, 'interviewees'])->name('interviewee');

        Route::group(['prefix' => 'pad', 'as' => 'pad.'], function () {
            Route::get('/', [PadController::class, 'index'])->name('index');
            Route::post('/new', [PadController::class, 'store'])->name('create');
        });
    });

    //admin
    Route::group(['prefix' => 'admin', 'as' => 'admin.'], function () {
        Route::post('/get-more-noti', [AdminController::class, 'getMoreNoti']);
        Route::post('/read-all-noti', [AdminController::class, 'readAllNoti']);
        Route::get('/noti/{id}/seen', [AdminController::class, 'readNoti'])->name('noti.seen');
        Route::get('/interviewers', [AdminController::class, 'interviewers'])->name('interviewers');
        Route::get('/home', [AdminController::class, 'home'])->name('home');
    });

});

Route::get('pad/{id}', [PadController::class, 'show'])->name('pad.show');
Route::post('/pad/{id}/get-content', [PadController::class, 'getContent']);
Route::post('/pad/{id}/add_member', [PadController::class, 'broadcastAddMember'])->name('pad.broadcast-add-member');
Route::put('/pad/{id}/edit', [PadController::class, 'update'])->name('pad.update');
Route::put('/pad/{id}/edit/guest', [PadController::class, 'updateForGuest'])->name('pad.updatte-guest');
Route::post('/pad/{id}/delete_member', [PadController::class, 'broadcastDeleteMember'])->name('pad.broadcast-delete-member');

Route::post('send-email', [EmailController::class, 'send'])->name('email-invite');

//OpenFass
Route::post('/faas/{language}', [RequestController::class, 'sendPostRequest']);
Route::view('admin/home', 'backend.admin.home');
Route::view('admin/interviewees', 'backend.admin.interviewee');
Route::view('/password-change', 'frontend.auth.password-change');
