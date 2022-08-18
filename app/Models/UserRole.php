<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserRole
 *
 * @property int $id;
 * @property int $user_id;
 * @property int $role_id;
 *
 * @package App\Models
 */
class UserRole extends Model {
    use HasFactory;

    protected $table = 'user_roles';

    public function setRole(string $type): void {
        $this->role_id = Role::query()
            ->where('name', $type)
            ->firstOrFail()
            ->id;
    }
}
