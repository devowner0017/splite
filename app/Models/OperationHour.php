<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class OperationHour
 *
 * @property int $id;
 * @property int $venue_id;
 * @property int $weekday_id;
 * @property Carbon $start_time;
 * @property Carbon $end_time;
 *
 * @property Venue $venue;
 * @property Weekday $weekday;
 *
 * @package App\Models
 */
class OperationHour extends Model {
    use HasFactory;

    protected $table = 'operation_hours';

    protected $fillable = [
        'venue_id',
        'weekday_id',
        'start_time',
        'end_time',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function venue(): BelongsTo {
        return $this->belongsTo(Venue::class);
    }

    public function weekday(): BelongsTo {
        return $this->belongsTo(Weekday::class);
    }
}
