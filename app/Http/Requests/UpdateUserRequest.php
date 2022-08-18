<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateUserRequest
 *
 * @property array $user;
 *
 * @package App\Http\Requests
 */
class UpdateUserRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'user' => 'required|array',
            'user.merchant' => 'nullable|array',
            'user.planner' => 'nullable|array',
        ];
    }
}
