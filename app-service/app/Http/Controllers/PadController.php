<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Pad;
use App\Models\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PadController extends Controller
{
    public function index()
    {
        $langs =  Language::all();
        return view('backend.interviewer.home', compact('langs'));
    }

    public function store(Request $request)
    {
        $pad = new Pad();

        // Check if pad is created from question or not
        if ($request->ques_id) {
            $question = Question::findOrFail($request->ques_id);
            if ($question->user_id != Auth::user()->id) {
                return redirect()->back()->with('danger', 'Unauthorize question access');
            }
            $pad->language_id = $question->language_id;
            $pad->content = $question->content;
        } else {
            // if pad is newly created, default language id is 1
            $pad->language_id = 1;
        }

        // Generate unique random id for pad
        function getRandomId()
        {
            $salt = array_merge(range('A', 'Z'), range(0, 9));
            $maxIndex = count($salt) - 1;

            $result = '';
            for ($i = 0; $i < 8; $i++) {
                $index = mt_rand(0, $maxIndex);
                $result .= $salt[$index];
            }

            return $result;
        }

        do {
            $id = getRandomId();
            $pad->id = $id;
        } while (!is_null(Pad::find($id)));

        $pad->user_id = Auth::user()->id;
        $pad->title = "Untitled Pad - {$id}";
        $pad->status = Pad::STATUS_UNUSED;
        $pad->save();

        return Redirect::to(route('pad.show', $id));
    }

    public function show($id)
    {
        $pad = Pad::find($id);
        $pad->language = Language::find($pad->language_id)->name;
        $langs = Language::all();
        return view('frontend.pad', compact('pad', 'langs'));
    }
}
