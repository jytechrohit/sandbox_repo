<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Mail;
use App\Mail\MFATokenMail;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Auth;
use App\Services\MfaService;


class LoginController extends Controller
{

    protected $mfaService;

    public function __construct(MfaService $mfaService)
    {
        $this->mfaService = $mfaService;
    }

    // public function __construct()
    // {
    //     $this->middleware('guest')->except('logout');
    //     $this->middleware('auth')->only('logout');
    // }


    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     $user = User::where('email', $request->email)->first();

    //     if ($user && Hash::check($request->password, $user->password)) {
    //         $user->mfa_token = rand(100000, 999999);
    //         $user->save();

    //         Mail::to($user->email)->send(new MFATokenMail($user->mfa_token));

    //         return response()->json(['message' => 'MFA token sent.']);
    //     }

    //     return response()->json(['error' => 'Invalid credentials.'], 401);
    // }


    // public function verifyMfaToken(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'mfa_token' => 'required',
    //     ]);

    //     $user = User::where('email', $request->email)->where('mfa_token', $request->mfa_token)->first();

    //     if ($user) {
    //         $user->mfa_token = null;
    //         $user->save();

    //         return response()->json(['token' => $user->createToken('API Token')->accessToken]);
    //     }

    //     return response()->json(['error' => 'Invalid MFA token.'], 401);
    // }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $token = $this->mfaService->generateToken();
            $this->mfaService->sendTokenByEmail(Auth::user(), $token);
            return view('auth.mfa');
        }

        return back()->withErrors(['email' => 'Invalid credentials']);
    }
    public function verifyMfa(Request $request)
    {
        $request->validate(['token' => 'required|string']);

        if ($this->mfaService->verifyToken(Auth::user(), $request->token)) {
            $token = Auth::user()->createToken('API Token')->accessToken;
            return response()->json(['token' => $token]);
        }

        return back()->withErrors(['token' => 'Invalid MFA token']);
    }
}
