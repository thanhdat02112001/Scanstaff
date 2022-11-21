<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuestionController extends Controller
{
    public function index()
    {
        $langs = Language::all();
        $questions =  Question::where('user_id', Auth::user()->id)->get();
        return view('backend.interviewer.question', compact('langs', 'questions'));
    }

    public function create()
    {
        $languages = Language::all();
        return view('backend.interviewer.question-new', compact('languages'));
    }

    public function store(Request $request)
    {
        $ques = new Question();

        // random unique id for question
        do {
            $id = mt_rand(100000, 999999);
            $ques->id = $id;
        } while (!is_null(Question::find($id)));

        $ques->user_id = Auth::user()->id;
        $ques->language_id = $request->language;
        $ques->title = $request->title;
        $ques->description = $request->description;
        $ques->content = $request->content;
        $ques->save();

        $request->session()->flash('success', 'Question created');
        return redirect(route('interviewer.question'));
    }

    public function show($id)
    {
        $question = Question::findOrFail($id);
        $questions = Question::all();
        $langs = Language::all();
        if ($question->user_id != Auth::user()->id) {
            return redirect(route('interviewer.question'))->with('warning', 'Unauthorized question access');
        }
        return view('backend.interviewer.question-show', compact('question', 'questions', 'langs'));
    }
}
