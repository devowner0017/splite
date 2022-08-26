<?php

namespace App\Http\Requests;

/**
 * Class InviteRequest
 *
 * @property array $event_id;
 *
 * @package App\Http\Requests
 */
class InvitationStatusRequest extends PlannerRequest {

    public function rules(): array {
        return [
            'event_id' => 'required',
        ];
    }
}