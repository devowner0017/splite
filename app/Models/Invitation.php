<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Invitation
 *
 * @property int $id;
 * @property int $event_id;
 * @property int $contact_id;
 * @property string $payment_intent_id;
 * @property string $status;
 * @property string|null $note;
 * @property string $hash;
 *
 * @property Contact $contact;
 * @property Event $event;
 *
 * @package App\Models
 */
class Invitation extends Model {
    use HasFactory;

    public const INVITED = 'invited';

    public const ACCEPTED = 'accepted';

    public const DECLINED = 'declined';

    public const UNSURE = 'unsure';

    public const REMOVED = 'removed';

    protected $hidden = [
        'hash',
        'created_at',
        'updated_at',
    ];

    public static function statuses(): array {
        return [
            self::INVITED,
            self::ACCEPTED,
            self::DECLINED,
            self::UNSURE,
            self::REMOVED,
        ];
    }

    public static function statusesCSV(): string {
        return implode(',', self::statuses());
    }

    public function contact(): ?BelongsTo {
        return $this->belongsTo(Contact::class);
    }

    public function event(): ?BelongsTo {
        return $this->belongsTo(Event::class);
    }
}
