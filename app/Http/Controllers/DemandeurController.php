<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DemandeurImport;
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
        'prenom' => 'required|string|max:255',
        'sexe' => 'required|string|max:255',
        'datenaissance' => 'required|string|max:255',
        'lieunaissance' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'region' => 'required|string|max:255',
        'departement' => 'required|string|max:255',
      
      
    ]);

    
    $data = $request->all();

   
    if ($request->hasFile('cv')) {
        $filename = $request->file('cv')->store('upload', 'public');
        $data['cv'] = $filename; 
    }
    $demandeur = Demandeur::create($data);
    return redirect()->route('demandeur.index')
        ->with('success', 'Demandeur créé avec succès.');
}

    public function edit(Demandeur $demandeur)
    {
        
  
        return view('demandeur.edit', compact('demandeur'));
    }

    public function update(Request $request, Demandeur $demandeur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'datenaissance' => 'required|string|max:255',
            'lieunaissance' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'cni' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
           
           
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

    public function show(Demandeur $demandeur)
    {
       
        return view('demandeur.show',compact('demandeur'));
    }


    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,csv',
        ]);
    
        Excel::import(new DemandeurImport, $request->file('file'));
    
        return back()->with('success', 'Importation réussie !');
    }



}
