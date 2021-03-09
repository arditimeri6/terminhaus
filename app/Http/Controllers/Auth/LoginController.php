<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request,$user)
    {
       if($user->status == null){
            $this->guard()->logout();

            $request->session()->invalidate();

            return $this->loggedOut($request) ?: redirect('/login')->with('notActiveSession', 'Ihr Konto ist nicht aktiv!');

       }
        elseif(!empty($user->ip_address && $request->ip() != $user->ip_address)){
            $this->guard()->logout();

            $request->session()->invalidate();

            return $this->loggedOut($request) ?: redirect('/login')->with('ipSession', 'Sie sind außerhalb ihres Büro! Der Direktor wurde informiert, dass sie sich unrechtmäßig Anmelden wollten!');
       }

    }
}
