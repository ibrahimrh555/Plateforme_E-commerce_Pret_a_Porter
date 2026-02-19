<?php

namespace App\Http\Controllers;

use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Auth as FacadesAuth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class authController extends Controller
{
    public function showRegister()
    {
        return view('authentication.inscrire');
    }

    public function showLogin()
    {
        return view('authentication.connexion');
    }

    public function Register(Request $request)
    {
        $valid = $request->validate([
            'nom' => 'required|string',
            'email' => 'required|string|unique:utilisateurs,email',
            'motPasse' => 'required|string|digits_between:8,20',
            'adresse' => 'required|string',
            'telephone' => 'required|digits:9',
            'role' => 'required|in:client,vendeur'
        ]);
        $valid['motPasse'] = Hash::make($valid['motPasse']);

        $user = Utilisateur::create($valid);

        Auth::login($user);

        if ($user->role === 'client') {
            return redirect()->route('accueil')->with('Congratulations', 'u are a client now!!' . $user->nom);
        } elseif ($user->role === 'vendeur') {
            return redirect()->route('Register')->with('Congratulations ', 'u are a vendeur now!!' . $user->nom);
        }
    }

    public function Login(Request $request)
    {
        $credentials = [
            'email' => $request->email,
            'password' => $request->motPasse,
        ];

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            $user = Auth::user();

            if ($user->role === 'client') {
                return redirect()->route('accueil');
            } elseif ($user->role === 'vendeur') {
                return redirect()->route('dashboard');
            }
        }

        throw ValidationException::withMessages([
            'credentials' => 'Email ou mdp incorrecte'
        ]);
    }
    public function Logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate(); 
        $request->session()->regenerateToken(); // Regenerates the CSRF token

        return redirect()->route('accueil')->with('success', 'Vous avez été déconnecté avec succès.');
    }
}
