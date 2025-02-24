<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\Entreprise;
use App\Models\Retenu;
use App\Models\Secteur;
use App\Models\Classification;
class AllocationController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::where('statut', 'validé')
            ->withCount('retenus') // Compte le nombre de demandeurs retenus
            ->get();
        
        return view('allocation.index', compact('entreprises'));
    }
    
    
public function create($id)
{
    $entreprise = Entreprise::findOrFail($id);
    $allocations = $entreprise->allocations;
    return view('allocation.create', compact('entreprise','allocations'));

}
public function afficher($id)
{
    $entreprise = Entreprise::findOrFail($id);
    $secteur=Secteur::all();
    $classification=Classification::all();
    $retenu = $entreprise->retenus;
    return view('allocation.afficher', compact('entreprise','secteur','classification','retenu'));
}

public function store(Request $request)
{
    $validatedData = $request->validate([
        'entreprise_id' => 'required|exists:entreprises,id',
        'secteur_id' => 'required|exists:secteurs,id',
        'retenu_id' => 'required|exists:retenus,id',
        'classification_id' => 'required|exists:classifications,id',
        'datePriseEffet' => 'required',
        'dateEcheance' =>'required',
        'duree' => 'required',
        'partieEtat' => 'required',
        'ContrePartie' => 'required',
        'montantTotal' => 'required',
    ]);
    Allocation::create($validatedData);
    return redirect()->route('allocation.index')->with('success', 'Allocation ajoutée avec succès.');
}


}
