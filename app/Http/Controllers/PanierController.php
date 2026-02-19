<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;
use App\Models\PanierArticle;
use App\Models\Produit;
use App\Models\Favoris;
use App\Models\FavorisArticles;




class PanierController extends Controller
{
    
    // Afficher le panier
    public function index()
    { 
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login')->with('error', 'Veuillez vous connecter pour accéder à votre panier');
        }

        // Cherche ou crée le panier
        $panier = Panier::firstOrCreate(['idUtilisateur' => $user->id]);

        // Récupération des articles du panier avec leurs infos produit
        $panierArticles = PanierArticle::with('produit')  // relation 'produit' à définir dans le modèle PanierArticle
                            ->where('idPanier', $panier->id)
                            ->get();

        $panierArticles = Produit::join('panier_articles', 'produits.id', '=', 'panier_articles.idProduit')
        ->where('panier_articles.idPanier', $panier->id)
        ->select('produits.*', 'panier_articles.quantite', 'panier_articles.id as idPanierArticle')
        ->get();


        // Calcul du sous-total
        $sousTotal = 0;
        foreach ($panierArticles as $article) {
            $sousTotal += $article->quantite * $article->prix;
        }


        // Frais de livraison fixe
        $fraisLivraison = 30.00;

        // Total général
        $total = $sousTotal;

        return view('panier', [
            'panierArticles' => $panierArticles,
            'sousTotal' => $sousTotal,
            'fraisLivraison' => $fraisLivraison,
            'total' => $total
        ]);
    }

    // Ajouter un produit au panier
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

    // Mettre à jour la quantité d'un produit dans le panier
    public function modifierQuantite(Request $request)
{
    $request->validate([
        'idPanierArticle' => 'required|exists:panier_articles,id',
        'action' => 'required|in:augmenter,diminuer,definir',
        'quantite' => 'nullable|integer|min:1|max:99'
    ]);

    $user = Auth::user();
    if (!$user) {
        return redirect()->route('login')->with('error', 'Veuillez vous connecter');
    }

    $panierArticle = PanierArticle::findOrFail($request->idPanierArticle);

    $panier = Panier::where('idUtilisateur', $user->id)->first();
    if (!$panier || $panierArticle->idPanier != $panier->id) {
        return redirect()->back()->with('error', 'Action non autorisée');
    }

    switch ($request->action) {
        case 'augmenter':
            $nouvelleQuantite = $panierArticle->quantite + 1;
            break;
        case 'diminuer':
            $nouvelleQuantite = max(1, $panierArticle->quantite - 1);
            break;
        case 'definir':
            $nouvelleQuantite = $request->quantite ?? $panierArticle->quantite;
            break;
        default:
            $nouvelleQuantite = $panierArticle->quantite;
    }

    $nouvelleQuantite = min(99, max(1, $nouvelleQuantite));
    $panierArticle->quantite = $nouvelleQuantite;
    $panierArticle->save();

    return redirect()->route('panier.afficher')->with('success', 'Quantité mise à jour');
}

    
    // Supprimer un produit du panier
    public function supprimerPanier($id)
    {
        
        $user = Auth::user();
        $panier = Panier::where('idUtilisateur', $user->id)->first();
        
        if ($panier) {
            PanierArticle::where('idPanier', $panier->id)
                          ->where('idProduit', $id)
                          ->delete();
        }
        
        return redirect()->back()->with('success');
        
        
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
    
    

    
}
