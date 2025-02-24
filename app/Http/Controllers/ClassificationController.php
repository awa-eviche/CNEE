<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Classification;

class ClassificationController extends Controller
{
    public function index()
    {
        $classifications = Classification::all();
        return view('classification.index', compact('classifications'));
    }

    public function create()
    {
        $classifications = Classification::all();
        return view('classification.create', compact('classifications'));
    }

    public function store(Request $request)
    {
        
        $request->validate([
           
            'libelle' => 'required|string|unique:classifications,libelle|max:255',

        ]);
        $classification = Classification::create($request->all());
        return redirect()->route('classification.index', compact('classification'))
          ->with('success', 'Classification créé avec succès.');
    }
   

    public function edit(Classification $classification)
    {
        
  
        return view('classification.edit', compact('classification'));
    }

    public function update(Request $request, Classification $classification)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
           
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
