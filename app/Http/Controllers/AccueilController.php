<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use App\Models\Favoris;
use App\Models\FavorisArticles;
use Illuminate\Support\Facades\Auth;

class AccueilController extends Controller
{
    public function index(Request $request)
    {
        $query = $request->input('q'); // récupération du texte saisi

        $produits = Produit::query()
            ->when($query, function ($q) use ($query) {
                $q->where('nom', 'like', '%' . $query . '%');
            })
            ->get();



        $message = null;

        if ($query && $produits->isEmpty()) {
            $message = "Aucun produit trouvé pour : \"$query\"";
        }

        return view('home', compact('produits', 'message', 'query'));
    }

    // On récupère les produits dont la catégorie est "Femmes" (id = 1)
    public function afficherFemmes()
    {
        $produits = Produit::where('idCategorie', 1)->get();
        return view('femmes', compact('produits'));
    }

    // On récupère les produits dont la catégorie est "Hommes" (id = 2)
    public function afficherHommes()
    {
        $produits = Produit::where('idCategorie', 2)->get();
        return view('hommes', compact('produits'));
    }

    // On récupère les produits dont la catégorie est "Enfants" (id = 3)
    public function afficherEnfants()
    {
        $produits = Produit::where('idCategorie', 3)->get();
        return view('enfants', compact('produits'));
    }

    // On récupère les produits dont la catégorie est "Bebe" (id = 4)
    public function afficherBebe()
    {
        $produits = Produit::where('idCategorie', 4)->get();
        return view('bebe', compact('produits'));
    }

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
