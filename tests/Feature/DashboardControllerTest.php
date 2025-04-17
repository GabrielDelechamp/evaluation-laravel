<?php

namespace Tests\Feature;

use App\Http\Controllers\Admin\DashboardController;
use App\Models\Reservation;
use App\Models\Salle;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\View\View;
use Tests\TestCase;

class DashboardControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $controller;

    protected function setUp(): void
    {
        parent::setUp();
        $this->controller = new DashboardController;
    }

    public function test_index()
    {
        // Créer quelques salles et réservations pour tester
        $salle = Salle::factory()->create([
            'name' => 'Salle Test',
            'capacity' => 10,
            'surface' => 25,
        ]);

        // Créer des réservations à différentes dates
        Reservation::factory()->create([
            'salle_id' => $salle->id,
            'start_time' => Carbon::today(),
            'end_time' => Carbon::today()->addHour(),
        ]);

        Reservation::factory()->create([
            'salle_id' => $salle->id,
            'start_time' => Carbon::tomorrow(),
            'end_time' => Carbon::tomorrow()->addHour(),
        ]);

        // Exécuter la méthode index
        $response = $this->controller->index();

        // Vérifier que la réponse est une vue
        $this->assertInstanceOf(View::class, $response);

        // Vérifier que la vue correcte est retournée
        $this->assertEquals('admin.dashboard', $response->getName());

        // Vérifier que les données nécessaires sont passées à la vue
        $data = $response->getData();
        $this->assertArrayHasKey('totalSalles', $data);
        $this->assertArrayHasKey('totalReservations', $data);
        $this->assertArrayHasKey('reservationsAujourdhui', $data);
        $this->assertArrayHasKey('reservationsASuivre', $data);
        $this->assertArrayHasKey('statsParSemaine', $data);
        $this->assertArrayHasKey('statsParMois', $data);
        $this->assertArrayHasKey('topSalles', $data);

        // Vérifier les valeurs
        $this->assertEquals(1, $data['totalSalles']);
        $this->assertEquals(2, $data['totalReservations']);
        $this->assertEquals(1, $data['reservationsAujourdhui']);
        $this->assertGreaterThanOrEqual(1, $data['reservationsASuivre']);
    }

    public function test_get_weekly_stats()
    {
        // Utiliser la réflexion pour accéder à la méthode privée
        $reflectionMethod = new \ReflectionMethod(DashboardController::class, 'getWeeklyStats');
        $reflectionMethod->setAccessible(true);

        // Création de données de test
        Salle::factory()->create();
        Reservation::factory()->create([
            'start_time' => Carbon::now()->subWeek(),
            'end_time' => Carbon::now()->subWeek()->addHour(),
        ]);

        // Appel de la méthode
        $result = $reflectionMethod->invoke($this->controller);

        // Vérifications
        $this->assertIsArray($result);
        $this->assertArrayHasKey('labels', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertCount(4, $result['labels']);
        $this->assertCount(4, $result['data']);
    }

    public function test_get_monthly_stats()
    {
        // Utiliser la réflexion pour accéder à la méthode privée
        $reflectionMethod = new \ReflectionMethod(DashboardController::class, 'getMonthlyStats');
        $reflectionMethod->setAccessible(true);

        // Création de données de test
        Salle::factory()->create();
        Reservation::factory()->create([
            'start_time' => Carbon::now()->subMonth(),
            'end_time' => Carbon::now()->subMonth()->addHour(),
        ]);

        // Appel de la méthode
        $result = $reflectionMethod->invoke($this->controller);

        // Vérifications
        $this->assertIsArray($result);
        $this->assertArrayHasKey('labels', $result);
        $this->assertArrayHasKey('data', $result);
        $this->assertCount(6, $result['labels']);
        $this->assertCount(6, $result['data']);
    }

    public function test_get_top_rooms()
    {
        // Utiliser la réflexion pour accéder à la méthode privée
        $reflectionMethod = new \ReflectionMethod(DashboardController::class, 'getTopRooms');
        $reflectionMethod->setAccessible(true);

        // Création de données de test
        $salle1 = Salle::factory()->create(['name' => 'Salle 1']);
        $salle2 = Salle::factory()->create(['name' => 'Salle 2']);

        // Créer plus de réservations pour salle1
        Reservation::factory()->count(3)->create(['salle_id' => $salle1->id]);
        Reservation::factory()->create(['salle_id' => $salle2->id]);

        // Appel de la méthode
        $result = $reflectionMethod->invoke($this->controller);

        // Vérifications
        $this->assertCount(2, $result);
        $this->assertEquals($salle1->id, $result[0]->id);
        $this->assertEquals(3, $result[0]->total_reservations);
    }
}
