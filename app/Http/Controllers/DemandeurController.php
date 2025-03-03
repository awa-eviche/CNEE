<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Imports\DemandeurImport;
use App\Models\Niveaux; 
use App\Models\Profil; 
use App\Models\Demande; 
use App\Models\Entreprise; 
use App\Models\Demandeur; 

class DemandeurController extends Controller
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
        $demandeur=Demandeur::all();
        $profiles = \App\Models\Profil::all();
        $niveaux = \App\Models\Niveaux::all();

        return view('demandeur.index',compact('demandeur','profiles','niveaux','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function create()
    {
        $demandeurs = Demandeur::all();
        $profiles = Profil::all();
        $niveaus = Niveaux::all();
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('demandeur.create', compact('demandeurs', 'profiles','niveaus','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function store(Request $request)
{
    $request->validate([
        'prenom' => 'required|string|max:255',
        'sexe' => 'required|string|max:255',
        'datenaissance' => 'required|string|max:255',
        'lieunaissance' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'region' => 'required|string|max:255',
        'departement' => 'required|string|max:255',
      
      
    ]);

    
    $data = $request->all();

   
    if ($request->hasFile('cv')) {
        $filename = $request->file('cv')->store('upload', 'public');
        $data['cv'] = $filename; 
    }
    $demandeur = Demandeur::create($data);
    return redirect()->route('demandeur.index')
        ->with('success', 'Demandeur créé avec succès.');
}

    public function edit(Demandeur $demandeur)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
  
        return view('demandeur.edit', compact('demandeur','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function update(Request $request, Demandeur $demandeur)
    {
        $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'sexe' => 'required|string|max:255',
            'datenaissance' => 'required|string|max:255',
            'lieunaissance' => 'required|string|max:255',
            'region' => 'required|string|max:255',
            'departement' => 'required|string|max:255',
            'cni' => 'required|string|max:255',
            'adresse' => 'required|string|max:255',
           
           
        ]);
       

        $demandeur->update($request->all());

        return redirect()->route('demandeur.index')
                         ->with('success', 'demandeur mis à jour avec succès.');
    }

    public function destroy(Demandeur $demandeur)
    {
          
        $demandeur->delete();

        return redirect()->route('demandeur.index')
                         ->with('success', 'Demandeur supprimé avec succès.');
    }

    public function show(Demandeur $demandeur)
    {
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente;   
        return view('demandeur.show',compact('demandeur','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }


    public function importDemandeurs(Request $request)
{
    $request->validate([
        'file' => 'required|mimes:csv,txt,xlsx,xls',
        'profil_id' => 'required|exists:profils,id',
        'niveaux_id' => 'required|exists:niveauxes,id', // Correction du nom de la table
    ]);

    // Récupérer le fichier
    $file = $request->file('file');

    $data = \Maatwebsite\Excel\Facades\Excel::toArray([], $file)[0];

    // Récupérer les en-têtes
    $headers = array_map('strtolower', $data[0]); // Convertir en minuscules pour éviter les erreurs
    unset($data[0]); // Supprimer la ligne des en-têtes

    foreach ($data as $row) {
        $demandeurData = array_combine($headers, $row); // Associer les en-têtes aux valeurs
    
        // Créer un demandeur et le stocker dans une variable
        $demandeur = \App\Models\Demandeur::create([
            'nom'            => $demandeurData['nom'] ?? null,
            'prenom'         => $demandeurData['prenom'] ?? null,
            'email'          => $demandeurData['email'] ?? null,
            'sexe'           => $demandeurData['sexe'] ?? null,
            'datenaissance'  => $demandeurData['datenaissance'] ?? null,
            'lieunaissance'  => $demandeurData['lieunaissance'] ?? null,
            'region'         => $demandeurData['region'] ?? null,
            'departement'    => $demandeurData['departement'] ?? null,
            'cni'            => $demandeurData['cni'] ?? null,
            'adresse'        => $demandeurData['adresse'] ?? null,
            'tel'            => $demandeurData['tel'] ?? null,
        ]);

        // Vérifier si la création a réussi avant d'associer un profil
        if ($demandeur) {
            \App\Models\DemandeurProfil::create([
                'demandeur_id' => $demandeur->id,
                'profil_id' => $request->profil_id,
                'niveaux_id' => $request->niveaux_id,
            ]);
        }
    }

    return redirect()->route('demandeur.index')->with('success', 'Demandeurs importés et associés avec succès.');
}


}
