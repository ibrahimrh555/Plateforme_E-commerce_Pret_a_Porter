<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;
use App\Models\PanierArticle;
use App\Models\Produit;
use App\Models\Favoris;
use App\Models\FavorisArticles;
use App\Models\Commande;
use App\Models\CommandeArticle;



class CommController extends Controller
{
    public function passerCommande(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Vous devez être connecté pour passer une commande.');
        }

        // recuperer le panier de utilisateur
        $panier = Panier::where('idUtilisateur', $user->id)->first();
        if (!$panier) {
            return redirect()->back()->with('error', 'Aucun panier trouvé.');
        }

        // recuperer les articles du panier
        $articles = PanierArticle::where('idPanier', $panier->id)->with('produit')->get();
        if ($articles->isEmpty()) {
            return redirect()->back()->with('error', 'Votre panier est vide.');
        }

        // calcul du total des produits
        $totalProduits = 0;
        foreach ($articles as $article) {
            $totalProduits += $article->quantite * $article->produit->prix;
        }

        $fraisLivraison = 30;
        $montantTotal = $totalProduits + $fraisLivraison;

        // creation de la commande
        $commande = new Commande();
        $commande->idUtilisateur = $user->id;
        $commande->total = $montantTotal;
        $commande->statut = 'en attente';
        $commande->save();

        // insertion des articles dans commandearticles
        foreach ($articles as $article) {
            CommandeArticle::create([
                'idCommande'     => $commande->id,
                'idProduit'      => $article->idProduit,
                'quantite'       => $article->quantite,
                'prix_unitaire'  => $article->produit->prix,
                'total'          => $article->quantite * $article->produit->prix,
            ]);
        }

        // vider le panier
        PanierArticle::where('idPanier', $panier->id)->delete();
$idComm=$commande->id;
        return redirect()->route('checkout.view',['idComm' => $idComm])->with('success', 'Commande passée avec succès.');
    }

}