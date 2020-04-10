<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $guarded = [];


    public function thetemplate()
    {
        return $this->belongsTo('App\v2\Template','default_template');
    }
}
