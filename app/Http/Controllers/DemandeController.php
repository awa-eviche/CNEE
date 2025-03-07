<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande; 
use App\Models\Entreprise;
use App\Models\Profil;
use App\Models\Niveaux;
use App\Models\DemandeurProfil;
use App\Models\Retenu;

class DemandeController extends Controller
{
    public function index()
    {
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
    Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente;
        $user = auth()->user();
    
        if ($user->role->code === 'superadmin') {
            $demande = Demande::all();
        } else {
            
            $demande = Demande::whereHas('entreprise', function ($query) use ($user) {
                $query->where('nomentreprise', $user->name);
            })->get();
        }
       
        return view('demande.index', compact('demande' ,'entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    
    
    public function create()
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
         $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
        $nouveauxEntreprises = $entreprisesEnAttente; 
        $demandeEnAttente = Demande::where('is_new', true)->count();
        Demande::where('is_new', true)->update(['is_new' => false]);
        $totalNotifications = $demandeEnAttente;
        $nouvellesDemandes = $demandeEnAttente;
        $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();
        $profiles = Profil::all();
        $niveaux = Niveaux::all();
        return view('demande.create', compact( 'profiles','niveaux','entreprise' ,'entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function store(Request $request)
    {   
        $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();
        
        if (!$entreprise) {
            return back()->with('error', 'Entreprise non trouvée.');
        }

        $request->validate([
            'profil_id' => 'required|exists:profils,id',
            'niveaux_id' => 'required|exists:niveauxes,id', 
            'nbre_profil' => 'required|integer|min:1',
        ]);
    
        
        $demande = Demande::create([
            'profil_id' => $request->profil_id,
            'niveaux_id' => $request->niveaux_id,
            'entreprise_id' => $entreprise->id,
            'nbre_profil' => $request->nbre_profil,
            'is_new' => true, 
        ]);
    
        return redirect()->route('demande.index')
            ->with('success', 'Demande créée avec succès.');
    }
    



public function ListeEnvoye($id)
{
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
    Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente;
    $demande = Demande::with(['profil', 'niveaux'])->findOrFail($id);
    $demPro = DemandeurProfil::where('profil_id', $demande->profil_id)
    ->where('niveaux_id', $demande->niveaux_id)
    ->get();
    return view('demande.listeenvoye', compact('demande','demPro','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
}


public function enregistrerReponses(Request $request)
    {
        $request->validate([
            'demandeur_profils' => 'required|array',
            'demande_id' => 'required|exists:demandes,id',
            'entreprise_id' => 'required|exists:entreprises,id',
        ]);
        foreach ($request->demandeur_profils as $id) {
            \App\Models\Reponse::create([
                'demandeur_profil_id' => $id,
                'demande_id' => $request->demande_id,
                'entreprise_id' => $request->entreprise_id,
                'checked' => true,
              
            ]);
        }
         Demande::where('id', $request->demande_id)->update(['statut' => 'traité']);

        return redirect()->route('demande.index')
        ->with('success', 'Vos réponses sont envoyés avec succès.');     
    }
    public function listeReponses($demandeId = null)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
         $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
        $nouveauxEntreprises = $entreprisesEnAttente; 
        $demandeEnAttente = Demande::where('is_new', true)->count();
        Demande::where('is_new', true)->update(['is_new' => false]);
        $totalNotifications = $demandeEnAttente;
        $nouvellesDemandes = $demandeEnAttente;
        $userName = auth()->user()->name;
        $reponses = \App\Models\Reponse::whereHas('entreprise', function ($query) use ($userName) {
            $query->where('nomentreprise', $userName);
        })
        ->with(['demandeurprofil.demandeur', 'demande.profil', 'demande.niveaux'])
        ->get(); 
    
        $entreprise = \App\Models\Entreprise::where('nomentreprise', $userName)->first();
        $entrepriseId = $entreprise->id;
        if ($demandeId) {
            $reponses = $reponses->where('demande_id', $demandeId);
        }
    
        return view('demande.recu', compact('reponses', 'entrepriseId', 'demandeId','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    
    public function enregistrerRetenu(Request $request)
{
    // Validation des données
    $request->validate([
        'demandeur_profils' => 'required|array',
        'demande_id' => 'required|exists:demandes,id',
        'entreprise_id' => 'required|exists:entreprises,id',
        'date_prises_effet' => 'required|array',
        'date_echeances' => 'required|array',
    ]);

    // Enregistrement des demandeurs retenus
    foreach ($request->demandeur_profils as $id) {
        \App\Models\Retenu::create([
            'demandeur_profil_id' => $id,
            'demande_id' => $request->demande_id,
            'entreprise_id' => $request->entreprise_id,
            'checked' => true,
            'dateeffet' => $request->date_prises_effet[$id] ?? null,
            'dateecheance' => $request->date_echeances[$id] ?? null,
        ]);
    }
    $demande = \App\Models\Demande::find($request->demande_id);
    $demande->statut = 'retenu';
    $demande->save();

    return redirect()->route('demande.index')
        ->with('success', 'Les demandeurs retenus sont envoyés avec succès.');
}


public function listeRetenus()
{
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
    Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente;
    $user = auth()->user(); 

    if ($user->role->code === 'superadmin') {
   
        $retenus = Retenu::all();
    } else {
        $entreprise = Entreprise::where('nomentreprise', $user->name)->first();

        if (!$entreprise) {
            return redirect()->back()->with('error', 'Votre entreprise n\'a pas été trouvée.');
        }

        $retenus = Retenu::where('entreprise_id', $entreprise->id)->get();
    }

    return view('demande.retenu', compact('retenus','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
}

    public function listeRetenusDemandeur($id)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
         $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
        $nouveauxEntreprises = $entreprisesEnAttente; 
        $demandeEnAttente = Demande::where('is_new', true)->count();
        Demande::where('is_new', true)->update(['is_new' => false]);
        $totalNotifications = $demandeEnAttente;
        $nouvellesDemandes = $demandeEnAttente;
        $retenus = Retenu::findOrFail($id);
        return view('demande.demandeurretenu', compact('retenus','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }



public function show(Demande $demande)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
         $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
        $nouveauxEntreprises = $entreprisesEnAttente; 
        $demandeEnAttente = Demande::where('is_new', true)->count();
        Demande::where('is_new', true)->update(['is_new' => false]);
        $totalNotifications = $demandeEnAttente;
        $nouvellesDemandes = $demandeEnAttente;
        return view('demande.show',compact('demande','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function edit(Demande $demande)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
         $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
        $nouveauxEntreprises = $entreprisesEnAttente; 
        $demandeEnAttente = Demande::where('is_new', true)->count();
        Demande::where('is_new', true)->update(['is_new' => false]);
        $totalNotifications = $demandeEnAttente;
        $nouvellesDemandes = $demandeEnAttente;
        $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();
        $profiles = Profil::all();
        $niveaux = Niveaux::all();
    
        return view('demande.edit', compact('demande','profiles','niveaux','entreprise','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    
    public function update(Request $request, Demande $demande)
    {
       

 // Récupérer l'entreprise connectée
    $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();

// Vérifier que l'entreprise est bien trouvée
    if (!$entreprise) {
        return back()->with('error', 'Entreprise non trouvée.');
    }
        $validatedData = $request->validate([
  'profil_id' => 'required|exists:profils,id',
 'niveaux_id' => 'required|exists:niveauxes,id',
 'nbre_profil' => 'required|integer|min:1',
        ]);
       
  $demande->update($validatedData);
    
 return redirect()->route('demande.index')
                         ->with('success', 'Demande  mis à jour avec succès.');
    }

    public function destroy(Demande $demande)
{
      
    $demande->delete();

return redirect()->route('demande.index')
 ->with('success', ' Demande supprimé avec succès.');
}
    
}
