<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Cviebrock\EloquentSluggable\Sluggable;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable,Sluggable; 
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'firstname',
        'lastname',
        'email',
        'password',
        'role_id',
        'slug',
        'created_by',
        'email_status'
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => ['firstname', 'lastname']
            ]
        ];
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

   public function getIsEmployeeAttribute()
   {
    
        return $this->attributes['role_id'] == Role::EMPLOYEE;
   }

   public function getIsAdminAttribute()
   {
    
        return $this->attributes['role_id'] == Role::ADMIN;
   }

   public function getFullNameAttribute()
   {
    
        return ucfirst($this->attributes['firstname']).' '.ucfirst($this->attributes['lastname']);
   }

   public function scopeAdmin($query)
   {
        return $query->where('role_id',Role::ADMIN)->get();
   }

   public function scopeEmployee($query)
   {
        return $query->where('role_id',Role::EMPLOYEE)->get();
   }

   public function leaves()
   {
        return $this->hasMany(Leave::class)
            ->where('status','pending');
   }

   public function TotalLeaves()
   {
        return $this->hasMany(Leave::class);
   }
   
}

