<?php

namespace App\Http\Requests;

/**
 * Class CreateContactRequest
 *
 * @property string $first_name;
 * @property string $last_name;
 * @property string $email;
 *
 * @package App\Http\Requests
 */
class CreateContactRequest extends PlannerRequest {

    public function rules(): array {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email',
        ];
    }
}
