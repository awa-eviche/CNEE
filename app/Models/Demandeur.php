<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Niveaux;
use App\Models\Profil;

class Demandeur extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "nom",
        "prenom",
        "sexe",
        "datenaissance",
        "lieunaissance",
        "adresse",
        "email",
        "profil_id",
        "niveaux_id",
        "cv",
       
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

