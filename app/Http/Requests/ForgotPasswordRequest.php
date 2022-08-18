<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ForgotPasswordRequest
 *
 * @property string $email;
 *
 * @package App\Http\Requests
 */
class ForgotPasswordRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'email' => 'required|email|exists:users,email',
        ];
    }
}
