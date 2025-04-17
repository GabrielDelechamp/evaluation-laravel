<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property int $surface
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\SalleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Salle whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 */
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
