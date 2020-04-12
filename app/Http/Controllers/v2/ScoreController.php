<?php

namespace App\Http\Controllers\v2;


use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use Auth;
use App\User;
use Carbon\Carbon;
use App\Scorecard\Agent as agentScoreCard;
use App\Scorecard\tl as TLScoreCard;
use App\Role;
use App\Setting;
use App\v2\Template;
use App\v2\TemplateColumn;
use App\v2\TemplateContent;

use App\v2\Scorecard;
use App\v2\ScorecardColumn;
use App\v2\ScorecardContent;



class ScoreController extends Controller
{
    public function scores(Request $request,$roleId)
    {
        $this->userId = Auth::user()->id;
        
        /**
         * 
         * FOR SCORE CREATE
         *
         */

        $users = User::where('role_id',$roleId)->orderBy('name','ASC')
        ->where('status','active')
        ->get();

        $role = Role::findorfail($roleId);

        $scorecard_templates = Template::orderBy('name','desc')->get();

        $this->roleId = $roleId;
        
        if( $request->has('filter_month') && $request->filled('filter_month') )
        {
            $scores = Scorecard::where('month',$request['filter_month']);

        }elseif( $request->has('not_acknowledge'))
        {
            $scores = Scorecard::where('is_acknowledge',0);
        }elseif( $request->has('acknowledge'))
        {
            $scores = Scorecard::where('is_acknowledge',1);
        }
        elseif( $request->has('view_all'))
        {
            $scores = Scorecard::orderBy('id','desc');
            
        //DEFAULT MONTH NOW    
        }else{
            // return Carbon::now()->format('M Y');
            $scores = Scorecard::where('month',Carbon::now()->format('M Y'));
            // $scores = $scores->where('month',Carbon::now()->format('M Y'));
        }

        if(Auth::user()->isAdmin() || Auth::user()->isManager()) 
        {
            $scores = $scores->where('is_deleted',0)
            ->whereHas('theuser', function($q){
                $q->where('role_id', $this->roleId);
            })->get();
        }elseif(Auth::user()->isSupervisor()) 
        {
            //If searched role is Supervisor : view only his scorecard
            if($this->roleId == Auth::user()->role_id ){
                $scores = $scores->where('is_deleted',0)
                ->whereHas('theuser', function($q){
                    $q->where('role_id', $this->roleId);
                    $q->where('user_id', Auth::user()->id);
                })->get();
            }else{
                $scores = $scores->where('is_deleted',0)
                ->whereHas('theuser', function($q){
                    $q->where('role_id', $this->roleId);
                    //view only his/her team
                    $q->where('supervisor', Auth::user()->id);
                })->get();
            }
       
        }else{
            //User by default
            
            //if role <> user role return back
            if($this->roleId <> Auth::user()->role_id)
            {
                return \Redirect::back()->withErrors(['Restricted View']);
            }

            $scores = $scores->where('is_deleted',0)
            ->whereHas('theuser', function($q){
                $q->where('role_id', $this->roleId);
            })
            ->where('user_id', Auth::user()->id)
            ->get();
        }
     
        


        $avail_months = Scorecard::groupBy('month')->orderBy('id','desc')->get();

        return view('scores.card.list',compact('users','role','scorecard_templates','scores','avail_months'));
    }

    public function scoreStore(Request $request,$roleId)
    {
        $this->validate($request,
        [
            'month'       => 'required',
            'user_id'       => 'required',
            'template_id'       => 'required',
          
        ],
            $messages = array('user_id.required' => 'Employee Name is Required!',
            'template_id.required' => 'Template is Required!')
        );

        $templateId = $request['template_id'];

        $request['year'] = substr($request['month'], 4); 

        $request['created_by'] = Auth::user()->id;
        $request['final_score'] = 0;

        $get_month_only = substr($request['month'], 0,3); 
        switch ($get_month_only) {
            case 'Jan':
                $month_num_val = 1;
                break;
            case 'Feb':
                $month_num_val = 2;
                break;
            case 'Mar':
                $month_num_val = 3;
                break;
            case 'Apr':
                $month_num_val = 4;
                break;
            case 'May':
                $month_num_val = 5;
                break;
            case 'Jun':
                $month_num_val = 6;
                break;
            case 'Jul':
                $month_num_val = 7;
                break;
            case 'Aug':
                $month_num_val = 8;
                break;
            case 'Sept':
                $month_num_val = 9;
                break;
            case 'Oct':
                $month_num_val = 10;
                break;
            case 'Nov':
                $month_num_val = 11;
                break;
            case 'Dec':
                $month_num_val = 12;
                break;
            default:
                # code...
                break;
        }

        $request['month_numerical_value'] =  $month_num_val ;
        
        $scorecard = Scorecard::create($request->all());

        //Generate User Column
        $template_columns =   TemplateColumn::where('template_id',$templateId)->get();
        
        if(count($template_columns) > 0)
        {
            foreach($template_columns as $columns){
                ScorecardColumn::create(['scorecard_id'=>$scorecard->id,
                'column_name'=>$columns->column_name,
                'column_position'=>$columns->column_position,
                'is_fillable'=>$columns->is_fillable,
                'parent_template_column_id'=>$columns->id]);
            }
        }

        //Generate User Template Content
        $template_content =  TemplateContent::where('template_id',$templateId)->get();

        if(count($template_content) > 0)
        {
            foreach($template_content as $content){
                ScorecardContent::create(['scorecard_id'=>$scorecard->id,
                'content'=>$content->content,
                'row_position'=>$content->row_position,
                'column_position'=>$content->column_position]);
            }
        }

        return redirect()->route('v2.score.show', [$scorecard->id,$roleId])
        ->with('with_success', 'Created succesfully!');


        // return redirect()->back()->with('with_success', 'Created succesfully!'); 
    }

