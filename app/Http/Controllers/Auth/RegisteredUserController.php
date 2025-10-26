<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
public function store(Request $request): RedirectResponse
{
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'g-recaptcha-response' => ['required', 'captcha'],
    ], [
        // Messages d'erreur personnalisés en français
        'name.required' => 'Veuillez entrer votre nom.',
        'name.string' => 'Le nom doit être une chaîne de caractères.',
        'name.max' => 'Le nom ne doit pas dépasser 255 caractères.',
        'email.required' => 'Veuillez entrer votre adresse email.',
        'email.email' => 'L\'adresse email doit être valide.',
        'email.max' => 'L\'adresse email ne doit pas dépasser 255 caractères.',
        'email.unique' => 'Cette adresse email est déjà utilisée.',
        'password.required' => 'Veuillez entrer un mot de passe.',
        'password.confirmed' => 'La confirmation du mot de passe ne correspond pas.',
        'password.min' => 'Le mot de passe doit comporter au moins 8 caractères.', // Message personnalisé
        'g-recaptcha-response.required' => 'Veuillez compléter la vérification reCAPTCHA.',
        'g-recaptcha-response.captcha' => 'La vérification reCAPTCHA a échoué.',
    ]);

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);

    event(new Registered($user));

    Auth::login($user);

    return redirect(RouteServiceProvider::HOME)->with('success', 'Inscription réussie !');
}
    
}