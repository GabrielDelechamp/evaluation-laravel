<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;
use App\Models\Salle;

/**
 * @property int $id
 * @property string $start_time
 * @property string $end_time
 * @property int $salle_id
 * @property int $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @property-read \App\Models\Salle|null $salle
 * @property-read \App\Models\User|null $user
 *
 * @method static \Database\Factories\ReservationFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereSalleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Reservation whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Reservation
     *
     * @return BelongsTo<User, Reservation>
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the salle that owns the Reservation
     *
     * @return BelongsTo<Salle, Reservation>
     */
    public function salle(): BelongsTo
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }

    /**
     * Get the formatted date of the reservation
     *
     * @return string
     */
    public function formattedDate(): string
    {
        return Carbon::parse($this->start_time)->format('Y-m-d');
    }

    /**
     * Get the formatted start time of the reservation
     *
     * @return string
     */
    public function formattedStartTime(): string
    {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    /**
     * Get the formatted end time of the reservation
     *
     * @return string
     */
    public function formattedEndTime(): string
    {
        return Carbon::parse($this->end_time)->format('H:i');
    }
}
