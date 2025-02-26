<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\NiveauxController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DemandeurController;
use App\Http\Controllers\DemandeController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DemandeurProfilController;
use App\Http\Controllers\SecteurController;
use App\Http\Controllers\ClassificationController;
use App\Http\Controllers\AllocationController;


use App\Http\Controllers\ArchiveController;
use App\Http\Controllers\FichierController;
use App\Http\Controllers\AdminController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');


Route::post('/entreprise/desactiver/{id}', [EntrepriseController::class, 'desactiver'])->name('entreprise.desactiver');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});


Route::post('/archives/{archive}/fichiers', [FichierController::class, 'store'])->name('fichiers.store');

Route::group([],function () {
    
    Route::resource('entreprise', EntrepriseController::class);
    Route::resource('profil', ProfilController::class);
    Route::resource('niveau', NiveauxController::class);    
    Route::resource('demandeur', DemandeurController::class);
    Route::resource('demande', DemandeController::class);
    Route::resource('secteur', SecteurController::class);
    Route::resource('classification', ClassificationController::class);
    Route::get('/allocation', [AllocationController::class, 'index'])->name('allocation.index');
    Route::get('/allocation/create/{id}', [AllocationController::class, 'create'])->name('allocation.create');
    Route::get('/allocation/afficher/{id}', [AllocationController::class, 'afficher'])->name('allocation.afficher');

    Route::post('/allocation/store', [AllocationController::class, 'store'])->name('allocation.store');
    Route::resource('demandeurprofil', DemandeurProfilController::class);
    });

    Route::resource('admin', AdminController::class);
    Route::resource('archive', ArchiveController::class);
    Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/entreprise/valider/{id}', [EntrepriseController::class, 'validerEntreprise'])->name('entreprise.valider');
    Route::post('/entreprise/rejeter/{id}', [EntrepriseController::class, 'rejeterEntreprise'])->name('entreprise.rejeter');
    Route::get('/entreprise/valider/{id}', [EntrepriseController::class, 'validerEntreprise'])->name('entreprise.valider');
    Route::post('/demandeur/import', [DemandeurController::class, 'importDemandeurs'])->name('demandeur.import');
    Route::get('/demandeurprofil/create/{demandeur_id}', [DemandeurProfilController::class, 'create'])->name('demandeurprofil.create');
    Route::get('/listeenvoye/{id}', [DemandeController::class, 'ListeEnvoye'])->name('listeenvoye');    
    Route::post('/demandes/reponses/enregistrer', [DemandeController::class, 'enregistrerReponses'])->name('demande.enregistrerReponses');
    //Route::get('/demanderecu', [DemandeController::class, 'listeReponses'])->name('demanderecu');
    Route::post('/demandes/retenu/enregistrer', [DemandeController::class, 'enregistrerRetenu'])->name('demande.enregistrerRetenu');
    Route::get('/demanderetenu', [DemandeController::class, 'listeRetenus'])->name('demanderetenu');
    Route::get('/demanderecu/{id?}', [DemandeController::class, 'listeReponses'])->name('demanderecu');



require __DIR__.'/auth.php';
