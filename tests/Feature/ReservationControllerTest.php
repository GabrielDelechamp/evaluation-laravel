<?php

namespace Tests\Feature;

use App\Models\Reservation;
use App\Models\Salle;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Silber\Bouncer\BouncerFacade as Bouncer;
use Tests\TestCase;

class ReservationControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected $user;
    protected $admin;
    protected $salle;

    protected function setUp(): void
    {
        parent::setUp();

        // Création du rôle admin s'il n'existe pas
        Bouncer::role()->firstOrCreate([
            'name' => 'admin',
            'title' => 'Administrator',
        ]);

        $this->user = User::factory()->create(['email' => 'user@example.com']);
        $this->admin = User::factory()->create(['email' => 'admin@example.com']);

        // Attribution du rôle admin via Bouncer
        $this->admin->assign('admin');

        $this->salle = Salle::factory()->create();
    }

    public function test_guest_cannot_access_reservations()
    {
        $this->get(route('reservation.index'))
            ->assertRedirect(route('login'));
    }

    public function test_user_can_only_see_their_reservations()
    {
        $userReservation = Reservation::factory()->create([
            'user_id' => $this->user->id,
            'salle_id' => $this->salle->id,
        ]);

        $otherReservation = Reservation::factory()->create([
            'user_id' => $this->admin->id,
            'salle_id' => $this->salle->id,
        ]);

        $this->actingAs($this->user)
            ->get(route('reservation.index'))
            ->assertStatus(200)
            ->assertViewHas('reservations')
            ->assertSee((string) $userReservation->id)
            ->assertDontSee((string) $otherReservation->id);
    }

    public function test_admin_can_see_all_reservations()
    {
        $res1 = Reservation::factory()->create(['user_id' => $this->user->id, 'salle_id' => $this->salle->id]);
        $res2 = Reservation::factory()->create(['user_id' => $this->admin->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->admin)
            ->get(route('reservation.index'))
            ->assertStatus(200)
            ->assertViewHas('reservations')
            ->assertSee((string) $res1->id)
            ->assertSee((string) $res2->id);
    }

    public function test_user_can_create_reservation()
    {
        $this->actingAs($this->user)
            ->post(route('reservation.store'), [
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '11:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertStatus(200);

        $this->assertDatabaseHas('reservations', [
            'user_id' => $this->user->id,
            'salle_id' => $this->salle->id,
        ]);
    }

    public function test_conflicting_reservation_fails()
    {
        Reservation::factory()->create([
            'user_id' => $this->admin->id,
            'salle_id' => $this->salle->id,
            'start_time' => Carbon::tomorrow()->setTime(10, 0),
            'end_time' => Carbon::tomorrow()->setTime(12, 0),
        ]);

        $this->actingAs($this->user)
            ->post(route('reservation.store'), [
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '11:00',
                'end_time' => '13:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertSessionHasErrors('conflit');
    }

    public function test_user_can_edit_own_reservation()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->user->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->user)
            ->put(route('reservation.update', $reservation), [
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '15:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertStatus(200);

        $this->assertEquals('14:00', $reservation->fresh()->start_time->format('H:i'));
    }

    public function test_user_cannot_edit_others_reservation()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->admin->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->user)
            ->put(route('reservation.update', $reservation), [
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '14:00',
                'end_time' => '15:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertStatus(403);
    }

    public function test_admin_can_edit_any_reservation()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->user->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->admin)
            ->put(route('reservation.update', $reservation), [
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '16:00',
                'end_time' => '17:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertStatus(200);

        $this->assertEquals('16:00', $reservation->fresh()->start_time->format('H:i'));
    }

    public function test_user_can_delete_own_reservation()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->user->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->user)
            ->delete(route('reservation.destroy', $reservation))
            ->assertRedirect(route('reservation.index'));

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_user_cannot_delete_others_reservation()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->admin->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->user)
            ->delete(route('reservation.destroy', $reservation))
            ->assertStatus(403);

        $this->assertDatabaseHas('reservations', ['id' => $reservation->id]);
    }

    public function test_admin_can_delete_any_reservation()
    {
        $reservation = Reservation::factory()->create(['user_id' => $this->user->id, 'salle_id' => $this->salle->id]);

        $this->actingAs($this->admin)
            ->delete(route('reservation.destroy', $reservation))
            ->assertRedirect(route('reservation.index'));

        $this->assertDatabaseMissing('reservations', ['id' => $reservation->id]);
    }

    public function test_past_date_is_rejected()
    {
        $this->actingAs($this->user)
            ->post(route('reservation.store'), [
                'date' => Carbon::yesterday()->format('Y-m-d'),
                'start_time' => '10:00',
                'end_time' => '11:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertSessionHasErrors('date');
    }

    public function test_end_time_must_be_after_start_time()
    {
        $this->actingAs($this->user)
            ->post(route('reservation.store'), [
                'date' => Carbon::tomorrow()->format('Y-m-d'),
                'start_time' => '11:00',
                'end_time' => '10:00',
                'salle_id' => $this->salle->id,
            ])
            ->assertSessionHasErrors('end_time');
    }
}
