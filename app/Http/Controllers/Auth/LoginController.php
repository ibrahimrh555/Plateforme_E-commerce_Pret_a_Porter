<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\Utilisateur;
use Illuminate\Validation\ValidationException;

class LoginController extends Controller
{
    public function show()
    {
        return view('connexion'); // Vue connexion.blade.php
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'motPasse' => 'required',
        ]);

        // Récupérer l'utilisateur
        $user = Utilisateur::where('email', $request->email)->first();

        // Vérification du mot de passe
        if ($user && Hash::check($request->motPasse, $user->motPasse)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home')->with('success', 'Bienvenue !');
        }

        // En cas d'échec
        throw ValidationException::withMessages([
            'email' => 'Email ou mot de passe incorrect.',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('success', 'Déconnecté');
    }
}
