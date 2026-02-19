<?php

use App\Http\Controllers\AccueilController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ProController;
use App\Http\Controllers\PanierController;
use App\Http\Controllers\CommController;
use App\Http\Controllers\authController;
use App\Http\Controllers\FavorisController;
use App\Http\Controllers\checkoutController;

use App\Http\Controllers\CommandeController;
use App\Http\Controllers\ProduitController;
use App\Http\Controllers\VenteController;
use App\Http\Controllers\SettingVendController;
use App\Http\Controllers\DashboardController;


Route::get('/', [DashboardController::class, 'dashboard']);
Route::get('/commandes', [CommandeController::class, 'index'])->name('commandes.index');

Route::put('/commandes/{id}', [CommandeController::class, 'update'])->name('commandes.update');
Route::delete('/commandes/{id}', [CommandeController::class, 'destroy'])->name('commandes.destroy');

//Routage de Creud des produits 

Route::get('/produits', [ProduitController::class, 'index'])->name('produits.index');
Route::put('/produits/{id}', [ProduitController::class, 'update'])->name('produits.update');
Route::delete('/produits/{id}', [ProduitController::class, 'destroy'])->name('produits.destroy');

//Route pour afficher seulement les clients de vendeur
Route::get('/vendeur/{id}/clients', [VenteController::class, 'clientsDuVendeur'])->name('vendeur.clients');

//Route pour settings de vendeur 
Route::get('/vendeur/{id}/settings', [SettingVendController::class, 'showSettings'])->name('vendeur.settings');
Route::post('/vendeur/{id}/update-password', [SettingVendController::class, 'updatePassword'])->name('vendeur.updatePassword');

//Route pour le formulaire d'ajout de produit dans le formulaire 
Route::post('/products', [ProduitController::class, 'store'])->name('products.store');

//Route pour le dashboard 
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

//route des ordres récnetes 
Route::get('/dashboard', [CommandeController::class, 'dernieresCommandesVendeur'])->name('dashboard');
Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');




//pour l inscription et connexion de client
Route::get('/register', [authController::class, 'showRegister'])->name('showRegister');
Route::get('/login', [authController::class, 'showLogin'])->name('showLogin');
Route::post('/register', [authController::class, 'Register'])->name('Register');
Route::post('/login', [authController::class, 'Login'])->name('Login');
Route::post('/logout', [authController::class, 'Logout'])->name('Logout');

//paiment
// Stripe routes
Route::post('/stripe/checkout', [checkoutController::class, 'Stripe'])->name('stripe.pay');
Route::get('/stripe/success', [checkoutController::class, 'StripeSuccess'])->name('stripe.success');
Route::get('/stripe/cancel', [checkoutController::class, 'StripeCancel'])->name('stripe.cancel');

// PayPal routes
Route::post('/paypal/checkout', [checkoutController::class, 'Paypal'])->name('paypal.pay');
Route::get('/paypal/success', [checkoutController::class, 'PaypalSuccess'])->name('paypal.success');
Route::get('/paypal/cancel', [checkoutController::class, 'PaypalCancel'])->name('paypal.cancel');

// Checkout UI
Route::get('/checkout/{idComm}', [checkoutController::class, 'checkout'])->name('checkout.view');


//lister les produits
Route::get('/', [AccueilController::class, 'index'])->name('accueil');
Route::get('/femmes', [AccueilController::class, 'afficherFemmes'])->name('femmes');
Route::get('/hommes', [AccueilController::class, 'afficherHommes'])->name('hommes');
Route::get('/enfants', [AccueilController::class, 'afficherEnfants'])->name('enfants');
Route::get('/bebe', [AccueilController::class, 'afficherBebe'])->name('bebe');
Route::middleware(['auth'])->group(function () {
    Route::post('/favoris/ajouter/{id}', [AccueilController::class, 'ajouterFavoris'])->name('favoris.ajouter');
    Route::post('/panier/ajouter', [AccueilController::class, 'ajouterPanier'])->name('panier.ajouter');
});




//le detail de produits
Route::post('/produitsdetail', [ProController::class, 'detail'])->name('produit.detail.post');



//pour les favoris
Route::middleware(['auth'])->group(function () {
    Route::get('/favoris', [FavorisController::class, 'index'])->name('favoris.index');
    Route::post('/favoris/ajouter/{idProduit}', [FavorisController::class, 'ajouterFavoris'])->name('favoris.ajouter');
    Route::delete('/favoris/supprimer/{idProduit}', [FavorisController::class, 'supprimerFavoris'])->name('favoris.supprimer');
    Route::post('/panier/ajouter', [FavorisController::class, 'ajouterPanier'])->name('panier.ajouter');
});



//pour le panier
Route::middleware(['auth'])->group(function () {
    Route::get('/panier', [PanierController::class, 'index'])->name('panier.index');
    Route::post('/panier/ajouter', [PanierController::class, 'ajouterPanier'])->name('panier.ajouter');
    Route::post('/panier/modifier-quantite', [PanierController::class, 'modifierQuantite'])->name('panier.modifier-quantite');
    Route::delete('/panier/supprimer/{id}', [PanierController::class, 'supprimerPanier'])->name('panier.supprimer');
    Route::post('/favoris/ajouter/{idProduit}', [PanierController::class, 'ajouterFavoris'])->name('favoris.ajouter');
});



//pour la commande
Route::post('/commande/passer', [CommController::class, 'passerCommande'])->name('commande.passer');
