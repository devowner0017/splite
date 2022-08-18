<?php

namespace App\Http\Requests;

trait AuthorizedRequest {

    public function authorize(): bool {
        return true;
    }
}
