<?php

namespace App\Scorecard;

use Illuminate\Database\Eloquent\Model;

class tl extends Model
{

    protected $table = 'tl_scorecard';
    protected $guarded = [];


    public function thetl()
    {
        return $this->belongsTo('App\User','tl_id');
    }

    public function scopeTldetails($query,$tlId)
    {
        return $query->where('tl_id',$tlId);
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
