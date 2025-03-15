<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ArchiveRej;
use App\Models\Entreprise;
use App\Models\Demande;
use Illuminate\Support\Facades\Storage;

class ArchiveRejController extends Controller
{
    public function index()
    {
        $entreprises = Entreprise::where('statut', 'rejeté')->get();
        $archiverej = ArchiveRej::all(); 
      
        return view('archiverej.index', compact('entreprises', 'archiverej'));
    }

    public function create()
    {
   
    $entreprises = Entreprise::where('statut', 'rejeté')->get();
        return view('archiverej.create', compact('entreprises'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'entreprise_id' => 'required|integer', 
            'file' => 'required|file|max:2048', 
            
           
        ]); 
        $archiverej = new ArchiveRej();
        $archiverej->type = $request->type;
        $archiverej->file = $request->file;
        $archiverej->entreprise_id = $request->entreprise_id;
       
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $filename = $file->getClientOriginalName(); 
            $file->storeAs('filerej', $filename, 'public'); 
            $archiverej->file = $filename; 
        }
        $archiverej->save();
        return redirect()->route('archiverej.index')->with('success', 'Archive enregistrée avec succès.');
    }
    
    public function show(Archiverej  $archiverej)
    {
       
        return view('archiverej.show',compact('archiverej'));
    }
    public function edit(Archiverej  $archiverej)
    {
       
        $entreprises = Entreprise::all();
        return view('archiverej.edit', compact('archiverej','entreprises'));
    }
    public function update(Request $request, Archiverej $archiverej)
{
    
    $request->validate([
        'type' => 'required|string|max:255',
        'entreprise_id' => 'required|integer',
        'file' => 'required|file|max:2048', 
       
    ]);
    $archiverej->type = $request->type;
    $archiverej->entreprise_id = $request->entreprise_id;
   
  
    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $filename = $file->getClientOriginalName(); 
        $file->storeAs('filerej', $filename, 'public'); 
        $archiverej->file = $filename; 
    }
    $archiverej->save();
    return redirect()->route('archiverej.index')->with('success', 'Archive mise à jour avec succès.');
}





}
