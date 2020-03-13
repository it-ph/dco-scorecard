<?php

namespace App\helpers;
use App\v2\Template;
use App\v2\TemplateColumn;
use App\v2\TemplateContent;

class TemplateQueries {
    function foo() {
        return 'nikko';
    }
    
    /** 
     * 
     * Retrieve One content base on Row and Column Position
     */
    function contentBaseOnRowAndColumnPosition($template_id,$row_position,$column_position)
    {
        $template_id = filter_var($template_id, FILTER_SANITIZE_STRING);
        $row_position = filter_var($row_position, FILTER_SANITIZE_STRING);
        $column_position = filter_var($column_position, FILTER_SANITIZE_STRING);

        $content = TemplateContent::where('template_id',$template_id)
        ->where('row_position',$row_position)
        ->where('column_position',$column_position)
        ->first();
        
        return $content;
    }

    function contentBaseonRow($template_id,$row_position)
    {
        $template_id = filter_var($template_id, FILTER_SANITIZE_STRING);
        $row_position = filter_var($row_position, FILTER_SANITIZE_STRING);
    
        $content = TemplateContent::where('template_id',$template_id)
        ->where('row_position',$row_position)
        ->first();
        
        return $content;
    }

    function contentBaseonColumn($template_id,$column_position)
    {
        $template_id = filter_var($template_id, FILTER_SANITIZE_STRING);
        $column_position = filter_var($column_position, FILTER_SANITIZE_STRING);
    
        $content = TemplateColumn::where('template_id',$template_id)
        ->where('column_position',$column_position)
        ->first();
        
        return $content;
    }
}



