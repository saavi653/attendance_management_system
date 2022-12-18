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
         
                    return redirect()->route('admin.dashboard');
                }
            
                return back()->with('error','Incorrect Credential'); 
            }    
            return back()->with('error','User Inactive');  
        }

        return back()->with('error', 'User Does Not Exist');
     }    
   
}

