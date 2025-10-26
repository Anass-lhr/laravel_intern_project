<?php

namespace App\Http\Requests\Auth;

use Illuminate\Auth\Events\Lockout;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;

class LoginRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'email' => ['required', 'string', 'email'],
            'password' => ['required', 'string'],
            'g-recaptcha-response' => ['required', 'captcha'],
        ];
    }

    public function messages()
    {
        return [
            'g-recaptcha-response.required' => 'Veuillez compléter la vérification reCAPTCHA.',
            'g-recaptcha-response.captcha' => 'La vérification reCAPTCHA a échoué.',
        ];
    }

    public function authenticate()
    {
        $this->ensureIsNotRateLimited();

        $credentials = $this->only('email', 'password');
        \Log::info('Attempting login with credentials: ' . json_encode($credentials));

        $user = \App\Models\User::where('email', $this->input('email'))->first();
        if (!$user) {
            \Log::warning('Login failed: Email not found - ' . $this->input('email'));
            throw \Illuminate\Validation\ValidationException::withMessages([
                'email' => 'Cet email n\'existe pas.',
            ]);
        }

        if (!Auth::attempt($credentials, $this->boolean('remember'))) {
            RateLimiter::hit($this->throttleKey());
            \Log::warning('Login failed: Incorrect password for email - ' . $this->input('email'));
            throw \Illuminate\Validation\ValidationException::withMessages([
                'password' => 'Le mot de passe est incorrect.',
            ]);
        }

        RateLimiter::clear($this->throttleKey());
        \Log::info('Login successful for email: ' . $this->input('email'));
    }

    public function ensureIsNotRateLimited()
    {
        if (! RateLimiter::tooManyAttempts($this->throttleKey(), 5)) {
            return;
        }

        event(new Lockout($this));

        $seconds = RateLimiter::availableIn($this->throttleKey());

        throw ValidationException::withMessages([
            'email' => trans('auth.throttle', [
                'seconds' => $seconds,
                'minutes' => ceil($seconds / 60),
            ]),
        ]);
    }

    public function throttleKey()
    {
        return Str::lower($this->input('email')).'|'.$this->ip();
    }
}