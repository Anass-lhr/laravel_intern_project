<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use App\Providers\RouteServiceProvider;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;
use Illuminate\Validation\ValidationException;

class AuthenticatedSessionController extends Controller
{
    public function create(): View
    {
        Log::info('Checking if user is logged in...');
        Log::info('Auth check result: ' . (Auth::check() ? 'true' : 'false'));
        Log::info('User: ' . (Auth::user() ? Auth::user()->email : 'none'));

        if (Auth::check()) {
            Log::info('User already logged in, showing already-logged-in view');
            return view('auth.already-logged-in');
        }

        Log::info('User not logged in, showing login view');
        return view('auth.login');
    }

    public function store(LoginRequest $request): RedirectResponse
    {
        try {
            $request->validate([
                'g-recaptcha-response' => ['required', 'captcha'],
            ], [
                'g-recaptcha-response.required' => 'Veuillez compléter la vérification reCAPTCHA.',
                'g-recaptcha-response.captcha' => 'La vérification reCAPTCHA a échoué.',
            ]);

            $request->authenticate();
            $request->session()->regenerate();

            Log::info('User logged in: ' . Auth::user()->email);
            Log::info('Session ID: ' . session()->getId());

            if (!\Cookie::has('cookie_consent')) {
                return redirect()->route('cookie-consent.show');
            }

            return redirect(RouteServiceProvider::redirectTo());
        } catch (ValidationException $e) {
            Log::warning('Login failed: ' . json_encode($e->errors()));
            return redirect()->back()
                ->withErrors($e->errors())
                ->withInput($request->only('email', 'remember'));
        } catch (\Exception $e) {
            Log::error('Unexpected error during login: ' . $e->getMessage());
            return redirect()->back()
                ->withErrors(['email' => 'Une erreur inattendue s\'est produite. Veuillez réessayer.'])
                ->withInput($request->only('email', 'remember'));
        }
    }

    public function destroy(Request $request): RedirectResponse
    {
        Log::info('Logging out user: ' . (Auth::user() ? Auth::user()->email : 'none'));

        Auth::guard('web')->logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        \Cookie::queue(\Cookie::forget('laravel_session'));

        Log::info('User logged out, session invalidated');

        return redirect('/');
    }
}