    public function showScoreCard($scoreCardId,$roleId)
    {
        $score = Scorecard::findorfail($scoreCardId);

        if(Auth::user()->isAdmin() || Auth::user()->isManager()){

        }elseif( Auth::user()->isSupervisor()){

            //If searched role is Supervisor : view only his scorecard
             if($roleId == Auth::user()->role_id ){
                
            }else{
                if( $score->theuser->supervisor <> Auth::user()->id )
                {
                    return \Redirect::back()->withErrors(['Restricted View']);
                }
            }

           
        }else{
            //if User
            if($score->user_id <> Auth::user()->id)
            {
                return \Redirect::back()->withErrors(['Restricted View']);
            }

            if($roleId <> Auth::user()->role_id)
            {
                return \Redirect::back()->withErrors(['Restricted View']);
            }
        }

        //Check if Score is Deleted
        if($score->is_deleted == 1)
            {
                return \Redirect::back()->withErrors(['Error on Scorecard view']);
            }


        $role = Role::findorfail($roleId);

        $scorecard_column =   ScorecardColumn::where('scorecard_id',$score->id)->get();

        $templatecontent_lastrow = ScorecardContent::where('scorecard_id',$score->id)->orderBy('row_position','desc')->first();
        $templatecontent = ScorecardContent::where('scorecard_id',$score->id)->get();
       
        $towerhead = Setting::where('setting','towerhead')->first();

        return view('scores.card.cards',compact('role','scorecard_column','templatecontent_lastrow','templatecontent','score','towerhead'));
   
    }

    public function printScoreCard($scoreCardId,$roleId)
    {
        $score = Scorecard::findorfail($scoreCardId);

        if(Auth::user()->isAdmin() || Auth::user()->isManager()){

        }elseif( Auth::user()->isSupervisor()){

            //If searched role is Supervisor : view only his scorecard
             if($roleId == Auth::user()->role_id ){
                
            }else{
                if( $score->theuser->supervisor <> Auth::user()->id )
                {
                    return \Redirect::back()->withErrors(['Restricted View']);
                }
            }

           
        }else{
            //if User
            if($score->user_id <> Auth::user()->id)
            {
                return \Redirect::back()->withErrors(['Restricted View']);
            }

            if($roleId <> Auth::user()->role_id)
            {
                return \Redirect::back()->withErrors(['Restricted View']);
            }
        }

         //Check if Score is Deleted
         if($score->is_deleted == 1)
         {
             return \Redirect::back()->withErrors(['Error on Scorecard print']);
         }

        $role = Role::findorfail($roleId);

        $scorecard_column =   ScorecardColumn::where('scorecard_id',$score->id)->get();

        $templatecontent_lastrow = ScorecardContent::where('scorecard_id',$score->id)->orderBy('row_position','desc')->first();
        $templatecontent = ScorecardContent::where('scorecard_id',$score->id)->get();
       
        $towerhead = Setting::where('setting','towerhead')->first();

        return view('scores.card.print',compact('role','scorecard_column','templatecontent_lastrow','templatecontent','score','towerhead'));
   
   
    }

    public function acknowledgeScorecard($scoreCardId)
    {
        
        $score = Scorecard::findorfail($scoreCardId);

        if($score->user_id <> Auth::user()->id)
        {
            return \Redirect::back()->withErrors(['Restricted View']);
        }

        $score->update(['is_acknowledge' => 1]);
        return redirect()->back()->with('with_success', 'Score card has been Acknowledge succesfully!'); 
    }

    public function feedbackScorecard(Request $request, $scoreCardId)
    {
        
        $score = Scorecard::findorfail($scoreCardId);

        if($score->user_id <> Auth::user()->id)
        {
            return \Redirect::back()->withErrors(['Restricted View']);
        }

        $score->update(['agent_feedback' => $request['agent_feedback']]);
        return redirect()->back()->with('with_success', 'Feedback submitted succesfully!'); 
    }

    public function actionplanScorecard(Request $request, $scoreCardId)
    {
        
        $score = Scorecard::findorfail($scoreCardId);

        if($score->user_id <> Auth::user()->id)
        {
            return \Redirect::back()->withErrors(['Restricted View']);
        }

        $score->update(['action_plan' => $request['action_plan']]);
        return redirect()->back()->with('with_success', 'Action plan submitted succesfully!'); 
    }

    

    

    
    /**
     *  Technically will update is_deleted to : 1
     */
    public function deleteScorecard($scoreCardId)
    {
        $score = Scorecard::findorfail($scoreCardId);
        $score->update(['is_deleted' => 1]);
        return redirect()->back()->with('with_success', 'Score card Deleted succesfully!'); 
    }

    /**
     * 
     * called via AJAX;
     */
    public function updateScorecardFillable(Request $request)
    {
        $content =  ScorecardContent::where('scorecard_id',$request['scoreCardId'])
       ->where('row_position',$request['row_position'])
       ->where('column_position',$request['column_position'])
       ->first();

       $update = $content->update(['content'=>$request['content']]);
        
       if($update){
            $score = Scorecard::where('id',$request['scoreCardId'])->first();
            $score = $score->update(['final_score'=>$request['finalScore']]);
           return "successfull";
       }
    }
}
