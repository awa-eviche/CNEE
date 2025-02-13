<?php

namespace App\Models;
use App\Models\Niveaux;
use App\Models\Profil;
use App\Models\Demandeur;


use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemandeurProfil extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $fillable = [
        "demandeur_id",
        "profil_id",
        "niveaux_id",
       
       
    ];

  
    public function demandeur()
    {
        return $this->belongsTo(Demandeur::class);
    }
    public function profil()
    {
        return $this->belongsTo(Profil::class);
    }

    public function niveaux()
    {
        return $this->belongsTo(Niveaux::class);
    }

}
