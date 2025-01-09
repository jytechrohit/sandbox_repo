<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class MfaService
{
    public function generateToken()
    {
        return Str::random(6);
    }

    public function sendTokenByEmail(User $user, string $token)
    {
        Mail::send('emails.mfa', ['token' => $token], function ($message) use ($user) {
            $message->to($user->email)->subject('MFA Token');
        });
    }

    public function verifyToken(User $user, string $token)
    {
        // In a real application, you would verify against a stored token
        // This is a simplified version
        return $token === session('mfa_token');
    }
}
