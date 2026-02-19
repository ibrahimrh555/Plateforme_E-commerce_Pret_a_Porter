<?php

namespace App\Http\Controllers;

use App\Models\Commande;
use App\Models\CommandeArticle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommandeController extends Controller
{
    public function index()
    {
        // Récupérer l'ID du vendeur connecté
        $idVendeur = Auth::user()->id;
        
        // Filtrer les commandes pour afficher seulement celles des produits du vendeur
        $commandes = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                               $query->where('idVendeur', $idVendeur);
                           })
                           ->with(['articles.produit', 'utilisateur']) // Charger les relations
                           ->get();
                 
        return view('creudOrders', compact('commandes'));
    }

    public function update(Request $request, $id)
    {
        // Récupérer l'ID du vendeur connecté
        $idVendeur = Auth::user()->id;
        
        // Vérifier que la commande concerne un produit du vendeur
        $commande = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                              $query->where('idVendeur', $idVendeur);
                          })
                          ->where('id', $id)
                          ->firstOrFail();
                                 
        $commande->update($request->only(['idUtilisateur', 'date_commandes', 'statut', 'total']));
        return redirect()->route('commandes.index')->with('success', 'Commande mise à jour avec succès.');
    }

    public function destroy($id)
    {
        // Récupérer l'ID du vendeur connecté
        $idVendeur = Auth::user()->id;
        
        // Vérifier que la commande concerne un produit du vendeur
        $commande = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                              $query->where('idVendeur', $idVendeur);
                          })
                          ->where('id', $id)
                          ->firstOrFail();
                                 
        $commande->delete();
        return redirect()->route('commandes.index')->with('success', 'Commande supprimée avec succès.');
    }

    public function dernieresCommandesVendeur($idVendeur = null)
    {
        // Si pas d'ID fourni, utiliser le vendeur connecté
        if (!$idVendeur) {
            $idVendeur = Auth::user()->id;
        }
        
        $commandes = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                               $query->where('idVendeur', $idVendeur);
                           })
                           ->with(['articles.produit', 'utilisateur'])
                           ->orderByDesc('date_commandes')
                           ->take(5)
                           ->get();

        return view('dashboard', compact('commandes'));
    }
}