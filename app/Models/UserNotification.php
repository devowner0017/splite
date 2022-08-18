<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserNotification
 *
 * @property int $id;
 * @property int $user_id;
 * @property int $notification_id;
 *
 * @package App\Models
 */
class UserNotification extends Model {
    use HasFactory;

    protected $table = 'user_notifications';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
