<?php

namespace App\v2;

use Illuminate\Database\Eloquent\Model;

class TemplateColumn extends Model
{
    protected $table = 'template_column';
    protected $guarded = [];

    public function thetemplate()
    {
        return $this->belongsTo('App\Template','template_id');
    }
}
