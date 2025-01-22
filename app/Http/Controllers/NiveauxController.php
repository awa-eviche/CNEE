<?php

namespace App\Http\Controllers;
use App\Models\Niveaux; 
use Illuminate\Http\Request;

class NiveauxController extends Controller
{
    public function index()
    {
       
        return view('niveau.index');
    }
    public function create()
    {
          
        return view('niveau.create');
    }
}
