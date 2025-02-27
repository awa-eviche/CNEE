<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\Entreprise;
use App\Models\Retenu;
use App\Models\Secteur;
use App\Models\Classification;
use App\Models\Archive;
class AllocationController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::where('statut', 'validé')
            ->withCount('retenus') 
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
        'partieEtat' => 'required',
        'ContrePartie' => 'required',
        'montantTotal' => 'required',
        'mois' => 'required',
    ]);

   
    $archive = Archive::where('entreprise_id', $request->entreprise_id)->first();
    if (!$archive) {
        return redirect()->back()->with('error', 'Aucune archive trouvée pour cette entreprise.');
    }

    $dateActuelle = date('Y-m-d');
    if ($dateActuelle > $archive->finconvention) {
        return redirect()->route('allocation.index')->with('success', 'L\'enregistrement d\'allocations est impossible car la convention est expirée.');
    }
    Allocation::create($validatedData);

    return redirect()->route('allocation.index')->with('success', 'Allocation ajoutée avec succès.');
}

public function calculerMontantsParTrimestre($id)
{
    
    $montantParTrimestre = [
        'Q1' => 0, 
        'Q2' => 0, 
        'Q3' => 0,
        'Q4' => 0,
        'message' => null
    ];

   
    $archive = Archive::where('entreprise_id', $id)->first();
    if (!$archive) {
        $montantParTrimestre['message'] = 'Aucune convention trouvée pour cette entreprise.';
        return $montantParTrimestre;
    }

    $dateFinConvention = $archive->finconvention; 
    $dateActuelle = date('Y-m-d');

    $estExpire = $dateActuelle > $dateFinConvention;

    $allocations = Allocation::where('entreprise_id', $id)->get();
    if ($allocations->isEmpty()) {
        $montantParTrimestre['message'] = 'Aucune allocation valide trouvée.';
        return $montantParTrimestre;
    }

    
    $moisMap = [
        'Janvier' => 1, 'Février' => 2, 'Mars' => 3,
        'Avril' => 4, 'Mai' => 5, 'Juin' => 6,
        'Juillet' => 7, 'Aout' => 8, 'Septembre' => 9,
        'Octobre' => 10, 'Novembre' => 11, 'Décembre' => 12,
    ];

    foreach ($allocations as $allocation) {
        $moisNom = $allocation->mois ?? null;
        $montant = floatval($allocation->partieEtat); 

        if ($moisNom && isset($moisMap[$moisNom])) {
            $mois = $moisMap[$moisNom];

            if ($mois >= 1 && $mois <= 3) {
                $montantParTrimestre['Q1'] += $montant;
            } elseif ($mois >= 4 && $mois <= 6) {
                $montantParTrimestre['Q2'] += $montant;
            } elseif ($mois >= 7 && $mois <= 9) {
                $montantParTrimestre['Q3'] += $montant;
            } elseif ($mois >= 10 && $mois <= 12) {
                $montantParTrimestre['Q4'] += $montant;
            }
        } else {
            error_log("Mois non reconnu: $moisNom");
        }
    }

    if ($estExpire) {
        $montantParTrimestre['message'] = ' La convention est expirée, mais voici les montants passés.';
    }

    return $montantParTrimestre;
}

public function calculerMontantAnnuel($id)
{
 
    $entreprise = Entreprise::find($id);
    if (!$entreprise) {
        return ['error' => 'Entreprise non trouvée.'];
    }
    $allocations = Allocation::where('entreprise_id', $id)->get();
    $montantAnnuel = 0;

    foreach ($allocations as $allocation) {
        $montantAnnuel += floatval($allocation->partieEtat);
    }

    return ['montant_annuel' => $montantAnnuel];
}
 
public function montant($id)
{
    $montantsTrimestriels = $this->calculerMontantsParTrimestre($id);
    $montantAnnuel = $this->calculerMontantAnnuel($id);
    $entreprise = Entreprise::findOrFail($id);
    $allocations = $entreprise->allocations;
    return view('allocation.montant', compact('entreprise','allocations','montantsTrimestriels','montantAnnuel'));
}

public function show(Allocation  $allocation)
{
    return view('allocation.show',compact('allocation'));
}
public function edit(Allocation $allocation)
{
    $entreprise = Entreprise::findOrFail($allocation->entreprise_id);
    $retenu = $entreprise->retenus()->first();
    $secteur = Secteur::all();
    $classification = Classification::all();
    return view('allocation.edit', compact('retenu', 'entreprise', 'allocation', 'secteur', 'classification'));
}

public function update(Request $request, Allocation $allocation)
{
    $archive = Archive::where('entreprise_id', $request->entreprise_id)->first();
    
    $validatedData = $request->validate([
        'entreprise_id' => 'required|exists:entreprises,id',
        'secteur_id' => 'required|exists:secteurs,id',
        'retenu_id' => 'required|exists:retenus,id',
        'classification_id' => 'required|exists:classifications,id',
        'partieEtat' => 'required',
        'ContrePartie' => 'required',
        'montantTotal' => 'required',
        'mois' => 'required',
    ]);

    if (!$archive) {
        return redirect()->back()->with('error', 'Aucune archive trouvée pour cette entreprise.');
    }

    $dateActuelle = date('Y-m-d');
    if ($dateActuelle > $archive->finconvention) {
        return redirect()->route('allocation.index')->with('error', 'La convention est expirée. Impossible de modifier l\'allocation.');
    }

    
    $allocation->update($validatedData);

    return redirect()->route('allocation.index')->with('success', 'Allocation mise à jour avec succès.');
}

}
