<?php

namespace App\Http\Requests;

use App\Models\Invitation;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class UpdateInvitationStatusRequest
 *
 * @property string $status;
 * @property int $invitation_id;
 * @property string $reason;
 *
 * @package App\Http\Requests
 */
class UpdateInvitationStatusRequest extends FormRequest {

    public function rules() {
        return [
            'status' => 'required|in:' . Invitation::statusesCSV(),
            'reason' => 'nullable',
        ];
    }
}
