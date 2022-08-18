<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PaymentMethod
 *
 * @property int $id;
 * @property int $user_id;
 * @property string $stripe_id;
 * @property string $type;
 * @property bool $primary;
 *
 * @package App\Models
 */
class PaymentMethod extends Model {
    use HasFactory;

    public const PAYMENT_METHOD_TYPE_BANK_ACCOUNT = 'bank_account';

    public const PAYMENT_METHOD_TYPE_CREDIT_CARD = 'credit_card';

    protected $table = 'payment_methods';

    protected $fillable = [
        'user_id',
        'stripe_id',
        'type',
        'primary',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public static function getTypes(): array {
        return [
            self::PAYMENT_METHOD_TYPE_BANK_ACCOUNT,
            self::PAYMENT_METHOD_TYPE_CREDIT_CARD,
        ];
    }

    public static function getTypesCSV(): string {
        return implode(',', self::getTypes());
    }
}
