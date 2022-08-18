<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMerchantRequest extends FormRequest {

    public function rules() {
        return [
            'company_industry_id' => 'nullable|exists:industries,id',
            'company_name' => 'nullable|string|max:255',
            'company_website' => 'nullable|string|max:255',
            'company_state_abbreviation' => 'nullable|exists:states,abbreviation',
            'company_zipcode' => 'nullable|string|max:255',
            'company_city' => 'nullable|string|max:255',
            'company_address_1' => 'nullable|string|max:255',
            'company_address_2' => 'nullable|string|max:255',
        ];
    }
}
