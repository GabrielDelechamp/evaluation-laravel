<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * @property int $id
 * @property string $name
 * @property int $capacity
 * @property int $surface
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 *
 * @method static \Database\Factories\SalleFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder|Salle newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salle newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Salle query()
 * @method static \Illuminate\Database\Eloquent\Builder|Salle whereCapacity($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salle whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salle whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salle whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salle whereSurface($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Salle whereUpdatedAt($value)
 *
 * @mixin \Eloquent
 * @extends Model<Salle>
 */
class Salle extends Model
{
    use HasFactory;

    /**
     * Get all of the reservations for the Salle
     *
     * @return HasMany
     */
    public function reservation(): HasMany
    {
        return $this->hasMany(Comment::class); // Ajoute les clés personnalisées si nécessaire
    }
}
