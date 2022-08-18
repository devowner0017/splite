<?php

namespace App\Http\Requests;

/**
 * Class UpdateContactRequest
 *
 * @property string $first_name;
 * @property string $last_name;
 *
 * @package App\Http\Requests
 */
class UpdateContactRequest extends PlannerRequest {

    public function rules(): array {
        return [
            'first_name' => 'nullable|string|max:255',
            'last_name' => 'nullable|string|max:255',
        ];
    }
}
