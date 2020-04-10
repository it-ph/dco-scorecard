<?php

namespace App\v2;

use Illuminate\Database\Eloquent\Model;

class Template extends Model
{
    protected $table = 'template_name';
    protected $guarded = [];

    public function thecolumns()
    {
        return $this->hasMany('App\v2\TemplateColumn', 'template_id', 'id');
    }

    public function thecontent()
    {
        return $this->hasMany('App\v2\TemplateContent', 'template_id', 'id');
    }

}
