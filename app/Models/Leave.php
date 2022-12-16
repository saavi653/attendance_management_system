<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Leave extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'subject',
        'description',
        'leave_on',
        'status'
    ];
    public function scopeLeaveExists($query, $attributes)
    {
       return $query->where('user_id',Auth::id())
            ->where('leave_on', $attributes['leave'])->get()->toArray();
    }
   
}
