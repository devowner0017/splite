<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Gender
 *
 * @property int $id;
 * @property string $name;
 *
 * @package App\Models
 */
class Gender extends Model {
    use HasFactory;

    protected $table = 'genders';
}
