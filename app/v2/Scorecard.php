<?php

namespace App\v2;

use Illuminate\Database\Eloquent\Model;

class Scorecard extends Model
{
    protected $table = 'scorecard_db';
    protected $guarded = [];

    public function theuser()
    {
        return $this->belongsTo('App\User','user_id');
    }

    public function thecreatedby()
    {
        return $this->belongsTo('App\User','created_by');
    }

    
}
