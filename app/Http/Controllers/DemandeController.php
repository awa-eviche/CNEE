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
    // Récupérer l'entreprise connectée
    $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();

    // Vérifier que l'entreprise est bien trouvée
    if (!$entreprise) {
        return back()->with('error', 'Entreprise non trouvée.');
    }

    // Validation des données
    $request->validate([
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id', // Correction ici
        'nbre_profil' => 'required|integer|min:1', // Correction du type attendu
    ]);

    // Création de la demande
    Demande::create([
        'profil_id' => $request->profil_id,
        'niveaux_id' => $request->niveaux_id,
        'entreprise_id' => $entreprise->id, // Utiliser l'entreprise connectée
        'nbre_profil' => $request->nbre_profil,
    ]);

    return redirect()->route('demande.index')
        ->with('success', 'Demande créée avec succès.');
}


}
