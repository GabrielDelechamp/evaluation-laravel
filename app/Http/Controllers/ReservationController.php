<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReservationController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $reservations = Reservation::all();
        return view('reservation.indexReservation', compact('reservations'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reservations= Reservation::all();
        return view ('reservation.createReservation', compact('reservations'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'date' => 'required|date|after_or_equal:today',
            'salle_id' => 'required|exists:salles,id',
        ]);

        $start = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
        $end = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);

        // Vérifie s'il y a un conflit de réservation
        $conflict = Reservation::where('salle_id', $validated['salle_id'])
            ->whereDate('start_time', $validated['date'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->exists();

        if ($conflict) {
            $reservations = Reservation::all();
            return back()
                ->withErrors(['conflit' => 'La salle est déjà réservée pour ce créneau.'])
                ->withInput();
        }

        $reservation = new Reservation;
        $reservation->start_time = $start;
        $reservation->end_time = $end;
        $reservation->salle_id = $validated['salle_id'];
        $reservation->user_id = $request->user_id;
        $reservation->save();

        $reservations = Reservation::all();
        return view('reservation.indexReservation', compact('reservations'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Reservation $reservation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Reservation $reservation)
    {
        $reservations = Reservation::all();
        return view ('reservation.editReservation', compact('reservation','reservations'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Reservation $reservation)
    {
        $validated = $request->validate([
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'date' => 'required|date|after_or_equal:today',
            'salle_id' => 'required|exists:salles,id',
        ]);

        $start = Carbon::parse($validated['date'] . ' ' . $validated['start_time']);
        $end = Carbon::parse($validated['date'] . ' ' . $validated['end_time']);

        // Vérifie s'il y a un conflit de réservation
        $conflict = Reservation::where('salle_id', $validated['salle_id'])
            ->whereDate('start_time', $validated['date'])
            ->where(function ($query) use ($start, $end) {
                $query->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function ($query) use ($start, $end) {
                        $query->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            })
            ->exists();

        if ($conflict) {
            $reservations = Reservation::all();
            return back()
                ->withErrors(['conflit' => 'La salle est déjà réservée pour ce créneau.'])
                ->withInput();
        }

        $reservation->start_time = $start;
        $reservation->end_time = $end;
        $reservation->salle_id = $validated['salle_id'];
        $reservation->save();

        $reservations = Reservation::all();
        return view('reservation.indexReservation', compact('reservations'));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Reservation $reservation)
    {
        $reservation->delete();
        return redirect()->route('reservation.index');
    }
}
