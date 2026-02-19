<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Commande extends Model
{
    protected $table = 'commandes';
    
    protected $fillable = [
        'idUtilisateur',
        'date_commandes',
        'statut',
        'total',
    ];
    
    public $timestamps = false;
    
    public function utilisateur(): BelongsTo
    {
        return $this->belongsTo(Utilisateur::class, 'idUtilisateur');
    }
    
    public function articles(): HasMany
    {
        return $this->hasMany(CommandeArticle::class, 'idCommande');
    }
    
    // Relation pour accéder directement aux produits via les articles
    public function produits()
    {
        return $this->hasManyThrough(
            Produit::class,
            CommandeArticle::class,
            'idCommande', // Clé étrangère sur commande_articles
            'id', // Clé primaire sur produits
            'id', // Clé primaire sur commandes
            'idProduit' // Clé étrangère sur commande_articles pointant vers produits
        );
    }
} 