<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Database\Factories\SalleFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Reservation;

class Salle extends Model
{
    use HasFactory;

    /**
    * Get all of the reservation for the Salle
    *
    * @return \Illuminate\Database\Eloquent\Relations\HasMany
    */
    public function reservation(): HasMany
    {
        return $this->hasMany(Comment::class, 'foreign_key', 'local_key');
    }

}
