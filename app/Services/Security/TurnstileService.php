<?php

namespace App\Services\Security;

use Illuminate\Support\Facades\Http;

class TurnstileService
{
    public function verify($token, $ip = null)
    {
        $response = Http::post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
            'secret' => config('services.turnstile.secret'),
            'response' => $token,
            'remoteip' => $ip,
        ]);

        return $response->json()['success'] ?? false;
    }
}