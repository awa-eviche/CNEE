<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use App\Models\Demande; 
use Illuminate\Http\Request;
use App\Mail\EntrepriseInscriteMail;
use App\Notifications\NouvelleEntrepriseNotification;
use App\Mail\ValiderEntrepriseMail;
use App\Mail\RejeterEntrepriseMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
class EntrepriseController extends Controller
{
    public function index()
{


    $user = Auth::user();
    // Utilisez la propriété unreadNotifications sans parenthèses pour obtenir la collection
    $user->unreadNotifications
         ->where('type', 'App\Notifications\NouvelleEntrepriseNotification')
         ->markAsRead();

    $entreprises = Entreprise::all();

    return view('entreprise.index', compact('entreprises'));
}

    public function create()
    {
        //$entreprises = Entreprise::where('nomentreprise', auth()->user()->name)->get();
         $entreprises=Entreprise::all();
        
        return view('entreprise.create',compact('entreprises'));
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
    $superAdmins = User::where('role_id', 1)->get();
    
    
    foreach ($superAdmins as $admin) {
        $admin->notify(new NouvelleEntrepriseNotification($entreprise));
    }
    return redirect()->to('/')->with('success', 'Votre Entreprise est enregistrée avec succès.');
}

public function show(Entreprise $entreprise)
    {
   
        return view('entreprise.show',compact('entreprise'));
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
