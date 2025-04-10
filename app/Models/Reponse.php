<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entreprise;
use App\Models\Demande;
use App\Models\DemandeurProfil;
class Reponse extends Model
{
    use HasFactory;
    protected $fillable = [
        'demandeur_profil_id', 
        'demande_id',
        'entreprise_id',
        'checked',
    ];
    public function entreprise()
{
    return $this->belongsTo(Entreprise::class);
}
public function demande()
{
    return $this->belongsTo(Demande::class);
}
public function demandeurprofil()
{
    return $this->belongsTo(DemandeurProfil::class, 'demandeur_profil_id');
}

}
