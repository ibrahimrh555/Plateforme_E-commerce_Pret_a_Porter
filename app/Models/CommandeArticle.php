<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CommandeArticle extends Model
{
    protected $table = 'commande_articles'; 

    protected $fillable = [
        'idCommande',
        'idProduit',
        'quantite',
        'prix_unitaire',
        'total',
    ];

    public $timestamps = false;

    public function commande(): BelongsTo
    {
        return $this->belongsTo(Commande::class, 'idCommande');
    }

    public function produit(): BelongsTo
    {
        return $this->belongsTo(Produit::class, 'idProduit');
    }
}
