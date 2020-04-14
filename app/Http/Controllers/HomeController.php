<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Auth;
use App\helpers\HomeQueries;
use App\helpers\ScoreCardHelper;
use App\User;
use Carbon\Carbon;
use App\v2\Scorecard;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request)
    {
        $homeQuery = new HomeQueries();
      
        $selected_year = ($request->has('search_year') && $request->filled('search_year')) ? $request['search_year'] :  Carbon::now()->format('Y');

        if(Auth::user()->isAdmin() || Auth::user()->isManager()) 
        {
            $avail_year_in_scorecard =  $homeQuery->availableYearInScorecard();
           
           $scores = $homeQuery->adminGraphs($request);
           $avail_users_in_score =  ($homeQuery->scorecardUsers()) ? $homeQuery->scorecardUsers() : [];
           $unAcknowledge_list =  ($homeQuery->adminUnAcknowledgeList()) ? $homeQuery->adminUnAcknowledgeList() : [];
           
           
           $last_score_card_score =  [];
        
        }elseif(Auth::user()->isSupervisor()) 
        {
            //Check If userid is Team member or own

            if( $request->has('user_id') && $request->filled('user_id') )
            {
                $user = User::findorfail($request['user_id']);
                if($user->supervisor == Auth::user()->id || $user->id == Auth::user()->id){
                    $avail_year_in_scorecard =  $homeQuery->availableYearInScorecard();
           
                    $scores = $homeQuery->adminGraphs($request);
                    $avail_users_in_score =  ($homeQuery->scorecardUsersForSupervisor()) ? $homeQuery->scorecardUsersForSupervisor() : [];
                    $unAcknowledge_list =  ($homeQuery->unAcknowledgeListForSupervisor()) ? $homeQuery->unAcknowledgeListForSupervisor() : [];
                    
                    $last_score_card_score =  $homeQuery->lastScoreCard();
                    
                }else{
                    return \Redirect::back()->withErrors(['Restricted View']);
                }
            }
                $avail_year_in_scorecard =  $homeQuery->availableYearInScorecard();
            
                $request['user_id']= Auth::user()->id;
                $request['search_year'] = Carbon::now()->format('Y');
                $scores = $homeQuery->adminGraphs($request);
                $avail_users_in_score =  ($homeQuery->scorecardUsersForSupervisor()) ? $homeQuery->scorecardUsersForSupervisor() : [];
                $unAcknowledge_list =  ($homeQuery->unAcknowledgeListForSupervisor()) ? $homeQuery->unAcknowledgeListForSupervisor() : [];
                
                $last_score_card_score =  $homeQuery->lastScoreCard();
           

            
       
        }else{
            //User by default

            $avail_year_in_scorecard = Scorecard::groupBy('year')->orderBy('month_numerical_value','ASC')
                ->where('user_id', Auth::user()->id)
                ->get();

            if( $request->has('search_year') && $request->filled('search_year') )
            {
                $scores = Scorecard::where('year',$request['search_year'])
                ->where('user_id', Auth::user()->id)
                ->orderBy('month_numerical_value','ASC')
                ->where('is_deleted',0)
                ->get();

                $selected_year = $request['search_year'];
                
            }else{
                $scores = Scorecard::where('year',Carbon::now()->format('Y'))
                ->where('user_id', Auth::user()->id)
                ->orderBy('month_numerical_value','ASC')
                ->where('is_deleted',0)
                ->get();

                $selected_year = Carbon::now()->format('Y');
            }


            $last_score_card_score =  $homeQuery->lastScoreCard();

            $avail_users_in_score =  [];
            $unAcknowledge_list= [];
            
        }
        
        return view('home',compact('scores','avail_year_in_scorecard','avail_users_in_score','selected_year','last_score_card_score','unAcknowledge_list'));
    }
    
    public function profile()
    {
        return view('profile.account');
    }

    public function viewPassword()
    {
        return view('profile.change_password');
    }


    public function storePassword(Request $request)
    {
        $this->validate($request,
            [
                'password' => ['required', 'string', 'min:6'],
            ],
                $messages = array('password.required' => 'Password is Required!')
            );
           
            $request['password'] = Hash::make( $request['password']);
            $user = User::findorfail(Auth::user()->id);
            $user->update(['password' =>  $request['password'] ]);
            return redirect()->back()->with('with_success', 'Password changed succesfully!');   
    }


}
