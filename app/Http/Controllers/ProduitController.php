<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Produit;
use App\Models\Categorie;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class ProduitController extends Controller
{
    /**
     * Récupérer l'ID du vendeur connecté
     */
    private function getVendeurId()
    {
        $user = Auth::user();
        
        // Vérifier que l'utilisateur est connecté et qu'il est vendeur
        if (!$user || $user->role !== 'vendeur') {
            abort(403, 'Accès non autorisé. Vous devez être connecté en tant que vendeur.');
        }
        
        return $user->id;
    }

    public function index()
    {
        $idVendeur = $this->getVendeurId();
        
        // Filtrer les produits par vendeur
        $produits = Produit::with('categorie')
                          ->where('idVendeur', $idVendeur)
                          ->get();
        $categories = Categorie::all();
        return view('creudProducts', compact('produits', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $idVendeur = $this->getVendeurId();
        
        $request->validate([
            'nom' => 'required|string|max:100',
            'prix' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'idCategorie' => 'required|integer',
            'dateAjout' => 'required|date',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Vérifier que le produit appartient au vendeur avant modification
        $produit = Produit::where('id', $id)
                         ->where('idVendeur', $idVendeur)
                         ->firstOrFail();
        
        // Mettre à jour les champs de base
        $produit->nom = $request->nom;
        $produit->prix = $request->prix;
        $produit->stock = $request->stock;
        $produit->idCategorie = $request->idCategorie;
        $produit->dateAjout = $request->dateAjout;
        
        // Gérer l'upload de la nouvelle image si elle existe
        if ($request->hasFile('image')) {
            // Supprimer l'ancienne image si elle existe
            if ($produit->image && file_exists(public_path('image/' . $produit->image))) {
                unlink(public_path('image/' . $produit->image));
            }
            
            // Stocker la nouvelle image dans public/image
            $image = $request->file('image');
            $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $image->move(public_path('image'), $imageName);
            $produit->image = $imageName;
        }
        
        $produit->save();
        
        return redirect()->route('produits.index')->with('success', 'Produit modifié avec succès.');
    }

    public function destroy($id)
    {
        $idVendeur = $this->getVendeurId();
        
        // Vérifier que le produit appartient au vendeur avant suppression
        $produit = Produit::where('id', $id)
                         ->where('idVendeur', $idVendeur)
                         ->firstOrFail();
        
        // Supprimer l'image associée
        if ($produit->image && file_exists(public_path('image/' . $produit->image))) {
            unlink(public_path('image/' . $produit->image));
        }
        
        $produit->delete();
        return redirect()->route('produits.index')->with('success', 'Produit supprimé avec succès.');
    }

    public function store(Request $request) 
    {
        $idVendeur = $this->getVendeurId();
        
        $request->validate([
            'productName' => 'required|string|max:100',
            'productDescription' => 'nullable|string',
            'productPrice' => 'required|numeric|min:0',
            'productStock' => 'required|integer|min:0',
            'productColor' => 'required|string|max:50',
            'productSize' => 'required|string|max:10',
            'productImage' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'productCategory' => 'required|string',
        ]);

        // Stocker l'image dans public/image
        $image = $request->file('productImage');
        $imageName = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
        $image->move(public_path('image'), $imageName);

        // Correspondance manuelle entre nom et ID de catégorie
        $categoriesMap = [
            'hommes' => 1,
            'femmes' => 2,
            'babies' => 3,
            'enfants' => 4,
        ];

        $selectedCategory = strtolower(trim($request->productCategory));
        $idCategorie = $categoriesMap[$selectedCategory] ?? null;

        if (!$idCategorie) {
            return redirect()->back()->withErrors(['productCategory' => 'Catégorie invalide.']);
        }

        $produit = new Produit();
        $produit->idVendeur = $idVendeur; // Utiliser l'ID du vendeur connecté
        $produit->idCategorie = $idCategorie;
        $produit->nom = $request->productName;
        $produit->description = $request->productDescription;
        $produit->prix = $request->productPrice;
        $produit->stock = $request->productStock;
        $produit->couleur = $request->productColor;
        $produit->taille = $request->productSize;
        $produit->image = $imageName;
        $produit->save();

        return redirect()->back()->with('success', 'Produit ajouté avec succès.');
    }
}