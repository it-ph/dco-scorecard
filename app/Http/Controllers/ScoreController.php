<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Scorecard\Agent as agentScoreCard;
use App\Scorecard\tl as TLScoreCard;

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


    /** 
    *
    *
    * TL SCORECARD
    *
    **/
    public function tlScore(Request $request)
    {
        $this->userId = Auth::user()->id;
        
        //VIEW ALL AGENT (FOR CREATE CARD)
        $tls = User::where('role','supervisor')->orderBy('name','ASC')->get();

        //FILTER BY NOT-ACKNOWLEDGE
        if( $request->has('not_acknowledge') || $request->filled('not_acknowledge') )
        {
            $scores = TLScoreCard::where('acknowledge',0);
            
        //FILTER BY ACKNOWLEDGE
        }elseif( $request->has('acknowledge') || $request->filled('acknowledge') )
        {
            $scores = TLScoreCard::where('acknowledge',1);
            
        //FILTER BY MONTH 
        }elseif( $request->has('filter_month') && $request->filled('filter_month') )
        {
            $scores = TLScoreCard::where('month',$request['filter_month']);
            
        //VIEW ALL
        }elseif( $request->has('view_all') || $request->filled('view_all') )
        {
            $scores = TLScoreCard::orderBy('id','desc');
            
        //DEFAULT MONTH NOW    
        }else{
            $scores = TLScoreCard::where('month',Carbon::now()->format('M Y'));
        }
    

        $avail_months = TLScoreCard::month();

        //TL
        if(Auth::user()->isSupervisor()){
            $scores->tldetails( $this->userId );
            $avail_months = TLScoreCard::tldetails( $this->userId )
            ->month();
        }
        //Manager
        elseif(Auth::user()->isManager()){
            $scores->agentsuperior('manager',$this->userId);
            $avail_months =  TLScoreCard::agentsuperior('manager',$this->userId)
            ->month();
        }

        $scores = $scores->get();
        $avail_months = $avail_months->get();

       return view('scores.tl.list',compact('tls','scores','avail_months'));
    }

    public function addTLScore(Request $request)
    {
        $this->validate($request,
        [
            'tl_id'       => 'required',
            'month'       => 'required',
            'target'       => 'required',
            'actual_quality'       => 'required|numeric',
            'quality'       => 'required|numeric',
            'actual_productivity'       => 'required|numeric',
            'productivity'       => 'required|numeric',
            'actual_admin_coaching'       => 'required',
            'admin_coaching'       => 'required|numeric',
            'actual_team_performance'    => 'required|numeric',
            'team_performance'       => 'required|numeric',
            'actual_initiative'    => 'required',
            'initiative'       => 'required|numeric',
            'actual_team_attendance'    => 'required|numeric',
            'team_attendance'       => 'required|numeric',
            'final_score'       => 'required|numeric'
           
          
        ],
            $messages = array('tl_id.required' => 'Team Leader is Required!')
        );

        // $request['month'] = $request['month'] . " 00:00:00";
       
        $tl = TLScoreCard::create($request->all());
        return redirect()->back()->with('with_success', 'Scorecard created succesfully!'); 
    }

    public function editTLScore($id)
    {
        $tls = User::where('role','supervisor')->orderBy('name','ASC')->get();
        $score = TLScoreCard::findorfail($id);
        return view('scores.tl.edit',compact('tls','score'));
    }

    public function updateTLScore(Request $request, $id)
    {
        $this->validate($request,
        [
            'tl_id'       => 'required',
            'month'       => 'required',
            'target'       => 'required',
            'actual_quality'       => 'required|numeric',
            'quality'       => 'required|numeric',
            'actual_productivity'       => 'required|numeric',
            'productivity'       => 'required|numeric',
            'actual_admin_coaching'       => 'required',
            'admin_coaching'       => 'required|numeric',
            'actual_team_performance'    => 'required|numeric',
            'team_performance'       => 'required|numeric',
            'actual_initiative'    => 'required',
            'initiative'       => 'required|numeric',
            'actual_team_attendance'    => 'required|numeric',
            'team_attendance'       => 'required|numeric',
            'final_score'       => 'required|numeric'
           
          
        ],
            $messages = array('tl_id.required' => 'Agent is Required!')
        );
        
        $score = TLScoreCard::findorfail($id);
        $score->update($request->all());

        return redirect()->back()->with('with_success', 'Scorecard updated succesfully!'); 
    }

    public function deleteTLScore($id)
    {
        $score = TLScoreCard::findorfail($id);
        $score->delete();
        return redirect()->back()->with('with_success', 'Scorecard was Deleted succesfully!');   
    }

    public function showTLScore($id)
    {
        $score = TLScoreCard::findorfail($id);

        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isSupervisor() && !Auth::user()->isManager() && Auth::user()->id <> $score->tl_id)
        {
            return view('notifications.401'); 
        }
          
        return view('scores.tl.score_card',compact('score'));
    }

    public function tlFeedback(Request $request, $id)
    {
        $this->validate($request,
        [
            'feedback'       => 'required',
        ],
            $messages = array('feedback.required' => 'Agent Feedback is Required!')
        );
        
        $score = TLScoreCard::findorfail($id);
        $score->update(['feedback'=> $request['feedback']]);

        return redirect()->back()->with('with_success', 'Feedback Succesfully Added!'); 
    }

    public function tlActionPlan(Request $request, $id)
    {
        $this->validate($request,
        [
            'action_plan'       => 'required',
        ],
            $messages = array('action_plan.required' => 'Action Plan Feedback is Required!')
        );
        
        $score = TLScoreCard::findorfail($id);
        $score->update(['action_plan'=> $request['action_plan']]);

        return redirect()->back()->with('with_success', 'Action Plan Succesfully Added!'); 
    }

    public function acknowledgeScoreTL(Request $request, $id)
    {
        $score = TLScoreCard::findorfail($id);
        $score->update(['acknowledge'=> 1]);

        return redirect()->back()->with('with_success', 'Scorecard Acknowledged Succesfully!'); 
    }



    /** 
    *
    *
    * AGENT SCORECARD
    *
    **/
    public function agentScore(Request $request)
    {
        $this->userId = Auth::user()->id;
        
        //VIEW ALL AGENT (FOR CREATE CARD)
        $agents = User::where('role','agent')->orderBy('name','ASC')->get();

        //FILTER BY NOT-ACKNOWLEDGE
        if( $request->has('not_acknowledge') || $request->filled('not_acknowledge') )
        {
            $scores = agentScoreCard::where('acknowledge',0);
            
        //FILTER BY ACKNOWLEDGE
        }elseif( $request->has('acknowledge') || $request->filled('acknowledge') )
        {
            $scores = agentScoreCard::where('acknowledge',1);
            
        //FILTER BY MONTH 
        }elseif( $request->has('filter_month') && $request->filled('filter_month') )
        {
            $scores = agentScoreCard::where('month',$request['filter_month']);
            
        //VIEW ALL
        }elseif( $request->has('view_all') || $request->filled('view_all') )
        {
            $scores = agentScoreCard::orderBy('id','desc');
            
        //DEFAULT MONTH NOW    
        }else{
            $scores = agentScoreCard::where('month',Carbon::now()->format('M Y'));
        }
    

        $avail_months = agentScoreCard::month();

        //Agent
        if(Auth::user()->isAgent()){
            $scores->agentdetails( $this->userId );
            $avail_months = agentScoreCard::agentdetails( $this->userId )
            ->month();
        }
        //Supervisor
        elseif(Auth::user()->isSupervisor()){
            $scores->agentsuperior('supervisor',$this->userId);
            $avail_months =  agentScoreCard::agentsuperior('supervisor',$this->userId)
            ->month();
        
        }//Manager
        elseif(Auth::user()->isManager()){
            $scores->agentsuperior('manager',$this->userId);
            $avail_months =  agentScoreCard::agentsuperior('manager',$this->userId)
            ->month();
        }

        $scores = $scores->get();
        $avail_months = $avail_months->get();

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
