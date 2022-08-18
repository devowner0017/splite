<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller as BaseController;
use Stripe\Stripe;

class Controller extends BaseController {
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct() {
        Stripe::setApiKey(env('STRIPE_SECRET'));
    }

    public function success(array $data = [], array $additionalData = [], int $code = 200): JsonResponse {
        return response()->json(compact('data') + $additionalData, $code)->header('Access-Control-Expose-Headers', 'Authorization');
    }

    public function error(string $message, int $code): JsonResponse {
        return response()->json(compact('message'), $code)->header('Access-Control-Expose-Headers', 'Authorization');
    }
}
