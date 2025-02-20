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
    $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();
    if (!$entreprise) {
        return back()->with('error', 'Entreprise non trouvée.');
    }
     $request->validate([
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id', 
        'nbre_profil' => 'required|integer|min:1',
    ]);
    Demande::create([
        'profil_id' => $request->profil_id,
        'niveaux_id' => $request->niveaux_id,
        'entreprise_id' => $entreprise->id,
        'nbre_profil' => $request->nbre_profil,
    ]);
    return redirect()->route('demande.index')
        ->with('success', 'Demande créée avec succès.');
}
public function ListeEnvoye($id)
{
    $demande = Demande::with(['profil', 'niveaux'])->findOrFail($id);
    $demPro = DemandeurProfil::where('profil_id', $demande->profil_id)
    ->where('niveaux_id', $demande->niveaux_id)
    ->get();
    return view('demande.listeenvoye', compact('demande','demPro'));
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
        return redirect()->route('demande.index')
        ->with('success', 'Vos réponses sont envoyés avec succès.');     
    }
    public function listeReponses()
    {
        $userName = auth()->user()->name;
        $reponses = \App\Models\Reponse::whereHas('entreprise', function ($query) use ($userName) {
            $query->where('nomentreprise', $userName);
        })
        ->with(['demandeurprofil.demandeur', 'demande.profil', 'demande.niveaux'])
        ->get(); 
        $entreprise = \App\Models\Entreprise::where('nomentreprise', $userName)->first();
        $entrepriseId = $entreprise->id;
        $demandeId = $reponses->first()->demande_id ?? null;
        return view('demande.recu', compact('reponses','entrepriseId','demandeId'));
    }
    
    public function enregistrerRetenu(Request $request)
    {
        $request->validate([
            'demandeur_profils' => 'required|array',
            'demande_id' => 'required|exists:demandes,id',
            'entreprise_id' => 'required|exists:entreprises,id',
        ]);
        foreach ($request->demandeur_profils as $id) {
            \App\Models\Retenu::create([
                'demandeur_profil_id' => $id,
                'demande_id' => $request->demande_id,
                'entreprise_id' => $request->entreprise_id,
                'checked' => true,
            ]);
        }
        return redirect()->route('demanderecu')
        ->with('success', 'Les demandeurs retenus sont envoyés avec succès.');     
    }
    public function listeRetenus()
    {
        $userName = auth()->user()->name;
        $retenus = Retenu::all();
        return view('demande.retenu', compact('retenus'));
    }

public function show(Demande $demande)
    {
       
        return view('demande.show',compact('demande'));
    }

    public function edit(Demande $demande)
    {
        $entreprise = Entreprise::where('nomentreprise', auth()->user()->name)->first();
        $profiles = Profil::all();
        $niveaux = Niveaux::all();
    
        return view('demande.edit', compact('demande','profiles','niveaux','entreprise'));
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
