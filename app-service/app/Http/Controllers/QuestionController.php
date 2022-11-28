<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $ques = Question::findOrFail($id);
        $questions = Question::where('user_id', Auth::user()->id)->get();
        $langs = Language::all();
        if ($ques->user_id != Auth::user()->id) {
            return redirect(route('interviewer.question'))->with('warning', 'Unauthorized question access');
        }
        return view('backend.interviewer.question-show', compact('ques', 'questions', 'langs'));
    }

    public function edit($id)
    {
        $question = Question::find($id);
        $languages = Language::all();
        if ($question->user_id != Auth::user()->id) {
            return redirect(route('interviewer.question'))->with('warning', 'Unauthorized question access');
        }
        return view('backend.interviewer.question-edit', compact('question', 'languages'));
    }

    public function update(Request $request, $id)
    {
        $question = Question::findOrFail($id);

        // Check if user is author
        if ($question->user_id != Auth::user()->id) {
            return redirect(route('interviewer.question'))->with('danger', 'Unauthorized question access');
        }

        // Get all input
        $input = $request->all();

        // Delete unused properties
        unset($input['_token']);

        $question->fill($input)->save();

        return redirect(route('interviewer.question'))->with('success', 'Question edited');
    }

    public function destroy($id)
    {
        $question = Question::findOrFail($id);

        // Check if user is author
        if ($question->user_id != Auth::user()->id) {
            return redirect(route('interviewer.question'))->with('danger', 'Unauthorized question access');
        }

        $question->delete();

        return redirect(route('interviewer.question'))->with('success', 'Successfully deleted the question');
    }

    public function search(Request $request)
    {
        if ($request->lg_id == "all") {
            $questions = DB::table('questions')
                ->join('languages', 'questions.language_id', '=', 'languages.id')
                ->select('questions.id', 'languages.name', 'questions.title')
                ->where([
                    ['questions.user_id', Auth::user()->id],
                    ['questions.title', 'LIKE', "%{$request->search}%"]
                ])
                ->get();
        } else {
            $questions = DB::table('questions')
                ->join('languages', 'questions.language_id', '=', 'languages.id')
                ->select('questions.id', 'languages.name', 'questions.title')
                ->where([
                    ['questions.user_id', Auth::user()->id],
                    ['questions.title', 'LIKE', "%{$request->search}%"],
                    ['questions.language_id', $request->lg_id]
                ])
                ->get();
        }
        return $questions->toJson(JSON_PRETTY_PRINT);
    }
}
