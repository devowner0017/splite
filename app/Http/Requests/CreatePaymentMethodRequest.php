<?php

namespace App\Http\Requests;

use App\Models\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;

class CreatePaymentMethodRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'stripe_id' => 'required|string|max:255',
            'type' => 'required|in:' . PaymentMethod::getTypesCSV(),
        ];
    }
}
