<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class VerificationCode
 *
 * @property int $id;
 * @property string $email;
 * @property string $code;
 *
 * @package App\Models
 */
class VerificationCode extends Model {
    use HasFactory;

    protected $table = 'verification_codes';

    public $timestamps = false;

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
