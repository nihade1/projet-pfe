<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        // Tu peux passer des données à la vue ici si besoin
        return view('index');
    }
}