<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PadController extends Controller
{
    public function index()
    {
        return view('backend.interviewer.pads');
    }
}
