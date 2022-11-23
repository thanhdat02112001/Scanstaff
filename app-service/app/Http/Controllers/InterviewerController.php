<?php

namespace App\Http\Controllers;

use App\Models\Language;
use App\Models\Pad;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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



    public function interviewees() {
        $user = Auth::user();
        $interviewees = DB::table('interviewees')
            ->join('interviewee_pad', 'interviewees.id', '=', 'interviewee_pad.interviewee_id')
            ->join('pads', 'interviewee_pad.pad_id', '=', 'pads.id')
            ->join('users', 'pads.user_id', '=', 'users.id')
            ->select('interviewees.name', 'interviewees.id', 'interviewees.created_at')
            ->where('users.id', $user->id)
            ->distinct()
            ->orderBy('interviewees.created_at', 'desc')
            ->get();
        foreach ($interviewees as $interviewee) {
            $pads = DB::table('pads')
                ->join('languages', 'pads.language_id', '=', 'languages.id')
                ->join('interviewee_pad', 'pads.id', '=', 'interviewee_pad.pad_id')
                ->select('pads.id', 'pads.title', 'languages.name', 'interviewee_pad.created_at')
                ->where([
                    ['interviewee_pad.interviewee_id', $interviewee->id],
                    ['pads.user_id', $user->id]
                ])
                ->get();
            foreach ($pads as $pad) {
                $pad->created = Carbon::createFromFormat('Y-m-d H:i:s', $pad->created_at)->diffForHumans();
            }
            $interviewee->pads = $pads;
        }
        return view('backend.interviewer.interviewee', compact('interviewees'));
    }

    public function searchInterviewee(Request $request)
    {
        $user = Auth::user();
        $inters = DB::table('interviewees')
            ->join('interviewee_pad', 'interviewees.id', '=', 'interviewee_pad.interviewee_id')
            ->join('pads', 'interviewee_pad.pad_id', '=', 'pads.id')
            ->join('users', 'pads.user_id', '=', 'users.id')
            ->select('interviewees.name', 'interviewees.id', 'interviewees.created_at')
            ->where([
                ['users.id', $user->id],
                ['interviewees.name', 'like', "%{$request->name}%"]
            ])
            ->distinct()
            ->orderBy('interviewees.created_at', 'desc')
            ->get();
        foreach ($inters as $key => $interviewee) {
            // Filter date
            $created = Carbon::parse($interviewee->created_at);
            $del = false;

            switch ($request->time) {
                case 'today':
                    if ($created->isToday() === false) {
                        unset($inters[$key]);
                        $del = true;
                    }
                    break;
                case '7 days ago':
                    if ($created < Carbon::today()->subWeek()) {
                        unset($inters[$key]);
                        $del = true;
                    }
                    break;
                case 'month':
                    if (!$created->isCurrentMonth()) {
                        unset($inters[$key]);
                        $del = true;
                    }
                    break;
                case 'year':
                    if (!$created->isCurrentYear()) {
                        unset($inters[$key]);
                        $del = true;
                    }
                    break;
                default:
                    break;
            }

            if ($del) continue;

            $pads = DB::table('pads')
                ->join('languages', 'pads.language_id', '=', 'languages.id')
                ->join('interviewee_pad', 'pads.id', '=', 'interviewee_pad.pad_id')
                ->select('pads.id', 'pads.title', 'languages.name', 'interviewee_pad.created_at')
                ->where([
                    ['interviewee_pad.interviewee_id', $interviewee->id],
                    ['pads.user_id', $user->id]
                ])
                ->get();
            foreach ($pads as $pad) {
                $pad->created = Carbon::createFromFormat('Y-m-d H:i:s', $pad->created_at)->diffForHumans();
            }
            // Get pads info
            $interviewee->pads = $pads;
        }

        return $inters;
    }
}
