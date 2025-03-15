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
       
        $profils = Profil::all();
        return view('profil.index', compact('profils'));
    }

    public function create()
    {
        
        $profils = Profil::all();
        return view('profil.create', compact('profils'));
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
       
  
        return view('profil.edit', compact('profil'));
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
