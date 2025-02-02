<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use Illuminate\Http\Request;
use App\Mail\EntrepriseInscriteMail;
use App\Mail\ValiderEntrepriseMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use App\Models\User; 
use Illuminate\Support\Facades\Hash;
class EntrepriseController extends Controller
{
    public function index()
    {
        $entreprises=Entreprise::all();
        return view('entreprise.index',compact('entreprises'));
    }
    public function create()
    {
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
        'activite' => 'required|string|max:255',
        'secteur' => 'required|string|max:255',
        'ninea' => 'required|string|max:20',
        'regitcom' => 'required|string|max:20',
        'nombreemployer' => 'required|integer',
        'dossier' => 'required|file|max:2048',
    ]);
    $entreprise = new Entreprise();
    $entreprise->nomentreprise = $request->nomentreprise;
    $entreprise->adresse = $request->adresse;
    $entreprise->email = $request->email;
    $entreprise->tel = $request->tel;
    $entreprise->activite = $request->activite;
    $entreprise->secteur = $request->secteur;
    $entreprise->ninea = $request->ninea;
    $entreprise->regitcom = $request->regitcom;
    $entreprise->nombreemployer = $request->nombreemployer;
    if ($request->hasFile('dossier')) {
        $filename = $request->file('dossier')->store('dossiers', 'public');
        $entreprise->dossier = $filename;
    }
    $entreprise->save();
    $lastEntreprise = Entreprise::latest()->first(); 
    Mail::to($lastEntreprise->email)->send(new \App\Mail\EntrepriseInscriteMail($lastEntreprise));

    return redirect()->route('/')->with('success', 'Entreprise enregistrée avec succès.');
}

public function show(Entreprise $entreprise)
    {
       
        return view('entreprise.show',compact('entreprise'));
    }

    public function validerEntreprise($id)
    {
        $entreprise = Entreprise::find($id);
    
        if ($entreprise) {
            $password = Str::random(10);  
            $user = new User();
            $user->name = $entreprise->nomentreprise; 
            $user->email = $entreprise->email;
            $user->password = Hash::make($password); 
            $user->role_id = 2;
            $user->save();
            Mail::to($entreprise->email)->send(new ValiderEntrepriseMail($entreprise, $password));
            return redirect()->route('entreprise.index')
                ->with('success', "L'email a été envoyé à l'entreprise : {$entreprise->nomentreprise}");
        }
        return redirect()->route('entreprise.index')->withErrors('Entreprise non trouvée.');
    }
   


}
