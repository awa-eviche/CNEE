<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\Retenu;
use App\Models\Allocation;
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
            "quitus", 
            "attestation", 
             
        ];
        public function archives()
    {
        return $this->hasMany(Archive::class);
    }

    public function user()
{
    return $this->belongsTo(User::class);
}
public function retenus()
{
    return $this->hasMany(Retenu::class);
}
public function allocations()
{
    return $this->hasMany(Allocation::class);
}

}
