<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddBankAccountRequest
 *
 * @property string $bank_name;
 * @property string $holder_name;
 * @property string $routing_number;
 * @property string $account_number;
 *
 * @package App\Http\Requests
 */
class AddBankAccountRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'bank_name' => 'required|string|max:255',
            'holder_name' => 'required|string|max:255',
            'routing_number' => 'required|numeric',
            'account_number' => 'required|numeric',
        ];
    }
}
