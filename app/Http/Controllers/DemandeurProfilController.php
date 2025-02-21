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
    
        // Vérifier si le demandeur a déjà un profil joint
        $existingProfil = DemandeurProfil::where('demandeur_id', $demandeur_id)->exists();
    
        if ($existingProfil) {
            return redirect()->route('demandeur.index')->with('success', 'Ce demandeur a déjà un profil joint.');
        }
    
        $profiles = Profil::all();
        $niveaux = Niveaux::all();
    
        return view('demandeurprofil.create', compact('demandeur', 'profiles', 'niveaux'));
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
    return redirect()->route('demandeur.index')
        ->with('success', 'Profil du demandeur créé avec succès.');
}

public function show(DemandeurProfil $demandeurprofil)
{
    $demandeur = DemandeurProfil::where('id',$demandeurprofil->id)->firstOrFail();
    $profiles = Profil::all();
    $niveaux = Niveaux::all();
    return view('demandeurprofil.show',compact('demandeurprofil','demandeur','profiles','niveaux'));
}
public function edit(DemandeurProfil $demandeurprofil)
{
    $demandeur = DemandeurProfil::where('id',$demandeurprofil->id)->firstOrFail();
    $profiles = Profil::all();
    $niveaux = Niveaux::all();

    return view('demandeurprofil.edit', compact('demandeurprofil','profiles','niveaux','demandeur'));
}

public function update(Request $request, DemandeurProfil $demandeurprofil)
{
   
    $validatedData = $request->validate([
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id',
        'demandeur_id' => 'required|exists:demandeurs,id',
    ]);
   
    $demandeurprofil->update($validatedData);

    return redirect()->route('demandeurprofil.index')
                     ->with('success', 'Profil du demandeur mis à jour avec succès.');
}

public function destroy(DemandeurProfil $demandeurprofil)
{
      
    $demandeurprofil->delete();

    return redirect()->route('demandeurprofil.index')
                     ->with('success', 'Profil du Demandeur supprimé avec succès.');
}
}