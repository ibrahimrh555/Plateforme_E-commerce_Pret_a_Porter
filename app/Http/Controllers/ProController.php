<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;;
use Illuminate\Support\Facades\Auth;
use App\Models\Panier;
use App\Models\PanierArticle;
use App\Models\Favoris;
use App\Models\FavorisArticles;

class ProController extends Controller
{
    // Afficher le detail de produits
    public function detail(Request $request)
    {
        $produit = \App\Models\Produit::findOrFail($request->id);
        return view('detailProduit', compact('produit'));
    }

}
