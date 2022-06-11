<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class DashboardController extends Controller
{
    public function index(){

        //$sesion = session(['moises' => 'Linares Oscco']);
        //Auth::attempt(['moises' => 'linares']);
        $opens = Auth::user();
        return Inertia::render('Dashboard', [
            'opens' => $opens
        ]);
    }
}
