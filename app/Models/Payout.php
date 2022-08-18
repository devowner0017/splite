<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Payout
 *
 * @property int $id;
 * @property int $booking_id;
 * @property string $payout_id;
 * @property string $stripe_account;
 *
 * @property Booking $booking;
 *
 * @package App\Models
 */
class Payout extends Model {
    use HasFactory;

    public function booking(): BelongsTo {
        return $this->belongsTo(Booking::class);
    }
}
