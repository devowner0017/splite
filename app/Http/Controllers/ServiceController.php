<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateServiceRequest;
use App\Http\Requests\GetVenueServicesRequest;
use App\Http\Requests\UpdateServiceRequest;
use App\Models\Service;
use App\Models\Venue;
use App\Utilities\Message;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class ServiceController extends Controller {

    public function index(Venue $venue, GetVenueServicesRequest $request): JsonResponse {

        $paginatedItems = $venue->services()->with(['venue'])->paginate($request->rpp);
        return $this->success($paginatedItems->items(), [
            'meta' => [
                'page' => $paginatedItems->currentPage(),
                'rpp' => $paginatedItems->perPage(),
                'total' => $paginatedItems->total(),
            ],
        ]);
    }

    public function store(Venue $venue, CreateServiceRequest $request): JsonResponse {

        if ($venue->merchant_id !== Auth::user()->merchant->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        $service = new Service();

        $service->generateCode();
        $service->venue_id = $venue->id;
        $service->fill($request->getFillableData());


        $service->saveOrFail();

        return $this->success($service->refresh()->toArray(), [], 201);
    }

    public function update(Venue $venue, Service $service, UpdateServiceRequest $request): JsonResponse {

        if ($venue->merchant_id !== Auth::user()->merchant->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        $service->fill($request->getFillableData());

        $service->saveOrFail();

        return $this->success($service->refresh()->toArray());
    }
}
