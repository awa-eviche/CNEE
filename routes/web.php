<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\EntrepriseController;
use App\Http\Controllers\NiveauxController;
use App\Http\Controllers\ProfilController;
use App\Http\Controllers\DemandeurController;

use App\Http\Controllers\DemandeurProfilController;


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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


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

    Route::resource('demandeurprofil', DemandeurProfilController::class);
    });

    Route::resource('admin', AdminController::class);


    Route::resource('archive', ArchiveController::class);

    Route::delete('/admin/{user}', [AdminController::class, 'destroy'])->name('admin.destroy');
    Route::post('/entreprise/valider/{id}', [EntrepriseController::class, 'validerEntreprise'])->name('entreprise.valider');
    Route::post('/entreprise/rejeter/{id}', [EntrepriseController::class, 'rejeterEntreprise'])->name('entreprise.rejeter');


    Route::get('/entreprise/valider/{id}', [EntrepriseController::class, 'validerEntreprise'])->name('entreprise.valider');
    Route::post('/demandeur/import', [DemandeurController::class, 'import'])->name('demandeur.import');
    Route::get('/demandeurprofil/create/{demandeur_id}', [DemandeurProfilController::class, 'create'])->name('demandeurprofil.create');
    



require __DIR__.'/auth.php';
