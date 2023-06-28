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

    public function scopeTlsuperior($query,$position,$authID)
    {
        $this->position = $position;
        $this->authID = $authID;
        return $query->whereHas('thetl', function($q){
            $q->where($this->position,$this->authID);
        });
    }

    public function thetlsignature()
    {
        return $this->belongsTo('App\Signature','tl_signature_id');
    }
    
    public function themanagersignature()
    {
        return $this->belongsTo('App\Signature','manager_signature_id');
    }
    

    public function thenewManager()
    {
        return $this->belongsTo('App\User','new_manager_id');
    }

    public function thetowerheadsignature()
    {
        return $this->belongsTo('App\Signature','towerhead_signature_id');
    }
  
}
