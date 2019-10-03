<?php


use App\Scorecard\Agent as agentScoreCard;
use App\Scorecard\tl as TLScoreCard;

//Self: Agent
function agentHasUnAcknowledgeCard()
{
    return agentScoreCard::agentdetails( Auth::user()->id )->where('acknowledge',0)->count();
}

//Self: TL
function tlHasUnAcknowledgeCard()
{
    return TLScoreCard::tldetails( Auth::user()->id )->where('acknowledge',0)->count();
}

//Team: TL / Manager, Agent members
function memberUnacknowledgeCard($position)
{
    return agentScoreCard::where('acknowledge',0)
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
    return agentScoreCard::where('acknowledge',0)->count();
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