<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Contact
 *
 * @property int $id;
 * @property int $planner_id;
 * @property string $email;
 * @property string $first_name;
 * @property string $last_name;
 *
 * @package App\Models
 */
class Contact extends Model {
    use HasFactory;

    protected $table = 'contacts';

    protected $fillable = [
        'email',
        'first_name',
        'last_name',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
