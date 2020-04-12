<?php

namespace App\helpers;

use Auth;
use App\v2\Template;
use App\v2\TemplateColumn;
use App\v2\TemplateContent;

use App\v2\Scorecard;
use App\v2\ScorecardColumn;
use App\v2\ScorecardContent;


class HomeQueries {

    public function __construct($request)
    {
        $this->req = $request;
    }

    function adminGraphs()
    {
        if($this->req->has('search_year') && $this->req->filled('search_year') && 
            $this->req->has('user_id') && $this->req->filled('user_id'))
        {
            $scores = Scorecard::where('year',$this->req['search_year'])
            ->where('user_id', $this->req['user_id'])
            ->orderBy('month_numerical_value','ASC')
            ->where('is_deleted',0)
            ->get();
        }else{
            $scores = [];
        }

        return $scores;
    }


    function availableYearInScorecard()
    {
        $avail_year_in_scorecard = Scorecard::groupBy('year')
            ->orderBy('month_numerical_value','ASC')
            ->where('is_deleted',0)
            ->get();

        return $avail_year_in_scorecard;
    }

    function adminUnAcknowledgeList()
    {
        $unAcknowledge = Scorecard::where('is_acknowledge',0)
        ->where('is_deleted',0)
        ->get();

        return $unAcknowledge;
    }

    function unAcknowledgeListForSupervisor()
    {
        $arr = [];
        $unAcknowledge_member = Scorecard::where('is_acknowledge',0)
        ->whereHas('theuser', function($q){
            $q->where('supervisor', Auth::user()->id)
            ->orderBy('name', 'ASC');
        })
        ->where('is_deleted',0)
        ->get();


        $unAcknowledge_sup = Scorecard::where('is_acknowledge',0)
        ->whereHas('theuser', function($q){
            $q->where('user_id', Auth::user()->id);
        })
        ->where('is_deleted',0)
        ->get();

        $unAcknowledge = array_merge($unAcknowledge_member->toArray(),$unAcknowledge_sup->toArray()) ;
        return $unAcknowledge;
    }


    function scorecardUsers()
    {
        $users = Scorecard::groupBy('user_id')
        ->whereHas('theuser', function($q){
            $q->orderBy('name', 'ASC');
        })
        ->where('is_deleted',0)
        ->get();

        return $users;
    }

    function scorecardUsersForSupervisor()
    {
        $users = Scorecard::groupBy('user_id')
        ->whereHas('theuser', function($q){
            $q->where('supervisor', Auth::user()->id)
            ->orderBy('name', 'ASC');
        })
        ->where('is_deleted',0)
        ->get();

        return $users;
    }


    function lastScoreCard()
    {
        $scores = Scorecard::where('user_id', Auth::user()->id)
        ->orderBy('month_numerical_value','ASC')
        ->where('is_deleted',0)
        ->get();

        return  $last_score_card_score =  ($scores) ?  $scores->last() : [] ;
    }
}



