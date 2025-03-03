<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Profil;
use App\Models\Demande; 
use App\Models\Entreprise; 
class ProfilController extends Controller
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
        $profils = Profil::all();
        return view('profil.index', compact('profils','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
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
        $profils = Profil::all();
        return view('profil.create', compact('profils','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
           
            'libelle' => 'required|string|unique:profils,libelle|max:255',

        ]);
        $profil = Profil::create($request->all());
        return redirect()->route('profil.index', compact('profil'))
          ->with('success', 'profil créé avec succès.');
    }
   

    public function edit(Profil $profil)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
  
        return view('profil.edit', compact('profil','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function update(Request $request, Profil $profil)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
           
        ]);

        $profil->update($request->all());

        return redirect()->route('profil.index')
                         ->with('success', 'profil mis à jour avec succès.');
    }

    public function destroy(Profil $profil)
    {
          
        $profil->delete();

        return redirect()->route('profil.index')
                         ->with('success', 'Profil supprimé avec succès.');
    }

}
