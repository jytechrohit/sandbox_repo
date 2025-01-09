<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\MFATokenMail;
use GuzzleHttp\Psr7\Request;

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
        $this->middleware('auth')->only('logout');
    }


    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if ($user && Hash::check($request->password, $user->password)) {
            $user->mfa_token = rand(100000, 999999);
            $user->save();

            Mail::to($user->email)->send(new MFATokenMail($user->mfa_token));

            return response()->json(['message' => 'MFA token sent.']);
        }

        return response()->json(['error' => 'Invalid credentials.'], 401);
    }


    public function verifyMfaToken(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'mfa_token' => 'required',
        ]);

        $user = User::where('email', $request->email)->where('mfa_token', $request->mfa_token)->first();

        if ($user) {
            $user->mfa_token = null;
            $user->save();

            return response()->json(['token' => $user->createToken('API Token')->accessToken]);
        }

        return response()->json(['error' => 'Invalid MFA token.'], 401);
    }
}
