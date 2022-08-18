<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Role
 *
 * @property int $id;
 * @property string $name;
 *
 * @package App\Models
 */
class Role extends Model {
    use HasFactory;

    const MERCHANT = 'Merchant';
    const PLANNER = 'Planner';

    protected $table = 'roles';
}
