<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ResetPasswordRequest
 *
 * @property int $id;
 * @property string $email;
 * @property string $code;
 * @property string $password;
 * @property string $password_confirmation;
 *
 * @package App\Http\Requests
 */
class ResetPasswordRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'email' => 'required|email|exists:users,email',
            'code' => 'required|string|max:250',
            'password' => 'required|string|confirmed',
        ];
    }
}
