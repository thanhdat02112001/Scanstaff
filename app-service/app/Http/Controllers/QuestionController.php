<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {

    }

    public function create()
    {
        $languages = Language::all();
        return view('backend.interviewer.question-new', compact('languages'));
    }

    public function store()
    {

    }
}
