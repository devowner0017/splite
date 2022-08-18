<?php

namespace App\Http\Requests;

/**
 * Class InviteRequest
 *
 * @property array $contact_ids;
 *
 * @package App\Http\Requests
 */
class InviteRequest extends PlannerRequest {

    public function rules(): array {
        return [
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'required|exists:contacts,id',
        ];
    }
}
