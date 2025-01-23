<?php

namespace App\Http\Controllers;
use App\Models\Niveaux; 
use Illuminate\Http\Request;

class NiveauxController extends Controller
{
    public function index()
    {
        $niveau=Niveaux::all();
        return view('niveau.index',compact('niveau'));
    }
    public function create()
    {
          
        return view('niveau.create');
    }
    public function store(Request $request)
    {
        
        $request->validate([
           
            'libelle' => 'required|string|unique:niveauxes,libelle|max:255',

        ]);
        $niveau = Niveaux::create($request->all());
        return redirect()->route('niveau.index', compact('niveau'))
          ->with('success', 'niveau créé avec succès.');
    }

    public function edit(Niveaux $niveau)
    {
        
  
        return view('niveau.edit', compact('niveau'));
    }

    public function update(Request $request, Niveaux $niveau)
    {
        $request->validate([
            'libelle' => 'required|string|max:255',
           
        ]);

        $niveau->update($request->all());

        return redirect()->route('niveau.index')
                         ->with('success', 'niveau mis à jour avec succès.');
    }

    public function destroy(Niveaux $niveau)
    {
          
        $niveau->delete();

        return redirect()->route('niveau.index')
                         ->with('success', 'Niveau supprimé avec succès.');
    }

}
