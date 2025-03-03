<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use App\Models\Archive; 
use App\Models\Demande; 
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class ArchiveController extends Controller
{
    
    public function index()
    {
        $entreprises = Entreprise::all();
        $archives = Archive::all(); 
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('archive.index', compact('entreprises', 'archives','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    public function create()
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        $entreprises = Entreprise::where('statut', 'validé')->get();
        return view('archive.create', compact('entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
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
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('archive.show',compact('archive','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    public function edit(Archive  $archive)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        $entreprises = Entreprise::all();
        return view('archive.edit', compact('archive','entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
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
                     ->with('success', 'archive supprimé avec succès.');
}

}
