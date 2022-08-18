<?php

namespace App\Http\Requests;

class GetVenuesRequest extends MerchantRequest {
    use PaginationRequest {
        rules as pRules;
    }

    public function rules(): array {
        return $this->pRules();
    }
}
