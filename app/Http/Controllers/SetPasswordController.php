<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class SetPasswordController extends Controller
{
    public function create(User $user)
    {

        return view('employees.setpassword', ['user' => $user]);
    }

    public function store(User $user, Request $request)
    {
       $attributes = $request->validate([
            
            'email' => 'required',
            'password' => 'required|min:3|max:255',
            'confirm_password' => 'same:password'
       ]);

       $user->update([

            'password' => Hash::make($attributes['password']),
            'email_status' => true 
       ]);

       return redirect('/')->with('success','Password Set Successfully');
     
    }


}
