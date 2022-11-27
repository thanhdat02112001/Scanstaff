<?php

namespace App\Http\Controllers;

use App\Models\Interviewee;
use App\Models\Language;
use App\Models\Notification;
use App\Models\Pad;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
        $unapproved = User::where('approved_at', null)->get();
        $interviewers = User::where([
            ['approved_at', '<>', null],
            ['email_verified_at', '<>', null]
        ])->get();
        return view('backend.admin.interviewer', compact('unapproved', 'interviewers'));
    }

    public function approve($id)
    {
        $user = User::findOrFail($id);
        $user->approved_at = Carbon::now();
        $user->save();
        return redirect()->route('admin.interviewers');
    }

    public function decline($id)
    {
        $user = User::findOrFail($id);
        // Delete in pivot table
        $user->roles()->detach();
        // Delete in user table
        $user->delete();
        return redirect()->route('admin.interviewers');
    }


    /**
     * Ban user
     *
     * @param $id
     * @return void
     */
    public function ban($id)
    {
        $user = User::findOrFail($id);
        // Ban user
        $user->banned = true;
        $user->save();
        return redirect()->route('admin.interviewers');
    }

    public function viewUserPad($id)
    {
        $pads = Pad::where('user_id', $id)->orderBy('created_at', 'desc')->get();
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
        $user = User::find($id);
        return view('backend.admin.user-pads', compact('pads', 'langs', 'user'));
    }

    /**
     * Unban user
     *
     * @param $id
     * @return void
     */
    public function unban($id)
    {
        $user = User::findOrFail($id);
        // Unban user
        $user->banned = false;
        $user->save();
        return redirect()->route('admin.interviewers');
    }

    public function home()
    {
        $pads =  Pad::all('created_at');
        $pad_total_counts = $pads->count();
        $interviewer = User::where([
            ['approved_at', '<>', null],
            ['email_verified_at', '<>', null]
        ]);
        $interviewer_total_counts = $interviewer->count();
        $interviewees = Interviewee::all('created_at');
        $interviewee_total_counts = $interviewees->count();
        $statics = [
            'Pads' => $pad_total_counts,
            'Interviewers' =>  $interviewer_total_counts,
            'Interviewees' => $interviewee_total_counts,
        ];

        return view('backend.admin.home', compact('statics'));
    }

    public function drawChart()
    {
        $pad_by_date = DB::table('pads')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as pads'))->whereMonth('created_at', now()->month)->groupBy('date')->get();
        $interviewee_by_date = DB::table('interviewees')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as interviewees'))->whereMonth('created_at', now()->month)->groupBy('date')->get();
        $date1 = [];
        $date2 = [];
        $data = [];
        foreach ($pad_by_date as $item) {
            array_push($date1, $item->date);
        }
        foreach ($interviewee_by_date as $item) {
            array_push($date2, $item->date);
        }
        $categories = array_unique(array_merge($date1, $date2));
        sort($categories);
        foreach ($categories as $dt) {
            $pad_counts = Pad::where(DB::raw('DATE(created_at)'), $dt)->count();
           $interviewee_counts = DB::table('interviewees')->where(DB::raw('DATE(created_at)'), $dt)->count();
           $interviewer_counts = DB::table('users')->where(DB::raw('DATE(created_at)'), '<=', $dt)->where('banned', 0)->count();
           $data[$dt]['pad'] = $pad_counts;
           $data[$dt]['interviewee'] = $interviewee_counts;
           $data[$dt]['interviewee'] = $interviewer_counts;
        }
        return response()->json(['date' => $categories, 'data' => $data]);
    }
}
