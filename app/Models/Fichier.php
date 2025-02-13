<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Archive;
use App\Models\Fichier;
class Fichier extends Model
{
    use HasFactory;
    protected $fillable = [
        "type",
        "file",
        "archive_id",

    ];

    public function archive()
{
    return $this->belongsTo(Archive::class);
}

}
