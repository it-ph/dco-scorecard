<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;

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
    public function index()
    {
        return view('home');
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
