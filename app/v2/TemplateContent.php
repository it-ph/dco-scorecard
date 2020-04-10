<?php

namespace App\v2;

use Illuminate\Database\Eloquent\Model;

class TemplateContent extends Model
{
    protected $table = 'template_col_content';
    protected $guarded = [];

    
    public function scopeRowtag($query,$num)
    {
        return $query->where('row_position', $num);
    }

    public function thetemplate()
    {
        return $this->belongsTo('App\Template','template_id');
    }

}
