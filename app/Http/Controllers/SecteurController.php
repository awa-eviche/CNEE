<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secteur;
use App\Models\Demande;
use App\Models\Entreprise;

class SecteurController extends Controller
{
    public function index()
    {   
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        $secteurs = Secteur::all();
        return view('secteur.index', compact('secteurs','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function create()
    {
        $secteurs = Secteur::all();
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('secteur.create', compact('secteurs','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
           
            'libelle' => 'required|string|unique:Secteurs,libelle|max:255',

        ]);
        $secteur = Secteur::create($request->all());
        return redirect()->route('secteur.index', compact('secteur'))
          ->with('success', 'Secteur créé avec succès.');
    }
   

    public function edit(Secteur $secteur)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
  
        return view('secteur.edit', compact('secteur','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function update(Request $request, Secteur $secteur)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
           
        ]);

        $secteur->update($request->all());

        return redirect()->route('secteur.index')
                         ->with('success', 'Secteur mis à jour avec succès.');
    }

    public function destroy(Secteur $secteur)
    {
          
        $secteur->delete();

        return redirect()->route('secteur.index')
                         ->with('success', 'secteur supprimé avec succès.');
    }

}
