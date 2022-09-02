<?php

namespace App\Http\Controllers;

use App\Http\Requests\ChangeEventStatusRequest;
use App\Http\Requests\CreateEventRequest;
use App\Http\Requests\UpdateEventRequest;
use App\Http\Requests\GetEventsRequest;
use App\Http\Requests\InviteRequest;
use App\Http\Requests\UpdateInvitationStatusRequest;
use App\Jobs\EventInvitationEmailJob;
use App\Jobs\InvitationAcceptedEmailJob;
use App\Jobs\InvitationDeclinedEmailJob;
use App\Models\Booking;
use App\Models\Contact;
use App\Models\Event;
use App\Models\Invitation;
use App\Models\User;
use App\Utilities\Message;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Stripe\Account;
use Stripe\PaymentIntent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Refund;
use Stripe\StripeClient;
use Throwable;
use Illuminate\Http\Request;

class EventController extends Controller {

    public function index(GetEventsRequest $request): JsonResponse {

        /** @var User $user */
        $user = Auth::user();
        try {
            // $paginatedItems = $request->getPlanner()->contacts()->get();
            // return $this->success($paginatedItems->toArray());
            if ($planner = $user->planner) {
                $paginatedItems = $planner->events()->with(['service', 'eventType'])->paginate($request->rpp);
                // $paginatedItems = $planner->events()->with(['service', 'eventType'])->get();
            } else if ($merchant = $user->merchant) {
                $paginatedItems = Event::query()
                    ->with(['service', 'eventType', 'planner.user'])
                    ->whereHas('service.venue', function (Builder $query) use ($merchant) {
                        $query->where('merchant_id', $merchant->id);
                    })
                    ->paginate($request->rpp);
                    // ->get();
                
            }

            // return $this->success($paginatedItems->toArray());
            return $this->success($paginatedItems->items(), [
                'meta' => [
                    'page' => $paginatedItems->currentPage(),
                    'rpp' => $paginatedItems->perPage(),
                    'total' => $paginatedItems->total(),
                ],
            ]);


        } catch (\Exception $e) {
            dd($e);
        }
     }

    // public function eventsByPlanner(GetEventsRequest $request): JsonResponse {

    // }

    public function show(Event $event): JsonResponse {
        return $this->success($event->toArray());
    }

    public function store(CreateEventRequest $request): JsonResponse {

        $event = new Event();
        $event->planner_id = Auth::user()->planner->id;
        $event->fill($request->getFillableData());

        $event->saveOrFail();

        return $this->success($event->refresh()->toArray(), [], 201);
    }

    public function update(UpdateEventRequest $request, $event_id): JsonResponse {
        $user = Auth::user();
        $eventItem = Event::query()
                    ->where('id', $request->event_id)
                    ->firstOrFail();
        $guestCount = $eventItem->guests_count;
        $guestCount += (int)$request->guests_count;
        $eventItem->guests_count = $guestCount;
        $eventItem->saveOrFail();
        return $this->success($eventItem->toArray());
    }

    public function getInvitationStatusByEvent(string $event): JsonResponse {
        /** @var User $user */
        $event = json_decode($event);
        /** @var Invitation $invitation */
        $invitationItems = Invitation::query()
            ->where('event_id', $event->id)
            ->get();

        return $this->success($invitationItems->toArray());
    }

