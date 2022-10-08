<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Event
 *
 * @property int $id;
 * @property int $event_type_id;
 * @property int $planner_id;
 * @property int $service_id;
 * @property int $guests_count;
 * @property string $status;
 * @property Carbon $date;
 * @property Carbon $start_time;
 * @property Carbon $end_time;
 *
 * @property Service $service;
 * @property Planner $planner;
 * @property EventType $eventType;
 * @property Collection $invitations;
 * @property Collection $bookings;
 *
 * @package App\Models
 */
class Event extends Model {
    use HasFactory;

    public const STATUS_NEW = 'new';

    public const STATUS_APPROVED = 'approved';

    public const STATUS_DENIED = 'denied';

    public const STATUS_CANCELLED = 'cancelled';

    protected $fillable = [
        'date',
        'start_time',
        'end_time',
        'guests_count',
        'uuid',
        'service_id',
        'event_type_id',
        'status',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function service(): BelongsTo {
        return $this->belongsTo(Service::class);
    }

    public function planner(): BelongsTo {
        return $this->belongsTo(Planner::class);
    }

    public function eventType(): HasOne {
        return $this->hasOne(EventType::class, 'id', 'event_type_id');
    }

    public function invitations(): ?HasMany {
        return $this->hasMany(Invitation::class);
    }

    public function bookings(): ?HasMany {
        return $this->hasMany(Booking::class);
    }

    public static function statuses(): array {
        return [
            self::STATUS_APPROVED,
            self::STATUS_DENIED,
        ];
    }

    public static function statusesCSV(): string {
        return implode(',', self::statuses());
    }
}
