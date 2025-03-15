<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Demande; 
use App\Models\Entreprise;
use App\Models\Profil;
use App\Models\Niveaux;
use App\Models\User; 
use App\Models\DemandeurProfil;
use App\Models\Retenu;
use App\Notifications\NouvelleDemandeNotification;
use Illuminate\Support\Facades\Auth;
class DemandeController extends Controller
{
    public function index()
    {
        $user = Auth::user();
    
        // Utilisez la propriété unreadNotifications sans parenthèses pour obtenir la collection
        $user->unreadNotifications
             ->where('type', 'App\Notifications\NouvelleDemandeNotification')
             ->markAsRead();
    
        if ($user->role->code === 'superadmin') {
            $demande = Demande::all();
        } else {
            
            $demande = Demande::whereHas('entreprise', function ($query) use ($user) {
                $query->where('nomentreprise', $user->name);
            })->get();
        }
       
        return view('demande.index', compact('demande' ));
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
            'profil_id'   => 'required|exists:profils,id',
            'niveaux_id'  => 'required|exists:niveauxes,id', 
            'nbre_profil' => 'required|integer|min:1',
        ]);
        
       
        $demande = Demande::create([
            'profil_id'      => $request->profil_id,
            'niveaux_id'     => $request->niveaux_id,
            'entreprise_id'  => $entreprise->id,
            'nbre_profil'    => $request->nbre_profil,
        ]);
        
       
        $superAdmins = User::where('role_id', 1)->get();
        foreach ($superAdmins as $admin) {
            $admin->notify(new \App\Notifications\NouvelleDemandeNotification($demande));
        }
        
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
         Demande::where('id', $request->demande_id)->update(['statut' => 'traité']);

        return redirect()->route('demande.index')
        ->with('success', 'Vos réponses sont envoyés avec succès.');     
    }
    public function listeReponses($demandeId = null)
    {
      
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
    
        return view('demande.recu', compact('reponses', 'entrepriseId'));
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

    return view('demande.retenu', compact('retenus'));
}

    public function listeRetenusDemandeur($id)
    {
       
        $retenus = Retenu::findOrFail($id);
        return view('demande.demandeurretenu', compact('retenus'));
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
