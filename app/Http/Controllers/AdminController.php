<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Entreprise;
use App\Models\Demande;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use App\Providers\RouteServiceProvider;

class AdminController extends Controller
{
    
     public function index()
    { 
       $users=User::all();
       $entreprisesEnAttente = Entreprise::where('is_new', true)->count();
       Entreprise::where('is_new', true)->update(['is_new' => false]);
    $totalNotifications = $entreprisesEnAttente + Demande::where('is_new', true)->count();
   $nouveauxEntreprises = $entreprisesEnAttente; 
   $demandeEnAttente = Demande::where('is_new', true)->count();
   Demande::where('is_new', true)->update(['is_new' => false]);
   $totalNotifications = $demandeEnAttente;
   $nouvellesDemandes = $demandeEnAttente;
    	 return view('admin.index',compact('users','entreprisesEnAttente', 'totalNotifications', 'nouveauxEntreprises','nouvellesDemandes','demandeEnAttente'));
    }

   public function create()
    { 
       $users=User::all();
     
    $roles = Role::whereIn('name', ['admin', 'superadmin'])->get();
       return view('admin.create',compact('users','roles'));
    }
    public function store(Request $request)
{
    
    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
        'role_id' => ['required', 'integer'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
        'statut' => ['required', 'string', 'max:255'],
    ]);

    
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'role_id' => $request->role_id,
        'statut' => $request->statut,
        'password' => Hash::make($request->password),
    ]);
    return redirect()->route('admin.index')->with('success', 'Utilisateur ajouté avec succès.');
}

 public function show ($id)
    {
        $user = User::findOrFail($id);  
         return view('admin.show', compact('user'));
    }

    public function edit( $id)
    { $roles=Role::all();
         $user = User::findOrFail($id); 
    return view('admin.edit', compact('user','roles')); 
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255'],
            'statut' => ['required', 'string'],
            'role_id' => ['required', 'string'],
            'password' => ['nullable', 'confirmed', \Illuminate\Validation\Rules\Password::defaults()],
        ]);
        $user = User::findOrFail($id);
        $data = [
            'name' => $request->name,
            'email' => $request->email,
            'statut' => $request->statut, 
            'role_id' => $request->role_id,
        ];
        if ($request->password) {
            $data['password'] = Hash::make($request->password);
        }
        $user->update($data);
        return redirect()->route('admin.index')->with('success', 'Utilisateur mis à jour.');
    }
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        if ($user) {
            $user->delete();
            return redirect()->route('admin.index')->with('success', 'Utilisateur supprimé avec succès.');
        } 
        else
        { 
            return redirect()->route('admin.index')->with('erreur', 'Utilisateur non trouvé.');
         }
    }
}