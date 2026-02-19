<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Favoris;
use App\Models\FavorisArticles;
use App\Models\Produit;
use App\Models\Panier;
use App\Models\PanierArticle;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PanierController;

class FavorisController extends Controller
{
    // Afficher la liste des favoris de l'utilisateur connecté
    public function index()
    {
        $user = Auth::user();

        $favoris = Favoris::where('idUtilisateur', $user->id)->first();
        if (!$favoris) {
            $favoris = new Favoris();
            $favoris->idUtilisateur = $user->id;
            $favoris->save();
        }
        
        $produitsFavori = Produit::join('favoris_articles', 'produits.id', '=', 'favoris_articles.idProduit')
                          ->where('favoris_articles.idFavoris', $favoris->id)
                          ->select('produits.*')
                          ->get();
        return view('favoris', compact('produitsFavori'));
    }
    
    // Ajouter un produit aux favoris
    public function ajouterFavoris($idProduit)
    {
        $user = Auth::user();

        $favoris = Favoris::where('idUtilisateur', $user->id)->first();
        
        if (!$favoris) {
            // Créer une liste de favoris si elle n'existe pas
            $favoris = new Favoris();
            $favoris->idUtilisateur = $user->id;
            $favoris->save();
        }
        
        // Vérifier si le produit existe déjà dans les favoris
        $existant = FavorisArticles::where('idFavoris', $favoris->id)
                    ->where('idProduit', $idProduit)
                    ->first();
                    
        if (!$existant) {
            // Ajouter le produit aux favoris
            $favoriArticle = new FavorisArticles();
            $favoriArticle->idFavoris = $favoris->id;
            $favoriArticle->idProduit = $idProduit;
            $favoriArticle->save();
            
            return redirect()->back()->with('success', 'Produit ajouté aux favoris');
        }
        
        return redirect()->back()->with('info', 'Ce produit est déjà dans vos favoris');
    }
    
    // Supprimer un produit des favoris
    public function supprimerFavoris($idProduit)
    {
        $user = Auth::user();
        $favoris = Favoris::where('idUtilisateur', $user->id)->first();
        
        if ($favoris) {
            FavorisArticles::where('idFavoris', $favoris->id)
                          ->where('idProduit', $idProduit)
                          ->delete();
        }
        
        return redirect()->back()->with('success');
    }

    // Ajouter un produit aux paniers
    public function ajouterPanier(Request $request)
    {
        $request->validate([
            'idProduit' => 'required|exists:produits,id',
            'quantite' => 'required|integer|min:1'
        ]);
        
        $user = Auth::user();
        
        if (!$user) {
            return response()->json(['error' => 'Utilisateur non connecté'], 401);
        }

        $panier = Panier::firstOrCreate(['idUtilisateur' => $user->id]);

        $panierArticle = PanierArticle::where('idPanier', $panier->id)
            ->where('idProduit', $request->idProduit)
            ->first();
        
        if ($panierArticle) {

            $panierArticle->quantite += $request->quantite;
            $panierArticle->save();
        } else {

            PanierArticle::create([
                'idPanier' => $panier->id,
                'idProduit' => $request->idProduit,
                'quantite' => $request->quantite
            ]);
        }
        
        return redirect()->back()->with('success', 'Produit ajouté au panier avec succès');
    }
}