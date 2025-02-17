<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Archive; 
use App\Models\Fichier; 
class FichierController extends Controller
{
    public function store(Request $request, Archive $archive)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'file' => 'required|file|max:2048',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file')->store('fichiers', 'public');
            $fichier = new Fichier();
            $fichier->type = $request->type;
            $fichier->file = $file;
            $fichier->archive_id = $archive->id;
            $fichier->save();
        }

        return redirect()->route('archive.show', $archive->id)->with('success', 'Nouveau fichier ajouté avec succès.');
    }
}
