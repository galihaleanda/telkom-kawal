<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\Auth\GoogleAuthService;
use App\Actions\Auth\HandleGoogleLogin;
use App\Services\Security\TurnstileService;


class GoogleAuthController extends Controller
{
    public function __construct(
        protected GoogleAuthService $googleService,
        protected HandleGoogleLogin $handleGoogleLogin,
        protected TurnstileService $turnstile
    ) {}

    public function redirect(Request $request)
    {
        $token = $request->input('cf-turnstile-response');
        if (!$this->turnstile->verify($token, $request->ip())) {
            return redirect('/signin')->withErrors([
                'captcha' => 'Verifikasi gagal. Coba lagi.'
            ]);
        }

        return $this->googleService->redirect();
    }

    public function callback()
    {
        try {
            $googleUser = $this->googleService->getUser();
            $this->handleGoogleLogin->execute($googleUser);
            return redirect('/');
        } catch (\Exception $e) {
            return redirect('/signin')->withErrors(['email' => $e->getMessage()]);
        }
    }
}
