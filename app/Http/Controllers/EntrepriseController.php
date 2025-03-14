<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use App\Models\Demande; 
use Illuminate\Http\Request;
use App\Mail\EntrepriseInscriteMail;
use App\Mail\ValiderEntrepriseMail;
use App\Mail\RejeterEntrepriseMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises=Entreprise::all();
        $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
     return view('entreprise.index',compact('entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }
    public function create()
    {
        //$entreprises = Entreprise::where('nomentreprise', auth()->user()->name)->get();
         $entreprises=Entreprise::all();
         $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
        Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('entreprise.create',compact('entreprises','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function store(Request $request)
{
    $request->validate([
        'nomentreprise' => 'required|string|max:255',
        'adresse' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'tel' => 'required|string|max:20',
        'formj' => 'required|string|max:20',
        'region' => 'required|string|max:20',
        'departement' => 'required|string|max:20',
        'activite' => 'required|string|max:255',
        'secteur' => 'required|string|max:255',
        'ninea' => 'required|string|max:20',
        'regitcom' => 'required|string|max:20',
        'nombreemployer' => 'required|integer',
        'dossier' => 'required|file|max:2048',
        'quitus' => 'required|file|max:2048',
        'attestation' => 'required|file|max:2048',
    ]);

    $entreprise = new Entreprise();
    $entreprise->nomentreprise = $request->nomentreprise;
    $entreprise->adresse = $request->adresse;
    $entreprise->email = $request->email;
    $entreprise->tel = $request->tel;
    $entreprise->region = $request->region;
    $entreprise->statut = "en attente";
    $entreprise->departement = $request->departement;
    $entreprise->formj = $request->formj;
    $entreprise->activite = $request->activite;
    $entreprise->secteur = $request->secteur;
    $entreprise->ninea = $request->ninea;
    $entreprise->regitcom = $request->regitcom;
    $entreprise->nombreemployer = $request->nombreemployer;
    $entreprise->is_new = true;
    
    if ($request->hasFile('dossier')) {
        $file = $request->file('dossier');
        $filename = $file->getClientOriginalName(); 
        $file->storeAs('dossiers', $filename, 'public'); 
        $entreprise->dossier = $filename; 
    }

    if ($request->hasFile('quitus')) {
        $file = $request->file('quitus');
        $filename = $file->getClientOriginalName();
        $file->storeAs('quitus', $filename, 'public');
        $entreprise->quitus = $filename;
    }

    if ($request->hasFile('attestation')) {
        $file = $request->file('attestation');
        $filename = $file->getClientOriginalName();
        $file->storeAs('attestations', $filename, 'public');
        $entreprise->attestation = $filename;
    }
    $entreprise->save();
    Mail::to($entreprise->email)->send(new \App\Mail\EntrepriseInscriteMail($entreprise));
    return redirect()->to('/')->with('success', 'Votre Entreprise est enregistrée avec succès.');
}

public function show(Entreprise $entreprise)
    {
    $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
     Entreprise::where('is_new', true)->update(['is_new' => false]);
     $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
    $nouveauxEntreprises = $entreprisesEnAttente; 
    $demandeEnAttente = Demande::where('is_new', true)->count();
    Demande::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $demandeEnAttente;
    $nouvellesDemandes = $demandeEnAttente; 
        return view('entreprise.show',compact('entreprise','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

    public function validerEntreprise($id)
    {
        $entreprise = Entreprise::find($id);
    
        if ($entreprise) {
            $entreprise->statut = 'validé';
            $entreprise->save();
            $password = Str::random(10);  
            $user = new User();
            $user->name = $entreprise->nomentreprise; 
            $user->email = $entreprise->email;
            $user->password = Hash::make($password); 
            $user->role_id = 2;
            $user->statut= "entreprise";
            $user->save();
            Mail::to($entreprise->email)->send(new ValiderEntrepriseMail($entreprise, $password));
            return redirect()->route('entreprise.index')
                ->with('success', "L'email a été envoyé à l'entreprise : {$entreprise->nomentreprise}");
        }
        return redirect()->route('entreprise.index')->withErrors('Entreprise non trouvée.');
    }

    public function rejeterEntreprise(Request $request, $id)
    {
        $request->validate([
            'motif' => 'required|string|max:255',
        ]);
    
        $entreprise = Entreprise::find($id);
        if ($entreprise) {   
            $entreprise->statut = 'rejeté';
            $entreprise->save();
    
            // Envoyer l'email avec le motif de rejet
            Mail::to($entreprise->email)->send(new RejeterEntrepriseMail($entreprise, $request->motif));
    
            return redirect()->route('entreprise.index')
                ->with('success', "L'email de rejet a été envoyé à l'entreprise : {$entreprise->nomentreprise}");
        }
        return redirect()->route('entreprise.index')->withErrors('Entreprise non trouvée.');
    }
    
    
    public function desactiver($id)
    {
        $entreprise = Entreprise::find($id);
        if ($entreprise) {
            $entreprise->est_actif = false;  
            $entreprise->save();
    
        }
    
        return redirect()->route('entreprise.index');  
    }
    
}
