<?php

namespace App\helpers;
use App\v2\Template;
use App\v2\TemplateColumn;
use App\v2\TemplateContent;

use App\v2\Scorecard;
use App\v2\ScorecardColumn;
use App\v2\ScorecardContent;


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

    function duplicateChecker($scorecard_id,$row_position,$column_position)
    {

        $scorecard_id = filter_var($scorecard_id, FILTER_SANITIZE_STRING);
        $row_position = filter_var($row_position, FILTER_SANITIZE_STRING);
        $column_position = filter_var($column_position, FILTER_SANITIZE_STRING);

        $content = ScorecardContent::where('scorecard_id',$scorecard_id)
        ->where('row_position',$row_position)
        ->where('column_position',$column_position)
        ->first();

        $prev = ScorecardContent::where('scorecard_id',$scorecard_id)
        ->where('row_position',$row_position-1)
        ->where('column_position',$column_position)
        ->first();

        if($prev){
            if($content->content == $prev->content)
            {
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            return FALSE;
        }
    }

    function scorecardContentBaseOnRowAndColumnPosition($scorecard_id,$row_position,$column_position)
    {
        $scorecard_id = filter_var($scorecard_id, FILTER_SANITIZE_STRING);
        $row_position = filter_var($row_position, FILTER_SANITIZE_STRING);
        $column_position = filter_var($column_position, FILTER_SANITIZE_STRING);

        $content = ScorecardContent::where('scorecard_id',$scorecard_id)
        ->where('row_position',$row_position)
        ->where('column_position',$column_position)
        ->first();
        
        return $content;
    }

    function scorecardContentBaseonColumn($scorecard_id,$column_position)
    {
        $scorecard_id = filter_var($scorecard_id, FILTER_SANITIZE_STRING);
        $column_position = filter_var($column_position, FILTER_SANITIZE_STRING);
    
        $content = ScorecardColumn::where('scorecard_id',$scorecard_id)
        ->where('column_position',$column_position)
        ->first();
        
        return $content;
    }


    /**
     * 
     * THIS IS USE IN GENERATING OF CARDS
     */

     public function checkTemplateIfHasContent($templateId){
         return TemplateContent::where('template_id',$templateId)->first();
     }
}



