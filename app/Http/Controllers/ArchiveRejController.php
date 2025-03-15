<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArchiveRej;
use App\Models\Entreprise;
use App\Models\Demande;
use Illuminate\Support\Facades\Storage;

class ArchiveRejController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::all();
        $archiverej = ArchiveRej::all(); 
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
     Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('archiverej.index', compact('entreprises', 'archiverej','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
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
    $entreprises = Entreprise::where('statut', 'rejeté')->get();
        return view('archiverej.create', compact('entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'entreprise_id' => 'required|integer', 
            'file' => 'required|file|max:2048', 
            
           
        ]); 
        $archiverej = new ArchiveRej();
        $archiverej->type = $request->type;
        $archiverej->file = $request->file;
        $archiverej->entreprise_id = $request->entreprise_id;
       
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); 
            $file->storeAs('filerej', $filename, 'public'); 
            $archiverej->file = $filename; 
        }
        $archiverej->save();
        return redirect()->route('archiverej.index')->with('success', 'Archive enregistrée avec succès.');
    }
    
    public function show(Archiverej  $archiverej)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('archiverej.show',compact('archiverej','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    public function edit(Archiverej  $archiverej)
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
        return view('archiverej.edit', compact('archiverej','entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    public function update(Request $request, Archiverej $archiverej)
{
    
    $request->validate([
        'type' => 'required|string|max:255',
        'entreprise_id' => 'required|integer',
        'file' => 'required|file|max:2048', 
       
    ]);
    $archiverej->type = $request->type;
    $archiverej->entreprise_id = $request->entreprise_id;
   
  
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName(); 
        $file->storeAs('filerej', $filename, 'public'); 
        $archiverej->file = $filename; 
    }
    $archiverej->save();
    return redirect()->route('archiverej.index')->with('success', 'Archive mise à jour avec succès.');
}





}
