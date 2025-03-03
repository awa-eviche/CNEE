<?php

namespace App\Http\Controllers;
use App\Models\Entreprise;
use App\Models\Demandeur;
use App\Models\Demande;
use App\Models\User;
use App\Models\Retenu;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
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
    $user = Auth::user();
  

    if ($user->role->code === "superadmin")
    { 
        $entreprise = Entreprise::count();
        $demandeur = Demandeur::count();
        $retenu = Retenu::count();
        $demande = Demande::count();
    } else {
        $entreprise = Entreprise::where('nomentreprise', $user->name)->count();
        $demandeur = null; 
        $demande = Demande::where('entreprise_id', $user->id)->count();
        $retenu = Retenu::where('entreprise_id', $user->id)->count();
    }
return view('dashboard', compact('entreprise', 'demande', 'retenu', 'demandeur','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
}

     } 
 


