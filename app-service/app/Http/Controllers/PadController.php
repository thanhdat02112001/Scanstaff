<?php

namespace App\Http\Controllers;

use App\Events\PadJoinerUpdate;
use App\Events\PadLanguageUpdate;
use App\Events\PadNoteUpdate;
use App\Events\PadTitleUpdate;
use App\Models\Interviewee;
use App\Models\Language;
use App\Models\Pad;
use App\Models\Question;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Redis;

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
        // Get Pad information
        $pad = Pad::findOrFail($id);

        // Check if pad is ended or not
        if ($pad->status === Pad::STATUS_ENDED) {
            if (!Auth::check()) {
                abort(404, "This pad is ended, you don't have permission to open it");
            }
        }
        $pad->lg = Language::find($pad->language_id)->name;

        // Get all questions information
        $questions = Question::all();

        // Get all language
        $langs = Language::all();

        // Get all participants
        $redis = Redis::connection();
        $temp = $redis->lrange("pad-{$id}-participants", 0, -1);

        $participants = array();
        // Check if session expired, delete from redis
        foreach ($temp as $key => $participant) {
            $member = json_decode($participant);
            $sid = $member->session_id;
            $session = Session::getHandler()->read($sid);
            if ($session == '') {
                $redis->lrem("pad-{$id}-participants", 0, $participant);
                // unset($temp[$key]);
            } else {
                $participants[] = $participant;
            }
        }
        return view('frontend.pad', compact('pad', 'questions', 'langs', 'participants'));
    }

    public function getContent($id)
    {
        $pad = Pad::find($id);
        return $pad->content;
    }

    public function broadcastAddMember(Request $request, $id)
    {
        // Search in redis if user has joined
        $redis = Redis::connection();
        $participants = $redis->lrange("pad-{$id}-participants", 0, -1);
        foreach ($participants as $participant) {
            $user = json_decode($participant);
            if ($user->session_id == $request->value['session_id'] && $user->name == $request->value['name']) {
                return 'User joined the pad';
            }
        }

        // If not, save it to redis
        $json_values = json_encode($request->value);
        $redis->rpush("pad-{$id}-participants", $json_values);
        event (new PadJoinerUpdate($json_values, $id, 'add'));
        return 'Added user to the pad';
    }

    public function update(Request $request, $id)
    {
        // Find pad
        $pad = Pad::findOrFail($id);

        // Get all input
        $input = $request->all();

        if (isset($input['value']['note'])) {
            // Broadcast note
            event (new PadNoteUpdate($input['value']['note'], $id));
        }

        if (isset($input['value']['language_id'])) {
            // Broadcast language_id
            event (new PadLanguageUpdate($input['value']['language_id'], $id));
        }

        if (isset($input['value']['title'])) {
            // Broadcast title
            event (new PadTitleUpdate($input['value']['title'], $id));
        }

        $pad->fill($input['value']);
        $pad->title = $pad->title ?? '';
        $pad->save();
    }

    public function updateForGuest(Request $request, $id)
    {
        // Find pad
        $pad = Pad::find($id);
        if ($pad === null) {
            return 'pad not found';
        }

        // Check if exist interviewee's name
        $name = $request->name;
        $interviewee = Interviewee::where('name', $name)->first();
        if ($interviewee !== null) {
            if (!$request->confirm) {
                return 'founded';
            } else {
                $founded = $pad->interviewees()->where('interviewee_id', $interviewee->id)->get();
                if (count($founded) === 0) {
                    $pad->interviewees()->attach($interviewee->id);
                }
            }
        } else {
            $new = Interviewee::create(['name' => $request->name]);
            $pad->interviewees()->attach($new->id);
        }

        if ($pad->status != Pad::STATUS_ENDED) {
            $pad->status = Pad::STATUS_INPROGRESS;
        }

        $pad->save();
        return 'updated';
    }

    public function broadcastDeleteMember(Request $request, $id)
    {
        // Search in redis if exist user in list
        $redis = Redis::connection();
        $participants = $redis->lrange("pad-{$id}-participants", 0, -1);
        foreach ($participants as $participant) {
            $user = json_decode($participant);
            if ($user->session_id == $request->value['session_id'] && $user->name == $request->value['name']) {
                // Remove that user from list
                $redis->lrem("pad-{$id}-participants", 0, json_encode($user));
                broadcast(new PadJoinerUpdate($participant, $id, 'delete'));
                return 'Removed user from the pad';
            }
        }

        // If not, reset users list
        $participants = $redis->lrange("pad-{$id}-participants", 0, -1);
        event (new PadJoinerUpdate($participants, $id, 'reset'));
        return "Didn't found user in this pad";
    }
}
