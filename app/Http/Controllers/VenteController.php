<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\Utilisateur;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VenteController extends Controller
{
    public function clientsDuVendeur()
    {
        // Récupérer l'ID du vendeur connecté
        $idVendeur = Auth::user()->id;
        
        $clients = Utilisateur::where('role', 'client')
            ->whereHas('commandes.articles.produit', function ($query) use ($idVendeur) {
                $query->where('idVendeur', $idVendeur);
            })
            ->with(['commandes' => function ($query) use ($idVendeur) {
                $query->whereHas('articles.produit', function ($q) use ($idVendeur) {
                    $q->where('idVendeur', $idVendeur);
                })->with('articles.produit');
            }])
            ->get();

        return view('clients', compact('clients'));
    }
}