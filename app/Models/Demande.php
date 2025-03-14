<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Niveaux;
use App\Models\Profil;
use App\Models\Entreprise;
use App\Models\Reponse;


class Demande extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "entreprise_id",
        "profil_id",
        "niveaux_id",
        "nbre_profil",
        'statut',

       
       
    ];

  

    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

    public function niveaux()
    {
        return $this->belongsTo(Niveaux::class);
    }

    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
    public function reponses()
{
    return $this->hasMany(Reponse::class, 'demande_id');
}


}

