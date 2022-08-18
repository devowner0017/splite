<?php

namespace App\Http\Requests;

class UpdateServiceRequest extends MerchantRequest {
    use FillableRequest;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->fillable = [
            'name',
            'type',
            'description',
            'information_content',
            'extra_note',
            'phone',
            'website',
            'address_2',
            'address_1',
            'zipcode',
            'city',
            'state_abbreviation',
            'image_url',
        ];
    }

    public function rules(): array {
        return [
            'name' => 'string|max:255',
            'description' => 'string|max:25560',
            'information_content' => 'nullable|string|max:25560',
            'extra_note' => 'nullable|string|max:255',
            'same_address' => 'boolean',
            'address_2' => 'required_if:same_address,false|nullable|string|max:255',
            'address_1' => 'required_if:same_address,false|nullable|string|max:255',
            'zipcode' => 'required_if:same_address,false|nullable|numeric|digits:5',
            'city' => 'required_if:same_address,false|nullable|string|max:255',
            'state_abbreviation' => 'required_if:same_address,false|nullable|string|exists:states,abbreviation',
            'phone' => 'numeric',
            'website' => 'string|max:255',
            'image_url' => 'string',
        ];
    }
}
