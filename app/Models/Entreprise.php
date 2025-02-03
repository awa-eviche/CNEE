<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Entreprise extends Model
{
    use HasFactory;
    
        public $timestamps = false;
        protected $fillable = [
            "nomentreprise",
            "activite",
            "secteur",
            "nombreemployer",
            "tel",
            "region",
            "departement",
            "formj",
            "adresse",
            "email",
            "ninea",
            "regitcom",
            "dossier",

            
           
           
        ];
}
