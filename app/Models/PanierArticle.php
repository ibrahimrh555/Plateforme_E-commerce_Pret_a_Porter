<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PanierArticle extends Model
{
    use HasFactory;

    protected $table = 'panier_articles';

    protected $primaryKey = 'id';

    protected $fillable = [
        'idPanier',
        'idProduit',
        'quantite'
    ];

    public $timestamps = false;

    public function panier()
    {
        return $this->belongsTo(Panier::class, 'idPanier', 'id');
    }

    public function produit()
    {
        return $this->belongsTo(Produit::class, 'idProduit', 'id');
    }
}
