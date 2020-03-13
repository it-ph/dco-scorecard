<?php

namespace App\v2;

use Illuminate\Database\Eloquent\Model;

class Metric extends Model
{
    protected $table = 'metrics';
    protected $guarded = [];

    public function thelasteditor()
    {
        return $this->belongsTo('App\User','last_updated_by');
    }

}
