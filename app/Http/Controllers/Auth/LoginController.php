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
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/');
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

    public function showLoginForm()
    {
        return view('auth.login');
    }
}
