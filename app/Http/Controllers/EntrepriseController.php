<?php

namespace App\Http\Controllers;
use App\Models\Entreprise; 
use Illuminate\Http\Request;

class EntrepriseController extends Controller
{
    public function index()
    {
       
        return view('entreprise.index');
    }

}
