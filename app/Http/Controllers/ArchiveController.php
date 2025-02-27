<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use App\Models\Archive; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArchiveController extends Controller
{
    
    public function index()
    {
        $entreprises = Entreprise::all();
        $archives = Archive::all(); 
        return view('archive.index', compact('entreprises', 'archives'));
    }
    public function create()
    {
        $entreprises = Entreprise::where('statut', 'validé')->get();
        return view('archive.create', compact('entreprises'));
    }
    
    public function store(Request $request)
{
    $request->validate([
        'type' => 'required|string|max:255',
        'entreprise_id' => 'required|integer', 
        'file' => 'required|file|max:2048', 
        'dureeConv' => 'required|string|max:255',
        'anneeAdhesion' => 'required|integer', 
        'debutconvention' => 'required', 
        'finconvention' => 'required', 
       
    ]); 
    $archive = new Archive();
    $archive->type = $request->type;
    $archive->entreprise_id = $request->entreprise_id;
    $archive->dureeConv = $request->dureeConv;
    $archive->anneeAdhesion = $request->anneeAdhesion;
    $archive->debutconvention = $request->debutconvention;
    $archive->finconvention = $request->finconvention;
    if ($request->hasFile('file')) {
        $filename = $request->file('file')->store('files', 'public');
        $archive->file = $filename; 
    }
    $archive->save();
    return redirect()->route('archive.index')->with('success', 'Archive enregistrée avec succès.');
}


    public function show(Archive  $archive)
    {
        return view('archive.show',compact('archive'));
    }
    public function edit(Archive  $archive)
    {
        $entreprises = Entreprise::all();
        return view('archive.edit', compact('archive','entreprises'));
    }
    public function update(Request $request, Archive $archive)
{
    
    $request->validate([
        'type' => 'required|string|max:255',
        'entreprise_id' => 'required|integer',
        'file' => 'required|file|max:2048', 
        'dureeConv' => 'required|string|max:255',
        'anneeAdhesion' => 'required|integer', 
        'debutconvention' => 'required', 
        'finconvention' => 'required', 
    ]);
    $archive->type = $request->type;
    $archive->entreprise_id = $request->entreprise_id;
    $archive->dureeConv = $request->dureeConv;
    $archive->anneeAdhesion = $request->anneeAdhesion;
    $archive->debutconvention = $request->debutconvention;
    $archive->finconvention = $request->finconvention;
    if ($request->hasFile('file')) {
        if ($archive->file) {
            Storage::disk('public')->delete($archive->file);
        }
        $filename = $request->file('file')->store('files', 'public');
        $archive->file = $filename;
    }
    $archive->save();
    return redirect()->route('archive.index')->with('success', 'Archive mise à jour avec succès.');
}

public function destroy(Archive $archive)
{
    $archive->delete();

    return redirect()->route('archive.index')
                     ->with('success', 'archiv
                     e supprimé avec succès.');
}

}
