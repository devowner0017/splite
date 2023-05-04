<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateVenueRequest;
use App\Http\Requests\GetVenuesRequest;
use App\Http\Requests\UpdateVenueRequest;
use App\Models\OperationHour;
use App\Models\Venue;
use App\Utilities\Message;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Throwable;

class VenueController extends Controller {

    public function index(GetVenuesRequest $request): JsonResponse {
        $paginatedItems = $request->getMerchant()->venues()->paginate($request->rpp);
        return $this->success($paginatedItems->items(), [
            'meta' => [
                'page' => $paginatedItems->currentPage(),
                'rpp' => $paginatedItems->perPage(),
                'total' => $paginatedItems->total(),
            ],
        ]);
    }

    public function store(CreateVenueRequest $request): JsonResponse {

        $venue = new Venue();

        DB::beginTransaction();
        try {

            $venue->fill($request->getFillableData());
            $venue->merchant_id = $request->getMerchant()->id;

            $venue->saveOrFail();

            foreach ($request->operation_hours as $operation_hour) {
                $operationHour = new OperationHour();
                $operationHour->venue_id = $venue->id;
                $operationHour->fill($operation_hour);

                $operationHour->saveOrFail();
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success(Venue::query()->with(['operationHours', 'services', 'merchant'])->findOrFail($venue->refresh()->id)->toArray(), [], 201);
    }

    public function update(Venue $venue, UpdateVenueRequest $request): JsonResponse {

        if ($venue->merchant_id !== $request->getMerchant()->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        DB::beginTransaction();
        try {

            $venue->fill($request->getFillableData());
            $venue->saveOrFail();

            if ($request->operation_hours) {

                $isDeleted = OperationHour::query()->where('venue_id', $venue->id)->delete();

                if (!$isDeleted) {
                    throw new Exception();
                }

                foreach ($request->operation_hours as $operation_hour) {
                    $operationHour = new OperationHour();
                    $operationHour->venue_id = $venue->id;
                    $operationHour->fill($operation_hour);

                    $operationHour->saveOrFail();
                }
            }

            DB::commit();
        } catch (Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return $this->success($venue->refresh()->toArray());
    }
    public function destroy( $id) {

        DB::beginTransaction();
        try {
            $venue = Venue:: findOrFail($id->id);
            $venue->delete();
            DB::commit();
        } catch(Throwable $e) {
            DB::rollBack();
            throw $e;
        }

        return response()->json($id);
    }
}
