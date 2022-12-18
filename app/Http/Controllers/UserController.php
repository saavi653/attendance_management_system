<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Role;
use App\Models\User;
use App\Notifications\SetPasswordNotification;
use App\Notifications\UserNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    public function index()
    {
        $users = User::Employee();
     
        return view('admin.index', ['users' => $users]);
    }

    public function create()
    {

        return view('admin.users.create');
    }

    public function store(Request $request) 
    {  
        $attributes = $request->validate([

            'firstname' => 'required|string|min:3|max:255',
            'lastname' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:3|max:255',
        ]);

        $attributes += [

            'created_by' => Auth::id(),
            'role_id' => Role::EMPLOYEE
        ];

        $user = User::create($attributes);

        Notification::send($user, new SetPasswordNotification(Auth::user()));

        return redirect()->route('admin.dashboard')
            ->with('success', 'User Created Successfully');
    }

    public function edit(User $user)
    {

        return view('admin.users.edit', ['user' => $user]);
    }

    public function update(User $user, Request $request)
    {
        $attributes = $request->validate([

            'firstname' => 'required|string|min:3|max:255',
            'lastname' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:3|max:255'
        ]);

        $user->update($attributes);
     
        return redirect()->route('admin.dashboard')
            ->with('success', 'User Updated Successfully');
    }
    public function delete(User $user)
    {
        $user->delete();

        return back()->with('success', 'User Deleted Successfully');
    }

}
