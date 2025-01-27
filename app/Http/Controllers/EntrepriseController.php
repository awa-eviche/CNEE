<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use Illuminate\Http\Request;

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
    return redirect()->route('entreprise.index')->with('success', 'Entreprise enregistrée avec succès.');
}

public function show(Entreprise $entreprise)
    {
       
        return view('entreprise.show',compact('entreprise'));
    }





}
