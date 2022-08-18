<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordReset
 *
 * @property int $id;
 * @property string $email;
 * @property string $code;
 *
 * @package App\Models
 */
class PasswordReset extends Model {
    use HasFactory;

    protected $table = 'password_resets';

    public $timestamps = false;

    protected static function boot() {
        parent::boot();

        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
