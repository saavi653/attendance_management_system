<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Leave;
use App\Models\Role;
use App\Models\User;
use App\Notifications\ApprovedNotification;
use App\Notifications\LeaveNotification;
use App\Notifications\RejectedNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;

class LeaveController extends Controller
{
    public function store( Request $request)
    {
        $current_date = now()->toDateString();
        $attributes = $request->validate([

            'title' => 'required|min:3|max:255|string',
            'des' => 'required|min:3|string',
            'leave' => 'required|after:today',
          
        ]); 
        
        if(Leave::leaveExists($attributes))
        {
            return back()->with('error', 'cant send leave for same date');
        }

        Notification::send(User::admin(), new LeaveNotification(Auth::user(), $attributes));
        
        Leave::create([
            'user_id' => Auth::id(),
            'subject' => $attributes['title'],
            'description' => $attributes['des'],
            'leave_on' => $attributes['leave'],
        ]);

        return back()->with('success', 'mail sent successfully');
    }

    public function approved(User $user,Leave $leave)
    {
        $leave->where('user_id',$user->id)
            ->where('leave_on',$leave->leave_on)
            ->update([
                'status' => 'approved'
        ]);

        Attendance::create([
            'user_id' =>$user->id,
            'status' => Attendance::LEAVE,
            'date' => $leave->leave_on
        ]);

        Notification::send($user, new ApprovedNotification(Auth::user(), $leave));    
    
        return back()->with('success', 'leave approved');
        
    }

    public function rejected(User $user,Leave $leave)
    {
        $leave->where('user_id',$user->id)
            ->where('leave_on',$leave->leave_on)
            ->update([
                'status' => 'rejected'
        ]);

        Notification::send($user, new RejectedNotification(Auth::user(), $leave));    

        return back()->with('success', 'leave rejected');
    }
   
}
