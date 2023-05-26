<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class VerifyRequest
 *
 * @property int $code;
 * @property string $email;
 *
 * @package App\Http\Requests
 */
class VerifyRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'email' => 'required|email',
            'code' => 'required|numeric|digits:5',
        ];
    }
}
