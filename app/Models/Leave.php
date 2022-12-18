<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Leave extends Model
{
    use HasFactory;

    CONST APPROVED = 'approved';
    CONST REJECTED = 'rejected';

    protected $fillable=[
        'user_id',
        'subject',
        'description',
        'leave',
        'status'
    ];

    public function scopeLeaveExists($query, $attributes)
    {
        return $query->where('user_id',Auth::id())
            ->where('leave', $attributes['leave']);
    }
}
