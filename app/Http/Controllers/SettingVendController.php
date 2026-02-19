<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Utilisateur;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class SettingVendController extends Controller
{
    /**
     * Récupérer le vendeur connecté et vérifier les permissions
     */
    private function getAuthenticatedVendeur()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est connecté et qu'il est vendeur
        if (!$user || $user->role !== 'vendeur') {
            abort(403, 'Accès non autorisé. Vous devez être connecté en tant que vendeur.');
        }
        
        return $user;
    }

    /**
     * Afficher les paramètres du vendeur connecté
     */
    public function showSettings()
    {
        $vendeur = $this->getAuthenticatedVendeur();
        return view('vendeur.settings', compact('vendeur'));
    }

    /**
     * Mettre à jour le mot de passe du vendeur connecté
     */
    public function updatePassword(Request $request)
    {
        $vendeur = $this->getAuthenticatedVendeur();
        
        $request->validate([
            'current_password' => 'required',
            'motPasse' => 'required|min:6|confirmed',
        ]);

        // Vérifier l'ancien mot de passe pour plus de sécurité
        if (!Hash::check($request->current_password, $vendeur->motPasse)) {
            return redirect()->back()
                ->withErrors(['current_password' => 'Le mot de passe actuel est incorrect.']);
        }

        // Mettre à jour le mot de passe
        $vendeur->motPasse = Hash::make($request->motPasse);
        $vendeur->save();

        return redirect()->route('vendeur.settings')
            ->with('success', 'Mot de passe mis à jour avec succès.');
    }

    /**
     * Mettre à jour le profil du vendeur connecté
     */
    public function updateProfile(Request $request)
    {
        $vendeur = $this->getAuthenticatedVendeur();
        
        $request->validate([
            'nom' => 'required|string|max:255',
            'email' => 'required|email|unique:utilisateurs,email,' . $vendeur->id,
            'adresse' => 'required|string|max:255',
            'telephone' => 'required|digits:9',
        ]);

        $vendeur->update([
            'nom' => $request->nom,
            'email' => $request->email,
            'adresse' => $request->adresse,
            'telephone' => $request->telephone,
        ]);

        return redirect()->route('vendeur.settings')
            ->with('success', 'Profil mis à jour avec succès.');
    }
}