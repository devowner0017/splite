<?php

namespace App\Http\Requests;

use App\Models\Event;

/**
 * Class ChangeEventStatusRequest
 *
 * @property string $status;
 *
 * @package App\Http\Requests
 */
class ChangeEventStatusRequest extends MerchantRequest {

    public function rules(): array {
        return [
            'status' => 'required|in:' . Event::statusesCSV(),
        ];
    }
}
