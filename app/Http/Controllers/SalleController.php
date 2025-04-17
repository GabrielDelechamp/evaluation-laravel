<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;
use Illuminate\Http\RedirectResponse;

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
     *
     * @return View
     */
    public function index(): View
    {
        $salles = Salle::all();

        return view('salle.indexSalle', compact('salles'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return View
     */
    public function create(): View
    {
        // Vérifier si l'utilisateur est admin
        if (! Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salles = Salle::all();

        return view('salle.createSalle', compact('salles'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return View
     */
    public function store(Request $request): View
    {
        // Vérifier si l'utilisateur est admin
        if (! Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salle = new Salle();
        $salle->name = $request->name;
        $salle->capacity = $request->capacity;
        $salle->surface = $request->surface;
        $salle->save();

        $salles = Salle::all();

        return view('salle.indexSalle', compact('salles'));
    }

    /**
     * Display the specified resource.
     *
     * @param Salle $salle
     * @return void
     */
    public function show(Salle $salle): void
    {
        // Peut-être ajouter une vue spécifique ici
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Salle $salle
     * @return View
     */
    public function edit(Salle $salle): View
    {
        // Vérifier si l'utilisateur est admin
        if (! Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        return view('salle.editSalle', compact('salle'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Salle $salle
     * @return View
     */
    public function update(Request $request, Salle $salle): View
    {
        // Vérifier si l'utilisateur est admin
        if (! Auth::user()->isAn('admin')) {
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
     *
     * @param Salle $salle
     * @return RedirectResponse
     */
    public function destroy(Salle $salle): RedirectResponse
    {
        // Vérifier si l'utilisateur est admin
        if (! Auth::user()->isAn('admin')) {
            abort(403, 'Accès non autorisé.');
        }

        $salle->delete();

        return redirect()->route('salle.index');
    }
}
