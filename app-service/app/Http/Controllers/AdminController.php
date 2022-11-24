<?php

namespace App\Http\Controllers;

use App\Models\Interviewee;
use App\Models\Notification;
use App\Models\Pad;
use App\Models\User;
use Carbon\CarbonPeriod;
use DateInterval;
use DatePeriod;
use DateTime;
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
        return view('backend.admin.interviewer');
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
        dd(array_values($pad_by_date->toArray()));
        $interviewee_by_date = DB::table('interviewees')->select(DB::raw('DATE(created_at) as date'), DB::raw('count(*) as interviewees'))->whereMonth('created_at', now()->month)->groupBy('date')->get();
        $date1 = [];
        $date2 = [];
        $data = [];
        foreach ($pad_by_date as $item) {
            array_push($date1, $item->date);
            $data['date'] = $item->date;
        }
        foreach ($interviewee_by_date as $item) {
            array_push($date2, $item->date);
        }
        dd(array_values($pad_by_date->toArray()));
        dd(array_search('2022-11-09', $pad_by_date->toArray()));
        $categories = array_unique(array_merge($date1, $date2));
        foreach ($categories as $dt) {
            if (in_array($dt, $date1)) {
                $data[$dt]['pad'] = reset($pad_by_date)->id;
            }
        }
        return response()->json([$pad_by_date, $interviewee_by_date]);
    }
}
