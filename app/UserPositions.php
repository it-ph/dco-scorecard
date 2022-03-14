<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class UserPositions extends Model
{
    protected $table = 'user_positions';
    protected $guarded = [];

    public function theuser()
    {
        return $this->belongsTo('App\User', 'user_id');
    }

    public function thedepartment()
    {
        return $this->belongsTo('App\Department', 'department_id');
    }

    public function theposition()
    {
        return $this->belongsTo('App\Position', 'position_id');
    }

    public function thesupervisor()
    {
        return $this->belongsTo('App\User', 'supervisor_id');
    }

    public function themanager()
    {
        return $this->belongsTo('App\User', 'manager_id');
    }
}
