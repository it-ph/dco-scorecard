<?php

namespace App\Http\Controllers;

use Auth;

use App\User;
use App\Setting;
use App\Signature;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Scorecard\tl as TLScoreCard;
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
        $scores = TLScoreCard::select('id','tl_id','month',
                                    'target','quality','productivity','no_client_escalations',
                                    'no_pay_dispute','linkedin_learning_compliance','eod_reporting','htl_compliance','other_compliances_required','reliability',
                                    'final_score','acknowledge','acknowledge_by_tl','date_acknowledge_by_tl','tl_signature_id',
                                    'acknowledge_by_manager','date_acknowledge_by_manager','manager_signature_id','new_manager_id','acknowledge_by_towerhead','date_acknowledge_by_towerhead',
                                    'towerhead_signature_id','created_at','updated_at');


        //FILTER BY NOT-ACKNOWLEDGE
        if( $request->has('not_acknowledge') || $request->filled('not_acknowledge') )
        {
            $scores = $scores->where('acknowledge',0);

        //FILTER BY ACKNOWLEDGE
        }elseif( $request->has('acknowledge') || $request->filled('acknowledge') )
        {
            $scores = $scores->where('acknowledge',1);

        //FILTER BY MONTH
        }elseif( $request->has('filter_month') && $request->filled('filter_month') )
        {
            $scores = $scores->where('month',$request['filter_month']);

        //VIEW ALL
        }elseif( $request->has('view_all') || $request->filled('view_all') )
        {
            $scores = $scores->orderBy('id','desc');

        //DEFAULT MONTH NOW
        }else{
            $scores = $scores->where('month',Carbon::now()->format('M Y'));
        }


        $avail_months = TLScoreCard::month()->select('id','tl_id','month',
                                    'target','quality','productivity','no_client_escalations',
                                    'no_pay_dispute','linkedin_learning_compliance','eod_reporting','htl_compliance','other_compliances_required','reliability',
                                    'final_score','acknowledge','acknowledge_by_tl','date_acknowledge_by_tl','tl_signature_id',
                                    'acknowledge_by_manager','date_acknowledge_by_manager','manager_signature_id','new_manager_id','acknowledge_by_towerhead','date_acknowledge_by_towerhead',
                                    'towerhead_signature_id','created_at','updated_at');

        //TL
        if(Auth::user()->isSupervisor()){
            $scores->tldetails( $this->userId );
            $avail_months = TLScoreCard::tldetails( $this->userId )
            ->month();
        }
        //Manager
        elseif(Auth::user()->isManager()){

            $scores->tlsuperior('manager',$this->userId)->get();
            $avail_months =    TLScoreCard::tlsuperior('manager',$this->userId)->month();
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
            'quality'       => 'required|numeric',
            'productivity'       => 'required|numeric',
            'no_client_escalations'       => 'required|numeric',
            'no_pay_dispute'       => 'required|numeric',
            'linkedin_learning_compliance'       => 'required|numeric',
            'eod_reporting'       => 'required|numeric',
            'htl_compliance'       => 'required|numeric',
            'other_compliances_required'       => 'required|numeric',
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
            'quality'       => 'required|numeric',
            'productivity'       => 'required|numeric',
            'no_client_escalations'       => 'required|numeric',
            'no_pay_dispute'       => 'required|numeric',
            'linkedin_learning_compliance'       => 'required|numeric',
            'eod_reporting'       => 'required|numeric',
            'htl_compliance'       => 'required|numeric',
            'other_compliances_required'       => 'required|numeric',
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
        $score = TLScoreCard::with('thenewManager')->findorfail($id);
        $towerhead = Setting::where('setting','towerhead')->first();

        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isManager() && !Auth::user()->isCBAOrTowerHead() && Auth::user()->id <> $score->tl_id)
        {
            return view('notifications.401');
        }

        return view('scores.tl.score_card',compact('score','towerhead'));
    }

    public function printTLScore ($id)
    {
        $score = TLScoreCard::findorfail($id);
        $towerhead = Setting::where('setting','towerhead')->first();

        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isSupervisor() && !Auth::user()->isManager() && !Auth::user()->isCBAOrTowerHead() && Auth::user()->id <> $score->tl_id)
        {
            return view('notifications.401');
        }

      return view('scores.tl.score_print',compact('score','towerhead'));
    }

    public function tlFeedback(Request $request, $id)
    {
        $this->validate($request,
        [
            'feedback'       => 'required',
        ],
            $messages = array('feedback.required' => 'TL Feedback is Required!')
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

    public function acknowledgeScoreTL($id)
    {

        $default_signature = Signature::where('user_id',Auth::user()->id)->where('is_default',1)->first();
        
        if($default_signature){
            $signatureid = $default_signature->id;
        }else{
            return redirect()->back()->withErrors(['msg' => 'Kindly manage your signature first']);
            
        }

        $score = TLScoreCard::findorfail($id);
        // Acknowledged by Supervisor
        if(Auth::user()->isSupervisor() || Auth::user()->isAdmin())
        {
            $score->update([
                'acknowledge_by_tl' => 1,
                'tl_signature_id' => $signatureid,
                'date_acknowledge_by_tl' => Carbon::now()
            ]);
        }
        // Acknowledged by Manager
        elseif(Auth::user()->isManager() || Auth::user()->isAdmin())
        {
            $score->update([
                'acknowledge_by_manager' => 1,
                'manager_signature_id' => $signatureid,
                'new_manager_id' => Auth::user()->id,
                'date_acknowledge_by_manager' => Carbon::now()
            ]);
        }
        // Acknowledged by TowerHead
        elseif(Auth::user()->isCBAOrTowerHead() || Auth::user()->isAdmin())
        {
            $score->update([
                'acknowledge_by_towerhead' => 1,
                'towerhead_signature_id' => $default_signature->id,
                'date_acknowledge_by_towerhead' => Carbon::now()
            ]);
        }


        if($score->acknowledge_by_tl == 1 && $score->acknowledge_by_manager == 1 && $score->acknowledge_by_towerhead == 1)
        {
            $score->update(['acknowledge'=> 1]);
        }

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
        $scores = agentScoreCard::select('id','agent_id','month_type','month',
                                    'target','actual_quality','actual_productivity','actual_reliability',
                                    'quality','productivity','reliability','final_score','acknowledge','acknowledge_by_agent',
                                    'agent_signature_id','date_acknowledge_by_agent','acknowledge_by_tl','tl_signature_id','new_tl_id',
                                    'date_acknowledge_by_tl','acknowledge_by_manager','manager_signature_id','new_manager_id','date_acknowledge_by_manager',
                                    'created_at','updated_at');

        //FILTER BY NOT-ACKNOWLEDGE
        if( $request->has('not_acknowledge') || $request->filled('not_acknowledge') )
        {
            //Agent
            if (Auth::user()->isAgent()) {
                $scores = $scores->where('acknowledge_by_agent', 0);
            }
                                        
            //Supervisor
            elseif(Auth::user()->isSupervisor()){
                $scores = $scores->where('acknowledge_by_agent', 1)->where('acknowledge_by_tl',0);
            }
            //Manager
            elseif(Auth::user()->isManager()){
                $scores = $scores->where('acknowledge_by_agent', 1)->where('acknowledge_by_tl', 1)->where('acknowledge_by_manager', 0);
            }
            else
            {
                $scores = $scores->where('acknowledge_by_agent', 0)->Orwhere('acknowledge_by_tl', 0)->Orwhere('acknowledge_by_manager', 0);
            }

        //FILTER BY ACKNOWLEDGE
        }elseif( $request->has('acknowledge') || $request->filled('acknowledge') )
        {
            // $scores = agentScoreCard::where('acknowledge',1);
            //Agent
            if (Auth::user()->isAgent()) {
                $scores = $scores->where('acknowledge_by_agent', 1);
            }
            //Supervisor
            elseif(Auth::user()->isSupervisor()){
                $scores = $scores->where('acknowledge_by_tl',1);
            }
            //Manager
            elseif(Auth::user()->isManager()){
                $scores = $scores->where('acknowledge_by_manager', 1);
            }
            else
            {
                $scores = $scores->where('acknowledge_by_agent', 1)->Orwhere('acknowledge_by_tl', 1)->Orwhere('acknowledge_by_manager', 1);
            }

        //FILTER BY MONTH
        }elseif( $request->has('filter_month') && $request->filled('filter_month') )
        {
            $scores = $scores->where('month',$request['filter_month']);

        //VIEW ALL
        }elseif( $request->has('view_all') || $request->filled('view_all') )
        {
            $scores = $scores->orderBy('id','desc');

        //DEFAULT MONTH NOW
        }else{
            $scores = $scores->where('month',Carbon::now()->format('M Y'));
        }

        $avail_months = agentScoreCard::month()->select('id','agent_id','month_type','month',
                                                'target','actual_quality','actual_productivity','actual_reliability',
                                                'quality','productivity','reliability','final_score','acknowledge','acknowledge_by_agent',
                                                'agent_signature_id','date_acknowledge_by_agent','acknowledge_by_tl','tl_signature_id','new_tl_id',
                                                'date_acknowledge_by_tl','acknowledge_by_manager','manager_signature_id','new_manager_id','date_acknowledge_by_manager',
                                                'created_at','updated_at');

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

        $target = Setting::where('setting','target')->first();
        $quality = Setting::where('setting','quality')->first();
        $productivity = Setting::where('setting','productivity')->first();
        $reliability = Setting::where('setting','reliability')->first();

        return view('scores.agents.list',compact('agents','scores','avail_months','target','quality','productivity','reliability'));
    }

    public function addAgentScore(Request $request)
    {
        $this->validate($request,
        [
            'agent_id'       => 'required',
            'month_type'       => 'required',
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

        // $agent = agentScoreCard::create($request->all());
        agentScoreCard::updateOrCreate(
            [
                'agent_id' => $request['agent_id'],
                'month_type' => $request['month_type'],
                'month' => $request['month'],
            ],
            [
                'target' => $request['target'],
                'actual_productivity' => $request['actual_productivity'],
                'actual_quality' => $request['actual_quality'],
                'actual_reliability' => $request['actual_reliability'],
                'productivity' => $request['productivity'],
                'quality' => $request['quality'],
                'reliability' => $request['reliability'],
                'final_score' => $request['final_score'],
                'acknowledge_by_agent' => 0,
                'date_acknowledge_by_agent' => null,
                'acknowledge_by_tl' => 0,
                'date_acknowledge_by_tl' => null,
                'acknowledge_by_manager' => 0,
                'date_acknowledge_by_manager' => null,
            ]
        );

        return redirect()->back()->with('with_success', 'Scorecard created succesfully!');
    }

    public function editAgentScore($id)
    {
        $agents = User::where('role','agent')->orderBy('name','ASC')->get();
        $score = agentScoreCard::findorfail($id);

        $target = Setting::where('setting','target')->first();
        $quality = Setting::where('setting','quality')->first();
        $productivity = Setting::where('setting','productivity')->first();
        $reliability = Setting::where('setting','reliability')->first();

        return view('scores.agents.edit',compact('agents','score','target','quality','productivity','reliability'));
    }

    public function updateAgentScore(Request $request, $id)
    {
        $this->validate($request,
        [
            'agent_id'       => 'required',
            'month_type'       => 'required',
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
        $score = agentScoreCard::with('thenewTl','thenewManager')->findorfail($id);
        $towerhead = Setting::where('setting','towerhead')->first();
        $productivity = Setting::where('setting','productivity')->first();
        $quality = Setting::where('setting','quality')->first();
        $reliability = Setting::where('setting','reliability')->first();

        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isCBAOrTowerHead() && !Auth::user()->isSupervisor() && !Auth::user()->isManager() && Auth::user()->id <> $score->agent_id)
        {
            return view('notifications.401');
        }


      return view('scores.agents.score_card',compact('score','towerhead','productivity','quality','reliability'));
    }

    public function printAgentScore($id)
    {
        $score = agentScoreCard::with('thenewTl','thenewManager')->findorfail($id);
        $towerhead = Setting::where('setting','towerhead')->first();

        //check if Not admin or not his/her scorecard
        if(!Auth::user()->isAdmin() && !Auth::user()->isCBAOrTowerHead() && !Auth::user()->isSupervisor() && !Auth::user()->isManager() && Auth::user()->id <> $score->agent_id)
        {
            return view('notifications.401');
        }

      return view('scores.agents.score_print',compact('score','towerhead'));
    }

    public function agentFeedback(Request $request, $id)
    {
        $this->validate($request,
        [
            'agent_feedback' => 'required',
        ],
            $messages = array('agent_feedback.required' => 'Agent Feedback is Required!')
        );

        $score = agentScoreCard::findorfail($id);
        $action = $score->agent_feedback <> null ? 'Updated' : 'Added';
        $score->update(['agent_feedback'=> $request['agent_feedback']]);

        return redirect()->back()->with('with_success', 'Feedback Succesfully ' .$action. '!');
    }

    public function agentActionPlan(Request $request, $id)
    {
        $this->validate($request,
        [
            'action_plan' => 'required',
        ],
            $messages = array('action_plan.required' => 'Action Plan Feedback is Required!')
        );

        $score = agentScoreCard::findorfail($id);
        $action = $score->action_plan <> null ? 'Updated' : 'Added';
        $score->update(['action_plan'=> $request['action_plan']]);

        return redirect()->back()->with('with_success', 'Action Plan Succesfully ' .$action. '!');
    }

    public function agentStrengthsOpportunities(Request $request, $id)
    {
        $this->validate($request,
        [
            'opportunities_strengths' => 'required',
        ],
            $messages = array('opportunities_strengths.required' => 'Strengths and Opportunities are Required!')
        );

        $score = agentScoreCard::findorfail($id);
        $action = $score->opportunities_strengths <> null ? 'Updated' : 'Added';
        $score->update(['opportunities_strengths'=> $request['opportunities_strengths']]);

        return redirect()->back()->with('with_success', 'Action Plan Succesfully ' .$action. '!');
    }

    public function agentScreenshots(Request $request, $id)
    {
        $this->validate($request,
        [
            'screenshots' => 'required',
        ],
            $messages = array('screenshots.required' => 'Screenshot/s is Required!')
        );

        $score = agentScoreCard::findorfail($id);
        $action = $score->screenshots <> null ? 'Updated' : 'Added';
        $score->update(['screenshots'=> $request['screenshots']]);

        return redirect()->back()->with('with_success', 'Screenshot/s Succesfully ' .$action. '!');
    }

    public function TlScreenshots(Request $request, $id)
    {
        $this->validate($request,
        [
            'screenshots' => 'required',
        ],
            $messages = array('screenshots.required' => 'Screenshot/s is Required!')
        );

        $score = TLScoreCard::findorfail($id);
        $action = $score->screenshots <> null ? 'Updated' : 'Added';
        $score->update(['screenshots'=> $request['screenshots']]);

        return redirect()->back()->with('with_success', 'Screenshot/s Succesfully ' .$action. '!');
    }

    public function acknowledgeScore($id)
    {
        $default_signature = Signature::where('user_id',Auth::user()->id)->where('is_default',1)->first();
        $score = agentScoreCard::findorfail($id);
        // $score->update(['acknowledge'=> 1]);

        // Acknowledged by Agent
        if(Auth::user()->isAgent())
        {
            $score->update([
                'acknowledge_by_agent' => 1,
                'agent_signature_id' => $default_signature->id,
                'date_acknowledge_by_agent' => Carbon::now()
            ]);
        }
        // Acknowledged by Supervisor
        elseif(Auth::user()->isSupervisor() || Auth::user()->isAdmin())
        {
            $score->update([
                'acknowledge_by_tl' => 1,
                'tl_signature_id' => $default_signature->id,
                'new_tl_id' => Auth::user()->id,
                'date_acknowledge_by_tl' => Carbon::now()
            ]);
        }
        // Acknowledged by Manager
        elseif(Auth::user()->isManager() || Auth::user()->isAdmin())
        {
            $score->update([
                'acknowledge_by_manager' => 1,
                'manager_signature_id' => $default_signature->id,
                'new_manager_id' => Auth::user()->id,
                'date_acknowledge_by_manager' => Carbon::now()
            ]);
        }

        if($score->acknowledge_by_agent == 1 && $score->acknowledge_by_tl == 1 && $score->acknowledge_by_manager == 1)
        {
            $score->update(['acknowledge'=> 1]);
        }

        return redirect()->back()->with('with_success', 'Scorecard Acknowledged Succesfully!');
    }

    public function imageUpload(Request $request)
    {
        // $fileName=$request->file('file')->getClientOriginalName();
        // $path=$request->file('file')->storeAs('uploads', $fileName, 'public');
        // return response()->json(['location'=>"/storage/$path"]);

        $imgpath = request()->file('file')->store('uploads', 'public');
        return response()->json(['location' => "/dco-scorecard/public/storage/$imgpath"]);
    }
     
}
