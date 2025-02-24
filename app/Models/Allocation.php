<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Retenu;
use App\Models\Classification;
use App\Models\Secteur;
class Allocation extends Model
{
    use HasFactory;
    protected $fillable = [
        "entreprise_id",
        "retenu_id",
        "secteur_id",
        "classification_id",
        "datePriseEffet",
        "dateEcheance",
        "duree",
        "partieEtat",
        "ContrePartie",
        "montantTotal",
    ];
    public function classification()
    {
        return $this->belongsTo(Classification::class);
    }
    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
    public function retenu()
    {
        return $this->belongsTo(Retenu::class);
    }
   
}
