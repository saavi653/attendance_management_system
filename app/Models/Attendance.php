<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;
    protected $fillable=[
        'user_id',
        'status',
        'date'
    ];

    CONST ABSENT=0;
    CONST PRESENT=1;
    CONST LEAVE=2;
}