<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function getMoreNoti(Request $request)
    {
        $noti = Notification::take(3)
        ->skip($request->current)
        ->where('user_id', Auth::user()->id)
        ->orderBy('created_at', 'desc')
        ->get();
        return $noti;
    }

    public function readAllNoti()
    {
        $notis = Notification::all();
        foreach ($notis as  $noti) {
            $noti->read = 1;
            $noti->save();
        }
    }

    public function readNoti($id)
    {
        $noti = Notification::find($id);
        $noti->read = 1;
        $noti->save();
        return redirect()->route('admin.interviewers');
    }

    public function interviewers()
    {
        return view('backend.admin.interviewer');
    }

    public function home()
    {
        
    }
}
