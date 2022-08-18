<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * Class Service
 *
 * @property int $id;
 * @property int $venue_id;
 * @property string $name;
 * @property string $description;
 * @property string $information_content;
 * @property string $type;
 * @property float $price;
 * @property string $code;
 * @property int $min_participants;
 * @property int $max_participants;
 * @property int $quota;
 * @property string $extra_note;
 * @property string $address_2;
 * @property string $address_1;
 * @property string $zipcode;
 * @property string $city;
 * @property string $state_abbreviation;
 * @property string $phone;
 * @property string $website;
 * @property string $image_url;
 *
 * @property Venue $venue;
 *
 * @package App\Models
 */
class Service extends Model {
    use HasFactory;

    protected $table = 'services';

    protected $fillable = [
        'venue_id',
        'name',
        'description',
        'information_content',
        'type',
        'price',
        'code',
        'min_participants',
        'max_participants',
        'quota',
        'extra_note',
        'address_2',
        'address_1',
        'zipcode',
        'city',
        'state_abbreviation',
        'phone',
        'website',
        'image_url',
        'launch_date',
        'image_url',
    ];

    protected $hidden = [
        'created_at',
        'updated_at',
    ];

    public function venue(): ?BelongsTo {
        return $this->belongsTo(Venue::class);
    }

    public function generateCode(): void {
        if ($this->code) {
            return;
        }

        do {
            $code = substr(str_shuffle('0123456789'), 0, 7);
        } while (Service::query()->where('code', $code)->first());

        $this->code = $code;
    }
}
