<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
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
        public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
}
