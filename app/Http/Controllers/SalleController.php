<?php

namespace App\Http\Controllers;

use App\Models\Salle;
use Illuminate\Http\Request;

class SalleController extends Controller
{
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
        $salles = Salle::all();
        return view('salle.createSalle', compact('salles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $salle=New Salle;
        $salle->name=$request->name;
        $salle->capacity=$request->capacity;
        $salle->surface=$request->surface;
        $salle->save();

        $salles=Salle::all();
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
        return view ('salle.editSalle', compact('salle'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Salle $salle)
    {
        $salle->name=$request->name;
        $salle->capacity=$request->capacity;
        $salle->surface=$request->surface;
        $salle->save();

        $salles=Salle::all();
        return view('salle.indexSalle', compact('salles'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Salle $salle)
    {
        $salle->delete();
        return redirect()->route('salle.index');
    }
}
