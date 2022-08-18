<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Merchant
 *
 * @property int $id;
 * @property int $user_id;
 * @property string $stripe_connect_id;
 * @property int $company_industry_id;
 * @property string $company_state_abbreviation;
 * @property string $company_name;
 * @property string $company_website;
 * @property string $company_city;
 * @property string $company_zipcode;
 * @property string $company_address_1;
 * @property string $company_address_2;
 *
 * @property array $venues;
 * @property User $user;
 *
 * @package App\Models
 */
class Merchant extends Model {
    use HasFactory;

    protected $table = 'merchants';

    protected $fillable = [
        'company_industry_id',
        'company_state_abbreviation',
        'company_name',
        'company_website',
        'company_city',
        'company_zipcode',
        'company_address_1',
        'company_address_2',
        'stripe_connect_id',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function toArray() {
        return parent::toArray() + [
            'company_physical_number_address' => 2,
        ];
    }

    public function venues(): ?HasMany {
        return $this->hasMany(Venue::class);
    }
}
