<?php

namespace App\Http\Requests;

class CreateServiceRequest extends MerchantRequest {
    use FillableRequest;

    public function __construct(array $query = [], array $request = [], array $attributes = [], array $cookies = [], array $files = [], array $server = [], $content = null) {
        parent::__construct($query, $request, $attributes, $cookies, $files, $server, $content);

        $this->fillable = [
            'name',
            'description',
            'information_content',
            'type',
            'price',
            'per_unit',
            'min_participants',
            'max_participants',
            'quota',
            'extra_note',
            'phone',
            'website',
            'launch_date',
            'image_url',
        ];
    }

    public function rules(): array {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string|max:25560',
            'information_content' => 'nullable|string|max:25560',
            'type' => 'required|string|max:255',
            'price' => 'required|numeric',
            'per_unit' => 'required|string|max:255',
            'min_participants' => 'required|nullable|numeric',
            'max_participants' => 'required|nullable|numeric',
            'quota' => 'required|nullable|numeric',
            'extra_note' => 'nullable|string|max:255',
            'same_address' => 'required|boolean',
            'address_2' => 'required_if:same_address,false|nullable|string|max:255',
            'address_1' => 'required_if:same_address,false|nullable|string|max:255',
            'zipcode' => 'required_if:same_address,false|nullable|numeric|max:5',
            'city' => 'required_if:same_address,false|nullable|string|max:255',
            'state_abbreviation' => 'required_if:same_address,false|nullable|string|exists:states,abbreviation',
            'phone' => 'required|numeric',
            'website' => 'required|string|max:255',
            'image_url' => 'required|string',
            'launch_date' => 'required|after:today|date_format:Y-m-d',
        ];
    }
}
