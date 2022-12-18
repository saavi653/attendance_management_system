<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use Carbon\Carbon;
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

            //absent functionality
            $previous_date=Carbon::parse($user->date);
            $diff=now()->diffInDays($previous_date);
            if($diff>1)
            {
                for($i=$diff; $i>1; $i--)
                {
                    Attendance::create([
                        'user_id' => Auth::id(),
                        'status' => Attendance::ABSENT,
                        'date' => $previous_date->addDays(1)
                    ]);
                }
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
