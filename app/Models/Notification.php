<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Notification
 *
 * @property int $id;
 * @property string $name;
 *
 * @package App\Models
 */
class Notification extends Model {
    use HasFactory;

    protected $table = 'notifications';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
