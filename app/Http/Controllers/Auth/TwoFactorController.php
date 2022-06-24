<?php

namespace App\Http\Controllers\Auth;

use App\User;
use Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;

class TwoFactorController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'twofactor']);
    }

    public function index()
    {
        return view('auth.emailTwoFactor');
    }

    public function send(Request $request)
    {
        $email = $request['email'];
        $user = auth()->user();
        Notification::route('mail', $email)->notify(new TwoFactorCode($user->two_factor_code));

        $errors = "";

        return view('auth.twoFactor',compact('email','errors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'integer|required',
        ]);

        $user = auth()->user();

        if($request->input('two_factor_code') == $user->two_factor_code)
        {
            $user->resetTwoFactorCode();

            return redirect()->route('home');
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'The two factor code you have entered does not match!']);
    }

    public function resend(Request $request)
    {
        $email = $request['email'];

        $user = auth()->user();
        $user->generateTwoFactorCode();

        Notification::route('mail', $email)->notify(new TwoFactorCode($user->two_factor_code));

        // return redirect()->back()->with(['two_factor_code' => 'The two factor code has been sent again','email' => $email]);

        $errors = ['two_factor_code' => 'The two factor code has been sent again'];
        return view('auth.twoFactor',compact('email','errors'));
    }
}
