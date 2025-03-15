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
       
        $secteurs = Secteur::all();
        return view('secteur.index', compact('secteurs'));
    }

    public function create()
    {
        $secteurs = Secteur::all();
       
        return view('secteur.create', compact('secteurs'));
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
       
  
        return view('secteur.edit', compact('secteur'));
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
