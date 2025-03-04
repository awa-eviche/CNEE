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
 public function index()
    {
        $entreprises = Entreprise::where('statut', 'validé')
            ->withCount('retenus') 
            ->get();
            $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
            Entreprise::where('is_new', true)->update(['is_new' => false]);
         $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
        $nouveauxEntreprises = $entreprisesEnAttente; 
        $demandeEnAttente = Demande::where('is_new', true)->count();
        Demande::where('is_new', true)->update(['is_new' => false]);
        $totalNotifications = $demandeEnAttente;
        $nouvellesDemandes = $demandeEnAttente; 
        return view('allocation.index', compact('entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }   
public function create($id)
{
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
    Entreprise::where('is_new', true)->update(['is_new' => false]);
 $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
$nouveauxEntreprises = $entreprisesEnAttente; 
$demandeEnAttente = Demande::where('is_new', true)->count();
Demande::where('is_new', true)->update(['is_new' => false]);
$totalNotifications = $demandeEnAttente;
$nouvellesDemandes = $demandeEnAttente; 
    $entreprise = Entreprise::findOrFail($id);
    $allocations = $entreprise->allocation()->where('entreprise_id', $id)->get();
    return view('allocation.create', compact('entreprise','allocations','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
}
public function afficher($id)
{
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
    Entreprise::where('is_new', true)->update(['is_new' => false]);
 $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
$nouveauxEntreprises = $entreprisesEnAttente; 
$demandeEnAttente = Demande::where('is_new', true)->count();
Demande::where('is_new', true)->update(['is_new' => false]);
$totalNotifications = $demandeEnAttente;
$nouvellesDemandes = $demandeEnAttente; 
    $dateAujourdhui = date('Y-m-d'); 

    $entreprise = Entreprise::findOrFail($id);
    $secteur = Secteur::all();
    $classification = Classification::all();
    $retenu = $entreprise->retenus()->whereDate('dateecheance', '>=', $dateAujourdhui)->get();

    return view('allocation.afficher', compact('entreprise', 'secteur', 'classification', 'retenu','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
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
        'mois' => 'required|in:Janvier,Février,Mars,Avril,Mai,Juin,Juillet,Aout,Septembre,Octobre,Novembre,Décembre',
    ]);
    $trimestres = [
        'Janvier' => 'Q1', 'Février' => 'Q1', 'Mars' => 'Q1',
        'Avril' => 'Q2', 'Mai' => 'Q2', 'Juin' => 'Q2',
        'Juillet' => 'Q3', 'Aout' => 'Q3', 'Septembre' => 'Q3',
        'Octobre' => 'Q4', 'Novembre' => 'Q4', 'Décembre' => 'Q4',
    ];

    $validatedData['trimestre'] = $trimestres[$validatedData['mois']];

    $archive = Archive::where('entreprise_id', $validatedData['entreprise_id'])->first();
    if (!$archive) {
        return redirect()->back()->with('error', 'Aucune archive trouvée pour cette entreprise.');
    }

    if (now()->toDateString() > $archive->finconvention) {
        return redirect()->route('allocation.index')->with('success', 'L\'enregistrement d\'allocations est impossible car la convention est expirée.');
    }

    $allocationCreated = Allocation::create($validatedData);

    if ($allocationCreated) {
        return redirect()->route('allocation.index')->with('success', 'Allocation ajoutée avec succès.');
    } else {
        return redirect()->back()->with('error', 'Une erreur est survenue lors de l\'enregistrement.');
    }
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
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
    Entreprise::where('is_new', true)->update(['is_new' => false]);
 $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
$nouveauxEntreprises = $entreprisesEnAttente; 
$demandeEnAttente = Demande::where('is_new', true)->count();
Demande::where('is_new', true)->update(['is_new' => false]);
$totalNotifications = $demandeEnAttente;
$nouvellesDemandes = $demandeEnAttente; 
    $montantsTrimestriels = $this->calculerMontantsParTrimestre($id);
    $montantAnnuel = $montantAnnuelData['montant_annuel'] ?? 0;
    $totalPartieEtat = $this->calculerTotalPartieEtat($id); 
    $entreprise = Entreprise::findOrFail($id);
    $allocations = $entreprise->allocation()->where('entreprise_id', $id)->get();
    $trimestre = ['Q1', 'Q2', 'Q3', 'Q4'];
    return view('allocation.montant', compact('entreprise', 'allocations', 'montantsTrimestriels', 'montantAnnuel', 'totalPartieEtat', 'trimestre','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
}


public function payerTrimestre(Request $request, $id, $trimestre)
{
    $allocations = Allocation::where('entreprise_id', $id)
        ->where('trimestre', $trimestre)
        ->where('paye', false)
        ->get();

    if ($allocations->isEmpty()) {
        return redirect()->back()->with('error', 'Aucune allocation trouvée pour ce trimestre.');
    }

    $montantTotalTrimestre = $allocations->sum('partieEtat');

    $totalPartieEtat = $this->calculerTotalPartieEtat($id);

    if ($montantTotalTrimestre > $totalPartieEtat) {
        return redirect()->back()->with('error', 'Le montant total à payer dépasse le total disponible.');
    }

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
