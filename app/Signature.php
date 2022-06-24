<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    protected $table = 'my_signature';
    protected $guarded = [];

    public function theuser()
    {
        return $this->belongsTo('App\User','id');
    }
}
