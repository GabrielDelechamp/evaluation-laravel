<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Reservation;
use App\Models\Salle;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistiques globales
        $totalSalles = Salle::count();
        $totalReservations = Reservation::count();
        $reservationsAujourdhui = Reservation::whereDate('start_time', Carbon::today())->count();
        $reservationsASuivre = Reservation::where('start_time', '>=', Carbon::now())->count();

        // Taux de réservation par semaine (dernières 4 semaines)
        $statsParSemaine = $this->getWeeklyStats();

        // Taux de réservation par mois (derniers 6 mois)
        $statsParMois = $this->getMonthlyStats();

        // Top des salles les plus réservées
        $topSalles = $this->getTopRooms();

        return view('admin.dashboard', compact(
            'totalSalles',
            'totalReservations',
            'reservationsAujourdhui',
            'reservationsASuivre',
            'statsParSemaine',
            'statsParMois',
            'topSalles'
        ));
    }

    private function getWeeklyStats()
    {
        $weeks = [];
        $reservationData = [];

        // Obtenir les données pour les 4 dernières semaines
        for ($i = 3; $i >= 0; $i--) {
            $startOfWeek = Carbon::now()->subWeeks($i)->startOfWeek();
            $endOfWeek = Carbon::now()->subWeeks($i)->endOfWeek();

            $weekLabel = $startOfWeek->format('d/m') . ' - ' . $endOfWeek->format('d/m');
            $weeks[] = $weekLabel;

            // Compter les réservations pour cette semaine
            $count = Reservation::whereBetween('start_time', [$startOfWeek, $endOfWeek])->count();

            // Calculer le taux de réservation (nb réservations / capacité théorique)
            $totalCapacite = Salle::count() * 5 * 8; // 5 jours * 8 heures par jour
            $tauxOccupation = $totalCapacite > 0 ? round(($count / $totalCapacite) * 100, 2) : 0;

            $reservationData[] = $tauxOccupation;
        }

        return [
            'labels' => $weeks,
            'data' => $reservationData
        ];
    }

    private function getMonthlyStats()
    {
        $months = [];
        $reservationData = [];

        // Obtenir les données pour les 6 derniers mois
        for ($i = 5; $i >= 0; $i--) {
            $month = Carbon::now()->subMonths($i);
            $startOfMonth = $month->copy()->startOfMonth();
            $endOfMonth = $month->copy()->endOfMonth();

            $monthLabel = $month->format('M Y');
            $months[] = $monthLabel;

            // Compter les réservations pour ce mois
            $count = Reservation::whereBetween('start_time', [$startOfMonth, $endOfMonth])->count();

            // Calculer le taux de réservation (approximativement)
            $daysInMonth = $month->daysInMonth;
            $workingDays = min($daysInMonth * 5/7, 22); // Approximation des jours ouvrables
            $totalCapacite = Salle::count() * $workingDays * 8; // jours ouvrables * 8 heures par jour
            $tauxOccupation = $totalCapacite > 0 ? round(($count / $totalCapacite) * 100, 2) : 0;

            $reservationData[] = $tauxOccupation;
        }

        return [
            'labels' => $months,
            'data' => $reservationData
        ];
    }

    private function getTopRooms()
    {
        return Salle::select('salles.id', 'salles.name', DB::raw('COUNT(reservations.id) as total_reservations'))
            ->leftJoin('reservations', 'salles.id', '=', 'reservations.salle_id')
            ->groupBy('salles.id', 'salles.name')
            ->orderByDesc('total_reservations')
            ->limit(5)
            ->get();
    }
}
