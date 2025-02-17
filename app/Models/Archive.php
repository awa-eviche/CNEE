<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\Fichier;
class Archive extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $fillable = [
        "type",
        "file",
        "dureeConv",
        "anneeAdhesion",
        "entreprise_id",

    ];
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
    public function fichiers()
{
    return $this->hasMany(Fichier::class);
}
}
