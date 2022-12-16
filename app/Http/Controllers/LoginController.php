<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function login(Request $request)
    {
       $user=User::where('email', $request->email)->first();
    
        $attributes=$request->validate([

            'email' => 'required|email|min:3|max:255',
            'password' => 'required|min:3|max:255'
            
        ]);
      
        if($user)
        {
            if($user->email_status)
            { 
                if(Auth::attempt($attributes)) 
                {    
                    if(Auth::user()->is_Employee)
                    {
                        return redirect()->route('employees.dashboard');
                    }
                    
                    return redirect()->route('admin.dashboard')->with('success', 'welcome admin');
                }
            
                return back()->with('error','incorrect credential'); 
            }    
            return back()->with('error','user inactive');  
        }
        return back()->with('error', 'user does not exist');
     }    
   
}

