<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'emp_id','name','supervisor','manager', 'email','position_id', 'role', 'password','status'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];  


    //check if admin . = 1
    public function isAdmin()
    {
        if($this->role == 'admin')
        {
            return true;
        }
        return false;
    }

    public function isUser()
    {
        if($this->role == 'user')
        {
            return true;
        }
        return false;
    }

    public function thesupervisor()
    {
        return $this->belongsTo('App\User','supervisor');
    }

    public function themanager()
    {
        return $this->belongsTo('App\User','manager');
    }

    public function theposition()
    {
        return $this->belongsTo('App\Position','position_id');
    }
  
  


}
