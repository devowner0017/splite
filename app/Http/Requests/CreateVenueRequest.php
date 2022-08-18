<?php

namespace App\Http\Requests;

/**
 * Class CreateVenueRequest
 *
 * @property array $operation_hours;
 *
 * @package App\Http\Requests
 */
class CreateVenueRequest extends MerchantRequest {
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
            'name' => 'required|string|max:255',
            'address_2' => 'nullable|string|max:255',
            'address_1' => 'required|string|max:255',
            'zipcode' => 'required|numeric|digits:5',
            'city' => 'required|string|max:255',
            'state_abbreviation' => 'required|string|exists:states,abbreviation',
            'phone' => 'required|numeric',
            'website' => 'required|string|max:255',
            'facebook_link' => 'nullable|string|max:255',
            'logo' => 'required|string',
            'background_image' => 'required|string',

            'operation_hours' => 'required|array',
            'operation_hours.*' => 'array',
        ];
    }
}
