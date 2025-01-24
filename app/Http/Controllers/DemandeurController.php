<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niveaux; 
use App\Models\Profil; 
use App\Models\Demandeur; 

class DemandeurController extends Controller
{
    public function index()
    {
        $demandeur=Demandeur::all();
        return view('demandeur.index',compact('demandeur'));
    }

    public function create()
    {
        $demandeurs = Demandeur::all();
        $profiles = Profil::all();
        $niveaus = Niveaux::all();

        return view('demandeur.create', compact('demandeurs', 'profiles','niveaus'));
    }

    public function store(Request $request)
    {
        $request->validate([
           
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'datenaissance' => 'required|string|max:255',
            'lieunaissance' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',

            'profil_id' => 'required|string',
            'niveaux_id' => 'required|string',
            'cv' => 'required|mimes:pdf|max:2048',

        ]);
        $data = $request->all();
        if ($request->hasFile('cv')) {
            $cvFile = $request->file('cv');
            $fileName = time() . '_' . $cvFile->getClientOriginalName(); // Nom unique
            $filePath = $cvFile->storeAs('uploads/cv', $fileName, 'public'); // Chemin de stockage
    
            $data['cv'] = $filePath; // Ajout du chemin dans les données
        }
        $demande = Demandeur::create($request->all());
        


        return redirect()->route('demandeur.index')

            ->with('success', 'demandeur créé avec succès.');
    }

    public function edit(Demandeur $demandeur)
    {
        $profiles = Profil::all();
        $niveaus = Niveaux::all();
  
        return view('demandeur.edit', compact('demandeur','profiles','niveaus'));
    }

    public function update(Request $request, Demandeur $demandeur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'datenaissance' => 'required|string|max:255',
            'lieunaissance' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',

            'profil_id' => 'required|string',
            'niveaux_id' => 'required|string',
            'cv' => 'required|mimes:pdf|max:2048',
           
        ]);
       

        $demandeur->update($request->all());

        return redirect()->route('demandeur.index')
                         ->with('success', 'demandeur mis à jour avec succès.');
    }

    public function destroy(Demandeur $demandeur)
    {
          
        $demandeur->delete();

        return redirect()->route('demandeur.index')
                         ->with('success', 'Demandeur supprimé avec succès.');
    }

}
