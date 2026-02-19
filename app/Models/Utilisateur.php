<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;

class Utilisateur extends Authenticable
{
    protected $table = 'utilisateurs';

    protected $fillable = [
        'nom',
        'email',
        'motPasse',
        'adresse',
        'telephone',
        'role',
    ];

    protected $hidden = [
        'motPasse',
    ];

    public $timestamps = false;

    public function getAuthPassword()
    {
        return $this->motPasse;
    }

    public function favoris()
    {
        return $this->hasOne(Favoris::class, 'idUtilisateur');
    }
    public function panier()
    {
        return $this->hasOne(Panier::class, 'idUtilisateur');
    }


    
    public function commandes()
    {
        return $this->hasMany(Commande::class, 'idUtilisateur');
    }

    public function produits()
    {
        return $this->hasMany(Produit::class, 'idVendeur');
    }
    

}

