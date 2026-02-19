<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FavorisArticles extends Model
{
    protected $table = 'favoris_articles';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = ['idFavoris', 'idProduit'];

    public function favoris()
    {
        return $this->belongsTo(Favoris::class, 'idFavoris');
    }
    
    public function produit()
    {
        return $this->belongsTo(Produit::class, 'idProduit');
    }
}