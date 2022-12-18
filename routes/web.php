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

        return redirect()->route('admin.dashboard');
    }    
    else
    {
        return view('login');
    }
    
})->name('login');         

Route::post('login/check',[LoginController::class, 'login'])->name('login.check');

Route::get('logout',[LogoutController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function(){

    Route::controller(UserController::class)->group(function () {

        Route::get('admin', 'index')->name('admin.dashboard');
        Route::get('admin/users/create', 'create')->name('users.create');
        Route::post('admin/users/store', 'store')->name('users.store');
        Route::get('admin/users/{user:slug}/edit', 'edit')->name('users.edit');
        Route::post('admin/users/{user}/update', 'update')->name('users.update');
        Route::delete('admin/users/{user}/delete', 'delete')->name('users.delete');
    });

    Route::controller(SetPasswordController::class)->group(function () {

        Route::get('users/{user:slug}/create-password',  'create')->name('password.create');
        Route::post('users/{user:slug}/store-password',  'store')->name('password.store');
    });

    Route::get('employee/dashboard', [EmployeeController::class, 'index'])->name('employees.dashboard');

    Route::post('employee/attendance', [AttendenceController::class, 'store'])->name('attendance.store');

    Route::controller(LeaveController::class)->group(function () {

        Route::post('employee/leave', 'store')->name('leave.store');
        Route::get('employee/{user}/leave/{leave}/status/approved', 'approved')->name('employees.leave.status.approved');
        Route::get('employee/{user}/leave/{leave}/status/rejected', 'rejected')->name('employees.leave.status.rejected');
    }); 

});