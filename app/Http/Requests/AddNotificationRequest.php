<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * Class AddNotificationRequest
 *
 * @property array|null $notification_ids;
 *
 * @package App\Http\Requests
 */
class AddNotificationRequest extends FormRequest {
    use AuthorizedRequest;

    public function rules() {
        return [
            'notification_ids' => 'required|nullable|array',
            'notification_ids.*' => 'exists:notifications,id',
        ];
    }
}
