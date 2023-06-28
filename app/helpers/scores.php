<?php


use App\Scorecard\Agent as agentScoreCard;
use App\Scorecard\tl as TLScoreCard;

//Self: Agent
function agentHasUnAcknowledgeCard()
{
    return agentScoreCard::agentdetails( Auth::user()->id )->where('acknowledge_by_agent',0)->count();
}

//Self: TL
function tlHasUnAcknowledgeCard()
{
    return TLScoreCard::tldetails( Auth::user()->id )->where('acknowledge',0)->count();
}

//Team: TL / Manager, Agent members
function memberUnacknowledgeCard($position)
{
    return agentScoreCard::where('acknowledge_by_tl',0)
    ->agentsuperior($position,Auth::user()->id)
   ->count();
}

//Team: Manager, TL members
function memberTLUnacknowledgeCard()
{
    return TLScoreCard::where('acknowledge',0)
    ->Tlsuperior('manager',Auth::user()->id)
   ->count();
}



//All: Agent
function allAgentUnacknowledgeCard()
{
    return agentScoreCard::where('acknowledge_by_agent',0)->count();
}

//All: TL
function allTLUnacknowledgeCard()
{
    return TLScoreCard::where('acknowledge',0)->count();
}

function allUnAcknowledgeCard()
{
    $agent = agentScoreCard::where('acknowledge',0)->count();
    $tl = TLScoreCard::where('acknowledge',0)->count();

    return ($agent + $tl);
}

// function getAgentScore($agent_id, $month)
// {
//     $agent_score = agentScoreCard::where('agent_id', $agent_id)->where('month', $month)->value('final_score');

//     $agent_score = $agent_score <> null ? number_format($agent_score, 2) : '';

//     return $agent_score;
// }

function getAgentScore($agent_id, $month, $period)
{
    $agent_score = agentScoreCard::query()
        ->where('agent_id', $agent_id)
        ->where('month_type',$period)
        ->where('month', $month)
        // ->select('quality','productivity','actual_reliability','final_score') //implement new quality performance range july 20, 2022
        ->select('actual_quality','productivity','actual_reliability','final_score')
        ->first();

    if($agent_score)
    {
        // $score_quality = $agent_score->quality; //implement new quality performance range july 20, 2022
        $score_quality = getAgentQualityScore($agent_score->actual_quality);
        $score_productivity = $agent_score->productivity;
        $score_reliability = getAgentReliabilityScore($agent_score->actual_reliability);
        $agent_score = $score_quality + $score_productivity + $score_reliability;

        $agent_score = $agent_score <> null ? number_format($agent_score, 2) : '';

        return $agent_score;
    }
    else
    {
        return '';
    }

}

function getTlScore($tl_id, $month)
{
    $tl_score = TLScoreCard::query()
        ->where('tl_id', $tl_id)
        ->where('month', $month)
        ->select('final_score')
        ->first();

    if($tl_score)
    {
        $tlscores = $tl_score->final_score <> null ? number_format($tl_score->final_score, 2) : '';

        return $tlscores;
    }
    else
    {
        return '';
    }

}

function removeBraces($val)
{
    $a =  str_replace('["',"",$val);
    $b = str_replace('"]',"",$a);

    return $b;
}

function getAgentQualityScore($score)
{
    if($score < 80)
    {
        $score = 0;
    }
    elseif($score >= 80 && $score <= 84.99)
    {
        $score = 10;
    }
    elseif($score >= 85 && $score <= 89.99)
    {
        $score = 20;
    }
    elseif($score >= 90 && $score <= 94.99)
    {
        $score = 30;
    }
    elseif($score >= 95)
    {
        $score = 40;
    }

    return $score;
}

function getAgentProductivityScore($score)
{
    if($score < 80)
    {
        $score = 0;
    }
    elseif($score >= 80 && $score <= 89)
    {
        $score = 10;
    }
    elseif($score >= 90 && $score <= 99)
    {
        $score = 20;
    }
    elseif($score >= 100)
    {
        $score = 40;
    }

    return $score;
}

function getAgentReliabilityScore($score)
{
    if($score < 80)
    {
        $score = 0;
    }
    elseif($score >= 80 && $score <= 84)
    {
        $score = 5;
    }
    elseif($score >= 85 && $score <= 89)
    {
        $score = 10;
    }
    elseif($score >= 90 && $score <= 94)
    {
        $score = 15;
    }
    elseif($score >= 95)
    {
        $score = 20;
    }

    return $score;
}


function getTlReliabilityScore($score)
{
    if($score < 85)
    {
        $score = 0;
    }
    elseif($score >= 85 && $score <= 95)
    {
        $score = 5;
    }
    elseif($score >= 90 && $score <= 95)
    {
        $score = 7;
    }
    elseif($score >= 95)
    {
        $score = 10;
    }

    return $score;
}
