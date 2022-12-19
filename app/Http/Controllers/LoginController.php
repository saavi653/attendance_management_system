<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
        $attributes=$request->validate([

            'email' => 'required',
            'password' => 'required'
        ]);

        if(Auth::attempt($attributes)) 
        {  
            return redirect('/');
        }

        return back()->with('error','Incorrect Credential OR User Inactive '); 
    }    
   
}

