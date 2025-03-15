<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Secteur;
class ArchiveRej extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "file",
        "secteur_id",  
     

    ];
    public function secteur()
    {
        return $this->belongsTo(Secteur::class);
    }
}
