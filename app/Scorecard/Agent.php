<?php

namespace App\Scorecard;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{

    // protected $dates = ['month'];
    protected $table = 'agent_scorecard';
    protected $guarded = [];


    public function theagent()
    {
        return $this->belongsTo('App\User','agent_id');
    }

    public function scopeAgentdetails($query,$agentID)
    {
        return $query->where('agent_id',$agentID);
    }

    public function scopeMonth($query)
    {
        return $query->groupBy('month')->orderBy('id','desc');
    }

    public function scopeAgentsuperior($query,$position,$authID)
    {
        $this->position = $position;
        $this->authID = $authID;
        return $query->whereHas('theagent', function($q){
            $q->where($this->position,$this->authID);
        });
    }

}
