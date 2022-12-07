<?php

namespace App\Http\Controllers;

use App\Models\RentLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class RentLogController extends Controller
{
    public function index(){
        // return view ('rentlog');

        $today = Carbon::now()->toDateString();
        $rentLogs = RentLogs::with(['user','book'])->get();
        return view('rentlog',compact('rentLogs', 'today'));
    }
}
