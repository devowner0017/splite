<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class State
 *
 * @property string $abbreviation;
 * @property string $name;
 *
 * @package App\Models
 */
class State extends Model {
    use HasFactory;

    protected $table = 'states';

    protected $primaryKey = 'abbreviation';

    protected $keyType = 'string';
}
