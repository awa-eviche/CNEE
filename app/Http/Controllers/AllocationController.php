<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Allocation;
use App\Models\Entreprise;
use App\Models\Demande;
use App\Models\Retenu;
use App\Models\Secteur;
use App\Models\Classification;
use App\Models\Archive;
class AllocationController extends Controller
{
 public function index(Request $request)
    {  
        

        $entreprises = Entreprise::where('statut', 'validé')
            ->withCount('retenus') 
            ->get();
         
        return view('allocation.index', compact('entreprises'));
    }   
public function create($id)
{
   
    $entreprise = Entreprise::findOrFail($id);
    $allocations = $entreprise->allocation()->where('entreprise_id', $id)->get();
    return view('allocation.create', compact('entreprise','allocations'));
}
public function afficher($id)
{
    
    $dateAujourdhui = date('Y-m-d'); 

    $entreprise = Entreprise::findOrFail($id);
    $secteur = Secteur::all();
    $classification = Classification::all();
    $retenu = $entreprise->retenus()->whereDate('dateecheance', '>=', $dateAujourdhui)->get();

    return view('allocation.afficher', compact('entreprise', 'secteur', 'classification', 'retenu'));
}

public function store(Request $request)
{
    // Validation en précisant que 'mois' est un tableau
    $validatedData = $request->validate([
        'entreprise_id'     => 'required|exists:entreprises,id',
        'secteur_id'        => 'required|exists:secteurs,id',
        'retenu_id'         => 'required|exists:retenus,id',
        'classification_id' => 'required|exists:classifications,id',
        'partieEtat'        => 'required|numeric',
        'ContrePartie'      => 'required|numeric',
        'montantTotal'      => 'required|numeric',
        'mois'              => 'required|array|min:1',
        'mois.*'            => 'in:Janvier,Février,Mars,Avril,Mai,Juin,Juillet,Aout,Septembre,Octobre,Novembre,Décembre',
    ]);

    // Calculer le multiplicateur en fonction du nombre de mois sélectionnés
    $multiplier = count($validatedData['mois']);

    // Multiplier les valeurs saisies pour correspondre aux mois sélectionnés
    $validatedData['ContrePartie'] = $validatedData['ContrePartie'] * $multiplier;
    $validatedData['partieEtat']     = $validatedData['partieEtat'] * $multiplier;

    // Définir le trimestre à partir du premier mois sélectionné
    $trimestres = [
        'Janvier'   => 'Q1', 'Février'  => 'Q1', 'Mars'     => 'Q1',
        'Avril'     => 'Q2', 'Mai'      => 'Q2', 'Juin'     => 'Q2',
        'Juillet'   => 'Q3', 'Aout'     => 'Q3', 'Septembre'=> 'Q3',
        'Octobre'   => 'Q4', 'Novembre' => 'Q4', 'Décembre' => 'Q4',
    ];
    $premierMois = $validatedData['mois'][0];
    $validatedData['trimestre'] = $trimestres[$premierMois];

    // Vérifier l'existence d'une archive et la validité de la convention
    $archive = Archive::where('entreprise_id', $validatedData['entreprise_id'])->first();
    if (!$archive) {
        return redirect()->back()->with('error', 'Aucune archive trouvée pour cette entreprise.');
    }
    if (now()->toDateString() > $archive->finconvention) {
        return redirect()->route('allocation.index')
                         ->with('success', 'L\'enregistrement d\'allocations est impossible car la convention est expirée.');
    }

    // Joindre les mois sélectionnés dans une seule chaîne, par exemple "Janvier, Février, Mars"
    $validatedData['mois'] = implode(', ', $validatedData['mois']);

    // Créer une seule allocation avec tous les mois dans la même colonne
    Allocation::create($validatedData);

    return redirect()->route('allocation.index')
                     ->with('success', 'Allocation ajoutée avec succès.');
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

    // Utiliser le champ 'trimestre' défini lors de l'enregistrement
    foreach ($allocations as $allocation) {
        $trimestreAllocation = $allocation->trimestre;
        $montant = floatval($allocation->partieEtat);
        if (isset($montantParTrimestre[$trimestreAllocation])) {
            $montantParTrimestre[$trimestreAllocation] += $montant;
        } else {
            error_log("Trimestre non reconnu: $trimestreAllocation");
        }
    }

    if ($estExpire) {
        $montantParTrimestre['message'] = 'La convention est expirée, mais voici les montants passés.';
    }

    return $montantParTrimestre;
}


public function calculerTotalPartieEtat($id)
{
    $entreprise = Entreprise::find($id);
    if (!$entreprise) {
        return 0; 
    }

    // Total avant paiement
    $totalAvantPaiement = Allocation::where('entreprise_id', $id)->sum('partieEtat');

    // Total déjà payé
    $totalPaye = Allocation::where('entreprise_id', $id)
        ->where('paye', true)
        ->sum('partieEtat');

    // Montant restant
    return $totalAvantPaiement - $totalPaye;
}


 
public function montant($id)
{
   
    $montantsTrimestriels = $this->calculerMontantsParTrimestre($id);
    $montantAnnuel = $montantAnnuelData['montant_annuel'] ?? 0;
    $totalPartieEtat = $this->calculerTotalPartieEtat($id); 
    $entreprise = Entreprise::findOrFail($id);
    $allocations = $entreprise->allocation()->where('entreprise_id', $id)->get();
    $trimestre = ['Q1', 'Q2', 'Q3', 'Q4'];
    return view('allocation.montant', compact('entreprise', 'allocations', 'montantsTrimestriels', 'montantAnnuel', 'totalPartieEtat', 'trimestre'));
}


public function payerTrimestre(Request $request, $id, $trimestre)
{
    // Récupérer les allocations non payées pour le trimestre donné
    $allocations = Allocation::where('entreprise_id', $id)
        ->where('trimestre', $trimestre)
        ->where('paye', false)
        ->get();

    if ($allocations->isEmpty()) {
        return redirect()->back()->with('error', 'Aucune allocation trouvée pour ce trimestre.');
    }

    // Calculer le montant total du trimestre (le champ partieEtat contient déjà le montant total pour l'allocation)
    $montantTotalTrimestre = $allocations->sum('partieEtat');

    // Calculer le montant total restant de l'entreprise avant paiement
    $totalPartieEtat = $this->calculerTotalPartieEtat($id);

    if ($montantTotalTrimestre > $totalPartieEtat) {
        return redirect()->back()->with('error', 'Le montant total à payer dépasse le total disponible.');
    }

    // Marquer chaque allocation comme payée
    foreach ($allocations as $allocation) {
        $allocation->paye = true;
        $allocation->montant_paye = $allocation->partieEtat; 
        $allocation->partieEtat = 0; 
        $allocation->save();
    }

    return redirect()->back()
        ->with('success', "Paiement effectué pour le trimestre $trimestre.")
        ->with('montantTotalTrimestre', $montantTotalTrimestre)
        ->with('trimestre_paye', $trimestre);
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
