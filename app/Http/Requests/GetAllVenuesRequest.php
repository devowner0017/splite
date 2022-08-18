<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetAllVenuesRequest extends FormRequest {
    use PaginationRequest;
}
