<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Secteur;
class Classification extends Model
{
    use HasFactory;
    protected $fillable = [
        "libelle",
       "secteur_id"
       
    ];

    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }
}
