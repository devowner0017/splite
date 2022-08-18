<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetAllVenuesRequest;
use App\Http\Requests\GetVenueServicesRequest;
use App\Models\Gender;
use App\Models\Industry;
use App\Models\Notification;
use App\Models\State;
use App\Models\Venue;
use App\Models\Weekday;
use Illuminate\Http\JsonResponse;

class LookupController extends Controller {

    public function industries(): JsonResponse {
        return $this->success(Industry::query()->get()->toArray());
    }

    public function states(): JsonResponse {
        return $this->success(State::query()->get()->toArray());
    }

    public function genders(): JsonResponse {
        return $this->success(Gender::query()->get()->toArray());
    }

    public function weekdays(): JsonResponse {
        return $this->success(Weekday::query()->get()->toArray());
    }

    public function venues(GetAllVenuesRequest $request): JsonResponse {
        $paginatedItems = Venue::query()->paginate($request->rpp);
        return $this->success($paginatedItems->items(), [
            'meta' => [
                'page' => $paginatedItems->currentPage(),
                'rpp' => $paginatedItems->perPage(),
                'total' => $paginatedItems->total(),
            ],
        ]);
    }

    public function services(Venue $venue, GetVenueServicesRequest $request): JsonResponse {
        $paginatedItems = $venue->services()->paginate($request->rpp);
        return $this->success($paginatedItems->items(), [
            'meta' => [
                'page' => $paginatedItems->currentPage(),
                'rpp' => $paginatedItems->perPage(),
                'total' => $paginatedItems->total(),
            ],
        ]);
    }

    public function notifications(): JsonResponse {
        return $this->success(Notification::query()->get()->toArray());
    }
}
