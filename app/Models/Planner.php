<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Planner
 *
 * @property int $id;
 * @property int $user_id;
 *
 * @property User $user;
 * @property Collection $contacts;
 * @property Collection $events;
 *
 * @package App\Models
 */
class Planner extends Model {
    use HasFactory;

    protected $table = 'planners';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function contacts(): ?HasMany {
        return $this->hasMany(Contact::class);
    }

    public function events(): ?HasMany {
        return $this->hasMany(Event::class);
    }
}
