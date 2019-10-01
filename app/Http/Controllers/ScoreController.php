<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Scorecard\Agent as agentScoreCard;

class ScoreController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('scores.list');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function tlScore(Request $request)
    {
        return __FUNCTION__;
    }

    public function agentScore(Request $request)
    {
        
        $agents = User::where('role','agent')->orderBy('name','ASC')->get();

        //Agent
        if(Auth::user()->isAgent()){
            $avail_months = agentScoreCard::where('agent_id',Auth::user()->id)
            ->groupBy('month')->get();
        
        //Supervisor view Only his/her Team
        }elseif(Auth::user()->isSupervisor())
        {   $avail_months = agentScoreCard::whereHas('theagent', function($q){
                $q->where('supervisor',Auth::user()->id);
            })->groupBy('month')->get();
        
        //Manager view Only his/her Team       
        }elseif(Auth::user()->isManager()){
            $avail_months = agentScoreCard::whereHas('theagent', function($q){
                $q->where('manager',Auth::user()->id);
            })->groupBy('month')->get();
        
            
        }else{
            $avail_months = agentScoreCard::groupBy('month')->get();
        }


        //VIEW NOT-ACKNOWLEDGE BY
        if( $request->has('not_acknowledge') || $request->filled('not_acknowledge') )
        {
            $scores = agentScoreCard::where('acknowledge',0);
            
            //Agent
            if(Auth::user()->isAgent()){
                $scores->where('agent_id',Auth::user()->id);
            }
            //Supervisor
            elseif(Auth::user()->isSupervisor()){
                // $scores->where('supervisor',Auth::user()->id);
                // $scores->whereHas('theagent', function($q){
                //     $q->where('supervisor',Auth::user()->id);
                // });
                $scores->agentsuperior('supervisor',Auth::user()->id);
            
            }//Manager
            elseif(Auth::user()->isManager()){
                $scores->agentsuperior('manager',Auth::user()->id);
            }

            $scores = $scores->get();

        //VIEW ACKNOWLEDGE BY
        }elseif( $request->has('acknowledge') || $request->filled('acknowledge') )
        {
            $scores = agentScoreCard::where('acknowledge',1);
            
            //Agent
            if(Auth::user()->isAgent()){
                $scores->where('agent_id',Auth::user()->id);
            }//Supervisor
            elseif(Auth::user()->isSupervisor()){
                $scores->agentsuperior('supervisor',Auth::user()->id);
            }//Manager
            elseif(Auth::user()->isManager()){
                $scores->agentsuperior('manager',Auth::user()->id);
            }

            $scores = $scores->get();
        
        //FILTER BY MONTH 
        }elseif( $request->has('filter_month') && $request->filled('filter_month') )
        {
            $scores = agentScoreCard::where('month',$request['filter_month']);
            
            //Agent
            if(Auth::user()->isAgent()){
                $scores->where('agent_id',Auth::user()->id);
            }//Supervisor
            elseif(Auth::user()->isSupervisor()){
                $scores->agentsuperior('supervisor',Auth::user()->id);
            }//Manager
            elseif(Auth::user()->isManager()){
                $scores->agentsuperior('manager',Auth::user()->id);
            }
            $scores = $scores->get();
        
        //VIEW ALL
        }elseif( $request->has('view_all') || $request->filled('view_all') )
        {
            // $scores = agentScoreCard::get();
            
            //Agent
            if(Auth::user()->isAgent()){
                $scores = agentScoreCard::where('agent_id',Auth::user()->id)->get();
            }//Supervisor
            elseif(Auth::user()->isSupervisor()){
                $scores = agentScoreCard::agentsuperior('supervisor',Auth::user()->id)
                ->get();
            }//Manager
            elseif(Auth::user()->isManager()){
                $scores = agentScoreCard::agentsuperior('manager',Auth::user()->id)
                ->get();
            }else{
                $scores = agentScoreCard::get();
            }

        //DEFAULT MONTH NOW    
        }else{
            $scores = agentScoreCard::where('month',Carbon::now()->format('M Y'));

            //Agent
            if(Auth::user()->isAgent()){
                $scores->where('agent_id',Auth::user()->id);
            }//Supervisor
            elseif(Auth::user()->isSupervisor()){
                $scores->agentsuperior('supervisor',Auth::user()->id);
            }//Manager
            elseif(Auth::user()->isManager()){
                $scores->agentsuperior('manager',Auth::user()->id);
            }
            $scores =  $scores->get();
        }

       
        

        return view('scores.agents.list',compact('agents','scores','avail_months'));
    }

    public function addAgentScore(Request $request)
    {
        $this->validate($request,
        [
            'agent_id'       => 'required',
            'month'       => 'required',
            'target'       => 'required',
            'actual_quality'       => 'required|numeric',
            'actual_productivity'       => 'required|numeric',
            'actual_reliability'       => 'required|numeric',
            'quality'       => 'required|numeric',
            'productivity'       => 'required|numeric',
            'reliability'       => 'required|numeric',
            'final_score'       => 'required|numeric'
          
        ],
            $messages = array('agent_id.required' => 'Agent is Required!')
        );

        // $request['month'] = $request['month'] . " 00:00:00";
       
        $agent = agentScoreCard::create($request->all());
        return redirect()->back()->with('with_success', 'Scorecard created succesfully!'); 
    }

    public function editAgentScore($id)
    {
        $agents = User::where('role','agent')->orderBy('name','ASC')->get();
        $score = agentScoreCard::findorfail($id);
        return view('scores.agents.edit',compact('agents','score'));
    }

    public function updateAgentScore(Request $request, $id)
    {
        $this->validate($request,
        [
            'agent_id'       => 'required',
            'month'       => 'required',
            'target'       => 'required',
            'actual_quality'       => 'required|numeric',
            'actual_productivity'       => 'required|numeric',
            'actual_reliability'       => 'required|numeric',
            'quality'       => 'required|numeric',
            'productivity'       => 'required|numeric',
            'reliability'       => 'required|numeric',
            'final_score'       => 'required|numeric'
          
        ],
            $messages = array('agent_id.required' => 'Agent is Required!')
        );
        
        $score = agentScoreCard::findorfail($id);
        $score->update($request->all());

        return redirect()->back()->with('with_success', 'Scorecard updated succesfully!'); 
    }

    public function deleteAgentScore($id)
    {
        $score = agentScoreCard::findorfail($id);
        $score->delete();
        return redirect()->back()->with('with_success', 'Scorecard was Deleted succesfully!');   
    }

    public function showAgentScore($id)
    {
        $score = agentScoreCard::findorfail($id);

        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isSupervisor() && !Auth::user()->isManager() && Auth::user()->id <> $score->agent_id)
        {
            return view('notifications.401'); 
        }
          

        $score = agentScoreCard::findorfail($id);
      return view('scores.agents.score_card',compact('score'));
    }

    public function printAgentScore($id)
    {
        $score = agentScoreCard::findorfail($id);
        
        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isSupervisor() && !Auth::user()->isManager() && Auth::user()->id <> $score->agent_id)
        {
            return view('notifications.401'); 
        }

      return view('scores.agents.score_print',compact('score'));
    }

    public function agentFeedback(Request $request, $id)
    {
        $this->validate($request,
        [
            'agent_feedback'       => 'required',
        ],
            $messages = array('agent_feedback.required' => 'Agent Feedback is Required!')
        );
        
        $score = agentScoreCard::findorfail($id);
        $score->update(['agent_feedback'=> $request['agent_feedback']]);

        return redirect()->back()->with('with_success', 'Feedback Succesfully Added!'); 
    }

    public function agentActionPlan(Request $request, $id)
    {
        $this->validate($request,
        [
            'action_plan'       => 'required',
        ],
            $messages = array('action_plan.required' => 'Action Plan Feedback is Required!')
        );
        
        $score = agentScoreCard::findorfail($id);
        $score->update(['action_plan'=> $request['action_plan']]);

        return redirect()->back()->with('with_success', 'Action Plan Succesfully Added!'); 
    }

    public function acknowledgeScore(Request $request, $id)
    {
        $score = agentScoreCard::findorfail($id);
        $score->update(['acknowledge'=> 1]);

        return redirect()->back()->with('with_success', 'Scorecard Acknowledged Succesfully!'); 
    }

   

    
}
