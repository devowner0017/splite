<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class Booking
 *
 * @property int $contact_id;
 * @property int $event_id;
 * @property float $amount;
 * @property float $fee;
 *
 * @property Contact $contact;
 * @property Event $event;
 * @property Payout $payout;
 *
 * @package App\Models
 */
class Booking extends Model {
    use HasFactory;

    protected $fillable = [
        'contact_id',
        'event_id',
        'amount',
        'fee',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function contact(): BelongsTo {
        return $this->belongsTo(Contact::class);
    }

    public function event(): BelongsTo {
        return $this->belongsTo(Event::class);
    }

    public function payout(): ?HasOne {
        return $this->hasOne(Payout::class);
    }
}
