<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Demandeur extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "nom",
        "prenom",
        "sexe",
        "region",
        "departement",
        "cni",
        "datenaissance",
        "lieunaissance",
        "adresse",
        "email",
       
       
    ];

  

    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

    public function niveaux()
    {
        return $this->belongsTo(Niveaux::class);
    }

}

