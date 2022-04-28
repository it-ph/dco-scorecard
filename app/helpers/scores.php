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

function getAgentScore($agent_id, $month)
{
    $agent_score = agentScoreCard::where('agent_id', $agent_id)->where('month', $month)->value('final_score');
    $agent_score = $agent_score <> null ? number_format($agent_score, 2) : '';

    return $agent_score;
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
    elseif($score >= 80 && $score <= 84)
    {
        $score = 15;
    }
    elseif($score >= 85 && $score <= 94)
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
