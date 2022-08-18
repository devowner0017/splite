<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChargeSucceededWebhookRequest;
use App\Http\Requests\GetBookingsRequest;
use App\Jobs\PaymentCompletedEmailJob;
use App\Models\Booking;
use App\Models\Invitation;
use Illuminate\Http\JsonResponse;

class BookingController extends Controller {

    public function index(GetBookingsRequest $request): JsonResponse {

        $paginatedItems = Booking::query()
            ->with(['event.service.venue'])
            ->whereHas('event.service.venue', function ($query) use ($request) {
                $query->where('venues.merchant_id', $request->getMerchant()->id);
            })->paginate($request->rpp);

        return $this->success($paginatedItems->items(), [
            'meta' => [
                'page' => $paginatedItems->currentPage(),
                'rpp' => $paginatedItems->perPage(),
                'total' => $paginatedItems->total(),
            ],
        ]);
    }

    public function store(ChargeSucceededWebhookRequest $request): JsonResponse {

        $paymentIntent = $request->data['object']['payment_intent'] ?? null;

        /** @var Invitation $invitation */
        $invitation = Invitation::query()
            ->where('payment_intent_id', $paymentIntent)
            ->where('status', Invitation::ACCEPTED)
            ->firstOrFail();

        $booking = new Booking();
        $booking->event_id = $invitation->event_id;
        $booking->contact_id = $invitation->contact_id;
        $booking->amount = isset($request->data['object']['amount']) ?
            $request->data['object']['amount'] / 100 :
            null;
        $booking->fee = isset($request->data['object']['application_fee_amount']) ?
            $request->data['object']['application_fee_amount'] / 100 :
            null;
        $booking->saveOrFail();

        PaymentCompletedEmailJob::dispatch($invitation);

        return $this->success($booking->toArray());
    }
}
