<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

use Auth;
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

        if(Auth::user()->isAdmin() || Auth::user()->isManager()) 
        {
            $scores =[];
        }elseif(Auth::user()->isSupervisor()) 
        {
           
       
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
                
                $last_score_card_score = $scores->last();

            }else{
                $scores = Scorecard::where('year',Carbon::now()->format('Y'))
                ->where('user_id', Auth::user()->id)
                ->orderBy('month_numerical_value','ASC')
                ->where('is_deleted',0)
                ->get();

                $last_score_card_score = $scores->last();

                $selected_year = Carbon::now()->format('Y');
            }

            
        }
        
        return view('home',compact('scores','avail_year_in_scorecard','selected_year','last_score_card_score'));
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
