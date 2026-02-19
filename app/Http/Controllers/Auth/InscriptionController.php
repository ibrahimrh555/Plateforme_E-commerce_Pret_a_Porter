<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class InscriptionController extends Controller
{
    public function show()
    {
        return view('inscrire'); // Vue spécifique pour client
    }

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nom' => 'required|string|max:50|unique:utilisateurs,nom',
            'email' => 'required|email|unique:utilisateurs,email',
            'adresse' => 'nullable|string|max:255',
            'telephone' => 'required|string|max:255',
            'motPasse' => 'required|string|min:6|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        Utilisateur::create([
            'nom' => $request->nom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
            'motPasse' => Hash::make($request->motPasse),
            'role' => 'client', // Rôle client forcé
        ]);

        return redirect()->route('login')->with('success', 'Votre compte client a été créé avec succès.');
    }
}
