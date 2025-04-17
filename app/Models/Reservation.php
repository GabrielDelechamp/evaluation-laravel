<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereEndTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereSalleId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereStartTime($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Reservation whereUserId($value)
 *
 * @mixin \Eloquent
 */
class Reservation extends Model
{
    use HasFactory;

    /**
     * Get the user that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Get the salle that owns the Reservation
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function salle(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Salle::class, 'salle_id');
    }

    public function formattedDate()
    {
        return Carbon::parse($this->start_time)->format('Y-m-d');
    }

    public function formattedStartTime()
    {
        return Carbon::parse($this->start_time)->format('H:i');
    }

    public function formattedEndTime()
    {
        return Carbon::parse($this->end_time)->format('H:i');
    }
}
