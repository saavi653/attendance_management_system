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

            'title' => 'required|min:3|max:255',
            'des' => 'required|min:3',
            'leave' => 'required|after:today', 
        ]); 

        if(Leave::leaveExists($attributes)->first())
        {
            return back()->with('error', 'Cant Send Leave For Same Date');
        }

        Notification::send(User::admin(), new LeaveNotification(Auth::user(), $attributes));
        
        Leave::create([

            'user_id' => Auth::id(),
            'subject' => $attributes['title'],
            'description' => $attributes['des'],
            'leave' => $attributes['leave'],
        ]);

        return back()->with('success', 'Mail Sent Successfully');
    }

    public function approved(User $user,Leave $leave)
    {
        $leave->update([

            'status' => Leave::APPROVED
        ]);

        Attendance::create([

            'user_id' =>$user->id,
            'status' => Attendance::LEAVE,
            'date' => $leave->leave
        ]);
        
        Notification::send($user, new ApprovedNotification(Auth::user(), $leave));    
    
        return back()->with('success', 'Leave Approved');
        
    }

    public function rejected(User $user,Leave $leave)
    {
        $leave->update([

            'status' => Leave::REJECTED
        ]);

        Notification::send($user, new RejectedNotification(Auth::user(), $leave));    

        return back()->with('success', 'Leave Rejected');
    }
   
}
