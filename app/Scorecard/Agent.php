<?php

namespace App\Scorecard;

use Illuminate\Database\Eloquent\Model;

class Agent extends Model
{

    // protected $dates = ['month'];
    protected $table = 'agent_scorecard';
    protected $guarded = [];
    protected $dates = ['date_acknowledge_by_agent','date_acknowledge_by_tl','date_acknowledge_by_manager'];


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

    public function theagentsignature()
    {
        return $this->belongsTo('App\Signature','agent_signature_id');
    }

    public function thetlsignature()
    {
        return $this->belongsTo('App\Signature','tl_signature_id');
    }
    
    public function themanagersignature()
    {
        return $this->belongsTo('App\Signature','manager_signature_id');
    }

    public function thenewTl()
    {
        return $this->belongsTo('App\User','new_tl_id');
    }

    public function thenewManager()
    {
        return $this->belongsTo('App\User','new_manager_id');
    }

}
