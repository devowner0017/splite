<?php

namespace App\Http\Requests;

/**
 * Class UpdateVenueRequest
 *
 * @property array $operation_hours;
 *
 * @package App\Http\Requests
 */
class UpdateVenueRequest extends MerchantRequest {
    use FillableRequest;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->fillable = [
            'name',
            'address_2',
            'address_1',
            'zipcode',
            'city',
            'state_abbreviation',
            'phone',
            'website',
            'facebook_link',
            'logo',
            'background_image',
        ];
    }

    public function rules(): array {
        return [
            'name' => 'nullable|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'address_1' => 'nullable|string|max:255',
            'zipcode' => 'nullable|numeric|digits:5',
            'city' => 'nullable|string|max:255',
            'state_abbreviation' => 'nullable|string|exists:states,abbreviation',
            'phone' => 'nullable|numeric',
            'website' => 'nullable|string|max:255',
            'facebook_link' => 'nullable|string|max:255',
            'logo' => 'string',
            'background_image' => 'string',

            'operation_hours' => 'nullable|array',
            'operation_hours.*' => 'array',
        ];
    }
}
