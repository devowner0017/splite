<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChangePasswordRequest
 *
 * @property string $password;
 * @property string $new_password;
 * @property string $new_password_confirmation;
 *
 * @package App\Http\Requests
 */
class ChangePasswordRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'password' => 'required|string|max:255',
            'new_password' => 'required|confirmed|string|max:255',
        ];
    }
}