    public function changeEventStatus(Event $event, ChangeEventStatusRequest $request): JsonResponse {

        /** @var User $user */
        $user = Auth::user();

        if ($event->service->venue->merchant_id !== $user->merchant->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        if ($event->status !== Event::STATUS_NEW) {
            return $this->error(Message::EVENT_STATUS_IS_ALREADY_SET, 403);
        }

        $event->status = $request->status;
        $event->saveOrFail();

        if ($request->status === Event::STATUS_APPROVED) {
            /** @var Invitation $invitation */
            foreach ($event->invitations as $invitation) {
                EventInvitationEmailJob::dispatch($invitation);
            }
        } else {
            $event->invitations()->delete();
        }

        return $this->success($event->refresh()->toArray());
    }
    
    public function cancelEvent(Event $event): JsonResponse {
        
        /** @var User $user */
        $user = Auth::user();

        if ($event->service->venue->merchant_id !== $user->merchant->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        if ($event->status === Event::STATUS_CANCELLED) {
            return $this->error(Message::EVENT_ALREADY_CANCELLED, 400);
        }

        DB::beginTransaction();

        try {

            /** @var Booking $booking */
            foreach ($event->bookings as $booking) {
                /** @var Invitation $invitation */
                $invitation = Invitation::query()
                    ->where('contact_id', $booking->contact_id)
                    ->where('event_id', $booking->event_id)
                    ->where('status', Invitation::ACCEPTED)
                    ->firstOrFail();

                Refund::create([
                    'payment_intent' => $invitation->payment_intent_id,
                ]);
            }

            $event->bookings()->delete();
            $event->status = Event::STATUS_CANCELLED;
            $event->saveOrFail();

            DB::commit();

        } catch (Throwable $e) {
            DB::rollBack();
            Log::debug($e->getMessage(), [$e]);
            return $this->error(Message::SOMETHING_WENT_WRONG, 500);
        }

        return $this->success();
    }

    public function invite(Event $event, InviteRequest $request): JsonResponse {

        if ($event->planner_id !== $request->getPlanner()->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        $invited = Invitation::query()
            ->where('event_id', $event->id)
            ->whereIn('contact_id', $request->contact_ids)
            ->first();

        if ($invited) {
            return $this->error(Message::CONTACT_INVITED, 422);
        }

        $contacts = Contact::query()->where('planner_id', $request->getPlanner()->id)->findMany($request->contact_ids);

        if ($contacts->count() !== count($request->contact_ids)) {
            return $this->error(Message::CONTACT_NOT_FOUND, 404);
        }

        /** @var Contact $contact */
        foreach ($contacts as $contact) {
            $invitation = new Invitation();

            $invitation->event_id = $event->id;
            $invitation->contact_id = $contact->id;
            $invitation->status = Invitation::INVITED;

            $invitation->hash = md5("{$event->id} {$contact->id}");

            $invitation->saveOrFail();

            if ($event->status === Event::STATUS_APPROVED) {
                EventInvitationEmailJob::dispatch($invitation);
            }
        }

        return $this->success();
    }

    public function addInvite(Event $event, InviteRequest $request) : JsonResponse {
        //TODO
        // check invitation/contact table save logic 
        //save  get edited event
        // 
        /** @var User $user */
        if ($event->planner_id !== $request->getPlanner()->id) {
            return $this->error(Message::NOT_FOUND, 404);
        }

        // $invited = Invitation::query()
        //     ->where('event_id', $event->id)
        //     ->whereIn('contact_id', $request->contact_ids)
        //     ->first();

        // if ($invited) {
        //     return $this->error(Message::CONTACT_INVITED, 422);
        // }
        $contacts = Contact::query()->where('planner_id', $request->getPlanner()->id)->findMany($request->contact_ids);
        if ($contacts->count() !== count($request->contact_ids)) {
            return $this->error(Message::CONTACT_NOT_FOUND, 404);
        }
        /** @var Contact $contact */
        foreach ($contacts as $contact) {
            $invitation = new Invitation();
            $invited = Invitation::query()
            ->where('event_id', $event->id)
            ->where('contact_id', $contact->id)
            ->first();

            if ($invited) {
                continue;
            }
            $invitation->event_id = $event->id;
            $invitation->contact_id = $contact->id;
            $invitation->status = Invitation::INVITED;

            $invitation->hash = md5("{$event->id} {$contact->id}");

            $invitation->saveOrFail();
            if ($event->status === Event::STATUS_APPROVED) {
                EventInvitationEmailJob::dispatch($invitation);
            }
        }

        return $this->success();
    }

    public function getInvitationDetails(string $hash): JsonResponse {

        /** @var Invitation $invitation */
        $invitation = Invitation::query()
            ->with(['contact', 'event'])
            ->where('hash', $hash)
            ->firstOrFail();

        $account = Account::retrieve($invitation->event->service->venue->merchant->stripe_connect_id);

        if ($account->charges_enabled) {
            $fee = floor(env('APPLICATION_FEE_PERCENT') * $invitation->event->service->price);

            if (!$invitation->payment_intent_id) {
                $paymentIntent = PaymentIntent::create([
                    'payment_method_types' => [
                        'card'
                    ],
                    'amount' => $invitation->event->service->price * 100,
                    'currency' => 'usd',
                    'application_fee_amount' => $fee,
                    'transfer_data' => [
                        'destination' => $invitation->event->service->venue->merchant->stripe_connect_id,
                    ],
                ]);

                $invitation->payment_intent_id = $paymentIntent->id;
                $invitation->saveOrFail();
            } else {
                $paymentIntent = PaymentIntent::retrieve($invitation->payment_intent_id);
            }

            $invitation->payment_intent_id_secret = $paymentIntent->client_secret;
        } else {
            Log::debug("Charges are not enabled for the account", $invitation->toArray());
            $invitation->payment_intent_id_secret = null;
        }

        return $this->success($invitation->toArray());
    }

    public function updateInvitationStatus(string $hash, UpdateInvitationStatusRequest $request): JsonResponse {

        $status = $request->status;

        /** @var Invitation $invitation */
        $invitation = Invitation::query()
            ->where('hash', $hash)
            ->firstOrFail();

        if ($invitation->status !== Invitation::INVITED) {
            return $this->error(Message::INVITATION_STATUS_IS_ALREADY_SET, 403);
        }

        $invitation->status = $status;
        $invitation->note = $request->reason;

        switch ($status) {
            case Invitation::ACCEPTED:
                InvitationAcceptedEmailJob::dispatch($invitation);
                break;
            case Invitation::DECLINED:
                InvitationDeclinedEmailJob::dispatch($invitation);
                break;
            case Invitation::UNSURE:
                // TODO: notify the merchant after 8 hours or so if the spot hasn't been filled already
                // TODO: notify the planner to fill the spot
            case Invitation::REMOVED:
                // TODO: notify the planner
                break;
            default:
                break;
        }

        $invitation->saveOrFail();

        return $this->success($invitation->refresh()->toArray());
    }
}
