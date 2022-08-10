<?php

namespace App\Http\Controllers\Auth;

use Notification;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\TwoFactorCode;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function username()
    {
        return 'emp_id';
    }

    protected function authenticated(Request $request, $user)
    {
        $user->generateTwoFactorCode();

        // Notification::send($user, new TwoFactorCode());
        // Notification::route('mail', $request['email'])->notify(new TwoFactorCode($user->two_factor_code));
    }


}
