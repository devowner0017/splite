<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GetEventsRequest extends FormRequest {
    use PaginationRequest;
}
