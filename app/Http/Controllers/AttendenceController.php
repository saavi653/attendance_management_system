<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendenceController extends Controller
{
    public function store()
    {
        $current_date=now()->toDateString();

        $user = Attendance::where('user_id', Auth::id())
                ->orderBy('date', 'desc')->first();
        if($user)
        {
            if($user->date == $current_date)
            {
                return back()->with('error', 'attendance already marked');
            }  
        }      
    
        Attendance::create([
            'user_id' => Auth::id(),
            'status' => Attendance::PRESENT,
            'date' => $current_date
        ]);

        return back()->with('success', 'attendance marked successfully');
    }
}
