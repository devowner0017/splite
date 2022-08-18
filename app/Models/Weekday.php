<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Weekday
 *
 * @property int $id;
 * @property string $name;
 *
 * @package App\Models
 */
class Weekday extends Model {
    use HasFactory;

    protected $table = 'weekdays';
}
