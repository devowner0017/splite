<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class RegisterRequest
 *
 * @property string $type;
 * @property int $gender_id;
 *
 * @package App\Http\Requests
 */
class RegisterRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'type' => 'required|in:merchant,planner',
            'gender_id' => 'required_if:type,planner|exists:genders,id',
            'birth_date' => 'required|date_format:Y-m-d',
            'city' => 'required|string|max:255',
            'zipcode' => 'required|numeric|digits:5',
        ];
    }
}
