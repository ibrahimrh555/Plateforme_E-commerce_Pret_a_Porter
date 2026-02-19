<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Commande;
use App\Models\CommandeArticle;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function dashboard()
    {
        // Récupérer l'ID du vendeur connecté
        $idVendeur = Auth::user()->id;
        $now = Carbon::now();

        // 🏆 Produits les plus vendus
        $produitsPlusVendus = CommandeArticle::select('produits.id', 'produits.nom', 'produits.image', DB::raw('SUM(commande_articles.quantite) as total_vendu'))
            ->join('produits', 'commande_articles.idProduit', '=', 'produits.id')
            ->join('commandes', 'commande_articles.idCommande', '=', 'commandes.id')
            ->where('produits.idVendeur', $idVendeur)
            ->where('commandes.statut', 'livrée')
            ->groupBy('produits.id', 'produits.nom', 'produits.image')
            ->orderByDesc('total_vendu')
            ->limit(3)
            ->get();

        // 🕓 5 dernières commandes
        $commandes = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                $query->where('idVendeur', $idVendeur);
            })
            ->with(['articles.produit', 'utilisateur'])
            ->orderByDesc('date_commandes')
            ->take(5)
            ->get();

        // 💰 Ventes totales du mois
        $ventesTotal = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                $query->where('idVendeur', $idVendeur);
            })
            ->where('statut', 'livrée')
            ->whereMonth('date_commandes', $now->month)
            ->whereYear('date_commandes', $now->year)
            ->sum('total');

        // 📦 Nombre de commandes livrées du mois
        $nombreCommandes = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                $query->where('idVendeur', $idVendeur);
            })
            ->where('statut', 'livrée')
            ->whereMonth('date_commandes', $now->month)
            ->whereYear('date_commandes', $now->year)
            ->count();

        // 👥 Nombre de clients uniques du mois
        $nombreClients = Commande::whereHas('articles.produit', function ($query) use ($idVendeur) {
                $query->where('idVendeur', $idVendeur);
            })
            ->where('statut', 'livrée')
            ->whereMonth('date_commandes', $now->month)
            ->whereYear('date_commandes', $now->year)
            ->distinct('idUtilisateur')
            ->count('idUtilisateur');

        // 📊 Statistiques pour les cercles
        $pourcentageVentes = $ventesTotal > 0 ? min(100, ($ventesTotal / 30000) * 100) : 0;
        $pourcentageCommandes = $nombreCommandes > 0 ? min(100, ($nombreCommandes / 300) * 100) : 0;
        $pourcentageClients = $nombreClients > 0 ? min(100, ($nombreClients / 100) * 100) : 0;

        // 📈 Graphique des commandes du mois actuel (par jour)
        $commandesMois = Commande::select(DB::raw('DATE(commandes.date_commandes) as date'), DB::raw('COUNT(*) as total'))
            ->join('commande_articles', 'commandes.id', '=', 'commande_articles.idCommande')
            ->join('produits', 'commande_articles.idProduit', '=', 'produits.id')
            ->where('produits.idVendeur', $idVendeur)
            ->whereMonth('commandes.date_commandes', $now->month)
            ->whereYear('commandes.date_commandes', $now->year)
            ->groupBy(DB::raw('DATE(commandes.date_commandes)'))
            ->orderBy('date')
            ->get();

        $dates = $commandesMois->pluck('date')->map(function ($date) {
            return Carbon::parse($date)->format('d M');
        });
        $totals = $commandesMois->pluck('total');

        return view('dashboard', compact(
            'produitsPlusVendus',
            'commandes',
            'ventesTotal',
            'nombreCommandes',
            'nombreClients',
            'pourcentageVentes',
            'pourcentageCommandes',
            'pourcentageClients',
            'dates',
            'totals'
        ));
    }
}