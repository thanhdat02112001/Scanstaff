<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class InterviewerController extends Controller
{
    public function home() {
        $langs = Language::all();
        return view('backend.interviewer.home');
    }

    public function questions() {
        return view('backend.interviewer.question');
    }

    public function interviewees() {
        return view('backend.interviewer.interviewee');
    }
}
