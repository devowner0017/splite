<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Industry
 *
 * @property int $id;
 * @property string $name;
 *
 * @package App\Models
 */
class Industry extends Model {
    use HasFactory;

    protected $table = 'industries';

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
