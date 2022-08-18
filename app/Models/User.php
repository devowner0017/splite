<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use Laravel\Cashier\Billable;
use Tymon\JWTAuth\Contracts\JWTSubject;

/**
 * Class User
 *
 * @property int $id;
 * @property int $gender_id;
 * @property string $first_name;
 * @property string $last_name;
 * @property string $email;
 * @property string $password;
 * @property string $privacy_policy;
 * @property string $profile_image;
 * @property Carbon $birth_date;
 * @property string $city;
 * @property string $zipcode;
 *
 * @property Collection $verificationCodes;
 * @property Merchant $merchant;
 * @property Planner $planner;
 * @property Collection $notifications;
 *
 * @package App\Models
 */
class User extends Authenticatable implements JWTSubject {
    use HasFactory, Notifiable, Billable;

    protected $fillable = [
        'gender_id',
        'email',
        'password',
        'first_name',
        'last_name',
        'privacy_policy',
        'profile_image',
        'birth_date',
        'city',
        'zipcode',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier() {
        return $this->getKey();
    }

    public function getJWTCustomClaims() {
        return [];
    }

    public function fill(array $attributes) {

        if (isset($attributes['password'])) {
            $attributes['password'] = Hash::make($attributes['password']);
        }

        return parent::fill($attributes);
    }

    public function toArray() {
        return array_merge($this->attributesToArray(), array_filter($this->relationsToArray()));
    }

    public function merchant(): ?HasOne {
        return $this->hasOne(Merchant::class);
    }

    public function planner(): ?HasOne {
        return $this->hasOne(Planner::class);
    }

    public function verificationCodes(): ?HasMany {
        return $this->hasMany(VerificationCode::class, 'email', 'email');
    }

    public function notifications(): ?HasManyThrough {
        return $this->hasManyThrough(Notification::class, UserNotification::class);
    }
}
