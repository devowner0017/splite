<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Venue
 *
 * @property int $id;
 * @property int $merchant_id;
 * @property string $name;
 * @property string $address_2;
 * @property string $address_1;
 * @property string $zipcode;
 * @property string $city;
 * @property string $state_abbreviation;
 * @property string $website;
 * @property string $phone;
 * @property string $logo;
 * @property string $background_image;
 * @property string $facebook_link;
 *
 * @property Merchant $merchant;
 * @property Collection $services;
 * @property array $operationHours;
 *
 * @package App\Models
 */
class Venue extends Model {
    use HasFactory;

    protected $table = 'venues';

    protected $with = [
        'operationHours',
    ];

    protected $fillable = [
        'name',
        'address_2',
        'address_1',
        'zipcode',
        'city',
        'state_abbreviation',
        'website',
        'phone',
        'logo',
        'background_image',
        'facebook_link',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function merchant(): ?BelongsTo {
        return $this->belongsTo(Merchant::class);
    }

    public function services(): ?HasMany {
        return $this->hasMany(Service::class);
    }

    public function operationHours(): ?HasMany {
        return $this->hasMany(OperationHour::class);
    }
}
