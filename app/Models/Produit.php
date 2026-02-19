<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Produit extends Model
{
    use HasFactory;

    protected $table = 'produits'; // ← si ta table s'appelle "produits"

    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'idVendeur',
        'idCategorie',
        'nom',
        'description',
        'prix',
        'stock',
        'couleur',
        'taille',
        'image',
    ];

    public function favorisArticles()
    {
        return $this->hasMany(FavorisArticles::class, 'idProduit');
    }

    
    public function utilisateursFavoris()
    {
        return $this->belongsToMany(User::class, 'favoris_articles', 'idProduit', 'idFavoris')
                    ->join('favoris', 'favoris_articles.idFavoris', '=', 'favoris.id')
                    ->where('favoris.idUtilisateur', '=', 'utilisateurs.id');
    }


    public function panierArticles()
    {
        return $this->hasMany(PanierArticle::class, 'idProduit', 'id');
    }


    public function categorie()
    {
        return $this->belongsTo(Categorie::class, 'idCategorie');
    }
    public function vendeur()
    {
        return $this->belongsTo(Utilisateur::class, 'idVendeur');
    }




}

