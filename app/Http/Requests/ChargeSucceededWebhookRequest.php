<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class ChargeSucceededWebhookRequest
 *
 * @property array|object $data;
 *
 * @package App\Http\Requests
 */
class ChargeSucceededWebhookRequest extends FormRequest {

    public function rules() {
        return [];
    }
}
