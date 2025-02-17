<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Niveaux; 
use App\Models\Profil; 
use App\Models\Demandeur;
use App\Models\DemandeurProfil;

class DemandeurProfilController extends Controller
{
    public function index()
    {
        $demandeurprofil=DemandeurProfil::all();
        
        return view('demandeurprofil.index',compact('demandeurprofil'));
    }
    public function create($demandeur_id)
    {
        $demandeur = Demandeur::findOrFail($demandeur_id); // Vérifie que le demandeur existe
        $profiles = Profil::all();
        $niveaux = Niveaux::all();
        $demandeurprofils = DemandeurProfil::all();
    
        return view('demandeurprofil.create', compact('demandeur', 'profiles', 'niveaux', 'demandeurprofils'));
    }
    
    
    public function store(Request $request)
{
       //dd($request->all());
    $request->validate([
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id',
        'demandeur_id' => 'required|exists:demandeurs,id',
    ]);
  
    DemandeurProfil::create([
        'profil_id' => $request->profil_id,
        'niveaux_id' => $request->niveaux_id,
        'demandeur_id' => $request->demandeur_id, // Récupéré depuis le formulaire
    ]);

    return redirect()->route('demandeurprofil.index')
        ->with('success', 'Profil du demandeur créé avec succès.');


}
public function edit(DemandeurProfil $demandeurprofil)
{
    $demandeur = Demandeur::findOrFail($demandeur_id); // Vérifie que le demandeur existe
    $profiles = Profil::all();
    $niveaux = Niveaux::all();

    return view('demandeurprofil.edit', compact('demandeurprofil','profiles','niveaux','demandeur'));
}
public function update(Request $request, DemandeurProfil $demandeurprofil)
{
    $request->validate([
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id',
        'demandeur_id' => 'required|exists:demandeurs,id',
    ]);
   

    $demandeurprofil->update($request->all());

    return redirect()->route('demandeurprofil.index')
                     ->with('success', 'profil du demandeur mis à jour avec succès.');
}

}