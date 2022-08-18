<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreatePaymentIntentRequest
 *
 * @property string $invitation_hash;
 *
 * @package App\Http\Requests
 */
class CreatePaymentIntentRequest extends FormRequest {

    public function rules() {
        return [
            'invitation_hash' => 'required|exists:invitations,hash',
        ];
    }
}
