<?php

namespace App\Http\Requests;

/**
 * Trait PaginationRequest
 *
 * @property int $page;
 * @property int $rpp;
 *
 * @package App\Http\Requests
 */
trait PaginationRequest {

    public function rules(): array {
        return [
            'page' => 'numeric',
            'rpp' => 'required|numeric',
        ];
    }
}
