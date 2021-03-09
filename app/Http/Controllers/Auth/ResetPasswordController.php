<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;
use Illuminate\Support\Facades\Redirect;
use App\User;
use Illuminate\Support\Carbon;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    use ResetsPasswords;

    /**
     * Where to redirect users after resetting their password.
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
        $this->middleware('guest');
    }

    public function showResetForm(Request $request, $token = null)
    {
        $user = User::where('token', $token)->firstOrFail();
        return view('auth.passwords.reset')->with(
            ['token' => $token, 'email' => $user->email]
        );
    }

    public function rules()
    {
        return [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|string|min:8|max:191|confirmed|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/',
        ];
    }

    protected function resetPassword($user, $password)
    {
        // dd($user->status);
        $user->password = Hash::make($password);

        $user->setRememberToken(Str::random(60));
        $user->status = Carbon::now() ;

        $user->save();

        event(new PasswordReset($user));

        Redirect::to('login')->send()->with('resetPassword', 'Password has been reseted successfully.');
    }
}
