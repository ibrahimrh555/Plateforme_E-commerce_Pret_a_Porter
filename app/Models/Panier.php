<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Panier extends Model
{
    use HasFactory;

    protected $table = 'paniers';

    protected $primaryKey = 'id';

    protected $fillable = [
        'idUtilisateur'
    ];

    public $timestamps = false;

    public function utilisateur()
    {
        return $this->belongsTo(Utilisateur::class, 'idUtilisateur', 'id');
    }

    public function articles()
    {
        return $this->hasMany(PanierArticle::class, 'idPanier', 'id');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'panier_articles', 'idPanier', 'idProduit')
                    ->withPivot('quantite');
    }
}
