<?php

namespace App\helpers;

use Auth;
use App\User;
use App\Role;

use App\v2\Template;
use App\v2\TemplateColumn;
use App\v2\TemplateContent;

use App\v2\Scorecard;
use App\v2\ScorecardColumn;
use App\v2\ScorecardContent;


class ScoreCardHelper {

    public function __construct()
    {
       
    }

   public function unAcknowledgeCountPerRole($roleId)
   {
    $this->role_id = $roleId;

    if(Auth::user()->isSupervisor())
    {
        $unAcknowledge = Scorecard::where('is_acknowledge',0)
        ->whereHas('theuser', function($q){
            $q->where('role_id', $this->role_id)
            ->where('supervisor', Auth::user()->id);
        })
        ->where('is_deleted',0)
        ->get();

        if(count($unAcknowledge) <= 0)
        {   
            $unAcknowledge = Scorecard::where('is_acknowledge',0)
            ->whereHas('theuser', function($q){
                $q->where('role_id', $this->role_id)
                ->where('user_id', Auth::user()->id);
            })
            ->where('is_deleted',0)
            ->get();
        }
    }
    else
    {
        $unAcknowledge = Scorecard::where('is_acknowledge',0)
        ->whereHas('theuser', function($q){
            $q->where('role_id', $this->role_id);
        })
        ->where('is_deleted',0)
        ->get();
    }
    
    

    return $unAcknowledge;
   }


   function whosTheUser($user_id)
   {
     $user =User::where('id',$user_id)->first();
     
     if($user)
     {
         return $user;
     }
     return [];
   }



}



