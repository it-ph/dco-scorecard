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
        'emp_id','name','supervisor','manager', 'email','position_id','department_id', 'role', 'password','status','two_factor_code','two_factor_expires_at'
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

    protected $dates = ['two_factor_expires_at'];


    //check if admin . = 1
    public function isAdmin()
    {
        if($this->role == 'admin' || $this->role == 'Admin')
        {
            return true;
        }
        return false;
    }

    public function isUser()
    {
        if($this->role == 'user' || $this->role == 'User' || $this->role == 'users' || $this->role == 'Users')
        {
            return true;
        }
        return false;
    }

    public function isAgent()
    {
        if($this->role == 'agent' || $this->role == 'Agent' || $this->role == 'agents' || $this->role == 'Agents')
        {
            return true;
        }
        return false;
    }

    public function isSupervisor()
    {
        if($this->role == 'supervisor' || $this->role == 'Supervisor')
        {
            return true;
        }
        return false;
    }

    public function isManager()
    {
        if($this->role == 'manager' || $this->role == 'Manager')
        {
            return true;
        }
        return false;
    }

    public function isCBAOrTowerHead()
    {
        if(($this->role == 'cba' || $this->role == 'CBA') || ($this->role == 'tower head' || $this->role == 'Tower Head'))
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

    public function thedepartment()
    {
        return $this->belongsTo('App\Department','department_id');
    }

    public function thesignatures()
    {
        return $this->hasMany('App\Signature','user_id');
    }

    /**
     * Generate 6 digits MFA code for the User
     */
    public function generateTwoFactorCode()
    {
        $this->timestamps = false; //Dont update the 'updated_at' field yet

        $this->two_factor_code = rand(100000, 999999);
        $this->two_factor_expires_at = now()->addMinutes(10);
        $this->save();
    }

    /**
     * Reset the MFA code generated earlier
     */
    public function resetTwoFactorCode()
    {
        $this->timestamps = false; //Dont update the 'updated_at' field yet

        $this->two_factor_code = null;
        $this->two_factor_expires_at = null;
        $this->save();
    }

    public function is2FApassed()
    {
        $user = User::where('emp_id', Auth::user()->email)->first();

        if($user->two_factor_code == NULL && $user->two_factor_expires_at == NULL)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

}
