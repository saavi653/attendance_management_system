<?php

use App\Http\Controllers\AttendenceController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\LeaveController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\SetPasswordController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/',function() {
    if(Auth::check()) 
    {
        if(Auth::user()->IsEmployee)
        {
            return redirect()->route('employees.dashboard');
        }
        elseif(Auth::user()->IsAdmin) 
        {
            return redirect()->route('admin.dashboard');
        }
    }    
        else
        {
            return view('login');
        }
    
})->name('login');       

Route::post('login/check',[LoginController::class, 'login'])->name('login.check');
Route::get('logout',[LogoutController::class, 'logout'])->name('logout');


Route::get('admin', [UserController::class, 'index'])->name('admin.dashboard');
Route::get('admin/users/create', [UserController::class, 'create'])->name('users.create');
Route::post('admin/users/store', [UserController::class, 'store'])->name('users.store');
Route::get('admin/users/{user:slug}/edit', [UserController::class, 'edit'])->name('users.edit');
Route::post('admin/users/{user}/update', [UserController::class, 'update'])->name('users.update');
Route::delete('admin/users/{user}/delete', [UserController::class, 'delete'])->name('users.delete');


Route::get('users/{user:slug}/create-password', [SetPasswordController::class, 'create'])->name('password.create');
Route::post('users/{user:slug}/store-password', [SetPasswordController::class, 'store'])->name('password.store');



Route::get('employee/dashboard', [EmployeeController::class, 'index'])->name('employees.dashboard');
Route::post('employee/attendance', [AttendenceController::class, 'store'])->name('attendance.store');

Route::post('employee/leave', [LeaveController::class, 'store'])->name('leave.store');
// Route::get('employee/{user}/leave/{data}/status', [LeaveController::class, 'status'])->name('employee.leave.status');
Route::get('employee/{user}/leave/{leave}/status/approved', [LeaveController::class, 'approved'])->name('employees.leave.status.approved');
Route::get('employee/{user}/leave/{leave}/status/rejected', [LeaveController::class, 'rejected'])->name('employees.leave.status.rejected');
