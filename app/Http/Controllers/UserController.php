<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\Role;
use App\Models\User;
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
        $role = Role::where('id', Role::EMPLOYEE)->first();

        return view('admin.users.create', ['role' => $role]);
    }

    public function store(Request $request) 
    {  
        $attributes = $request->validate([
            'firstname' => 'required|string|min:3|max:255',
            'lastname' => 'required|string|min:3|max:255',
            'email' => 'required|email|min:3|max:255',
            'role_id' => [ 'required',
                Rule::in([
                    Role::EMPLOYEE
                ]) 
            ]
        ]);

        $attributes += [
            'created_by' => Auth::id()
        ];
        $user = User::create($attributes);

        Notification::send($user, new UserNotification(Auth::user()));

        return redirect()->route('admin.dashboard')
            ->with('success', 'user created successfully');
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
            ->with('success', 'user updated successfully');
    }
    public function delete(User $user)
    {
        $user->delete();

        return back()->with('success', 'user deleted successfully');
    }

}
