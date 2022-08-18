<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResendRequest
 *
 * @property string $email;
 *
 * @package App\Http\Requests
 */
class ResendRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }
}
