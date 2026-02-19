<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favoris extends Model
{
    protected $table = 'favoris';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function utilisateur()
    {
        return $this->belongsTo(User::class, 'idUtilisateur');
    }

    public function articles()
    {
        return $this->hasMany(FavorisArticles::class, 'idFavoris');
    }

    public function produits()
    {
        return $this->belongsToMany(Produit::class, 'favoris_articles', 'idFavoris', 'idProduit');
    }
}