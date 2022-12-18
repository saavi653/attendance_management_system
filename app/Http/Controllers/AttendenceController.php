<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Illuminate\Support\Facades\Auth;

class AttendenceController extends Controller
{
    public function store()
    {
        $current_date=now()->toDateString();

        $user = Attendance::lastRecord()->first();  

        if($user)
        {
            if($user->date == $current_date)
            {
                return back()->with('error', 'Attendance Already Marked');
            }  
        }      
    
        Attendance::create([
            'user_id' => Auth::id(),
            'status' => Attendance::PRESENT,
            'date' => $current_date
        ]);
         
        return back()->with('success', 'Attendance Marked Successfully');
    }
}
