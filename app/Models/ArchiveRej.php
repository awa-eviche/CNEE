<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Entreprise;
class ArchiveRej extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "file",
        "entreprise_id",  
     

    ];
    public function entreprise()
    {
        return $this->belongsTo(Entreprise::class);
    }
}
