<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Pad;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InterviewerController extends Controller
{
    public function home() {
        $pads = Pad::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        foreach ($pads as $pad) {
            $interviewees = '';
            if (count($pad->interviewees) !== 0) {
                foreach ($pad->interviewees as $interviewee) {
                    $interviewees .= $interviewee->name . ", ";
                }
                $interviewees = substr($interviewees, 0, strlen($interviewees) - 2);
            }
            $pad->interviewees = $interviewees;
        }
        $langs = Language::all();
       
        return view('backend.interviewer.home', compact('pads', 'langs'));
    }

    public function questions() {
        return view('backend.interviewer.question');
    }

    public function interviewees() {
        return view('backend.interviewer.interviewee');
    }
}
