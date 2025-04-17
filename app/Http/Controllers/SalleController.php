<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SalleController extends Controller
{
    /**
     * Constructeur avec middleware d'authentification
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $salles = Salle::all();
        return view('salle.indexSalle', compact('salles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salles = Salle::all();
        return view('salle.createSalle', compact('salles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salle = New Salle;
        $salle->name = $request->name;
        $salle->capacity = $request->capacity;
        $salle->surface = $request->surface;
        $salle->save();

        $salles = Salle::all();
        return view('salle.indexSalle', compact('salles'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Salle $salle)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Salle $salle)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        return view('salle.editSalle', compact('salle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salle $salle)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salle->name = $request->name;
        $salle->capacity = $request->capacity;
        $salle->surface = $request->surface;
        $salle->save();

        $salles = Salle::all();
        return view('salle.indexSalle', compact('salles'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salle $salle)
    {
        // Vérifier si l'utilisateur est admin
        if (!Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salle->delete();
        return redirect()->route('salle.index');
    }
}
