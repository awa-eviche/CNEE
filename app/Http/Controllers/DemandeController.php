<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande; 
use App\Models\Entreprise;
use App\Models\Profil;
use App\Models\Niveaux;

class DemandeController extends Controller
{
    public function index()
    {
        $demande=Demande::all();
        return view('demande.index',compact('demande'));
    }

    public function create()
    {
        $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();
        $profiles = Profil::all();
        $niveaux = Niveaux::all();

        return view('demande.create', compact( 'profiles','niveaux','entreprise'));
    }

    public function store(Request $request)
{   
    


    $request->validate([
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id', // Correction du nom de table
        'entreprise_id' => 'required|exists:entreprises,id', // Correction de la table
        'date_demande' => 'required|string|max:255',
        'nbre_profil' => 'required|string|max:255',
    ]);

    Demande::create([
        'profil_id' => $request->profil_id,
        'niveaux_id' => $request->niveaux_id,
        'entreprise_id' => $request->entreprise_id,
        'date_demande' => $request->date_demande,
        'nbre_profil' => $request->nbre_profil,
    ]);

    return redirect()->route('demande.index')
        ->with('success', 'Demande créée avec succès.');
}

}
