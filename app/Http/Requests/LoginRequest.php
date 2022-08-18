<?php

namespace App\Http\Requests;

use App\Utilities\UserType;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class LoginRequest
 *
 * @property string $type;
 *
 * @package App\Http\Requests
 */
class LoginRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'email' => 'required|email',
            'type' => 'required|in:' . UserType::allCSV(),
        ];
    }
}
