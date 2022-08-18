<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class StoreBookingRequest
 *
 * @property string $invitation_hash;
 * @property string $transaction_id;
 * @property float $amount;
 *
 * @package App\Http\Requests
 */
class StoreBookingRequest extends FormRequest {

    public function rules() {
        return [
            'invitation_hash' => 'required|exists:invitations,hash',
            'charge_id' => 'required|string|max:255',
            'amount' => 'required|numeric',
        ];
    }
}
