<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande; 
use App\Models\Entreprise; 
use App\Models\Classification;
use App\Models\Secteur;

class ClassificationController extends Controller
{
    public function index()
    {
        $secteurs=Secteur::all();
      
        $classifications = Classification::all();
        return view('classification.index', compact('classifications','secteurs'));
    }

    public function create()
    {
        $secteurs=Secteur::all();
      
        $classifications = Classification::all();
        return view('classification.create', compact('classifications','secteurs'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
           
            'libelle' => 'required|string|unique:classifications,libelle|max:255',
            'secteur_id' => 'required|string',
        ]);
        $classification = Classification::create($request->all());
        return redirect()->route('classification.index', compact('classification'))
          ->with('success', 'Classification créé avec succès.');
    }
   

    public function edit(Classification $classification)
    {
        $secteurs=Secteur::all();
       
        return view('classification.edit', compact('classification','secteurs'));
    }

    public function update(Request $request, Classification $classification)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
           'secteur_id' => 'required|string',
        ]);

        $classification->update($request->all());

        return redirect()->route('classification.index')
                         ->with('success', 'Classification mis à jour avec succès.');
    }

    public function destroy(Classification $classification)
    {
          
        $classification->delete();

        return redirect()->route('classification.index')
                         ->with('success', 'Classification supprimé avec succès.');
    }

}
