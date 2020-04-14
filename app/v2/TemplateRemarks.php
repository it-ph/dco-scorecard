<?php

namespace App\v2;

use Illuminate\Database\Eloquent\Model;

class TemplateRemarks extends Model
{
    protected $table = 'template_remarks';
    protected $guarded = [];

    public function thetemplate()
    {
        return $this->belongsTo('App\Template','template_id');
    }
}
