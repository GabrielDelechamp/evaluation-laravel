<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Salle;
use App\Models\User;
use Carbon\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class ReservationFactory extends Factory
{
    public function definition(): array
    {
        // Génère un start_time aléatoire entre demain et dans 30 jours
        $start = $this->faker->dateTimeBetween('+1 day', '+30 days');

        // Génère un end_time entre 1 et 8 heures après le start_time
        $end = (clone $start)->modify('+' . rand(1, 8) . ' hours');

        return [
            'start_time' => $start,
            'end_time' => $end,
            'salle_id' => Salle::factory(),
            'user_id' => User::factory(),
        ];
    }
}
