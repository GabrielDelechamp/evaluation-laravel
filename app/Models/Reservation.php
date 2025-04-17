<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\ReservationFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;
use App\Models\Salle;
use Carbon\Carbon;


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
        return $this->belongsTo(Salle::class,'salle_id');
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
