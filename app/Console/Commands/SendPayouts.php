<?php

namespace App\Console\Commands;

use App\Models\Booking;
use App\Models\Event;
use Illuminate\Console\Command;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Stripe\Payout;
use Stripe\Stripe;
use Throwable;

class SendPayouts extends Command {

    protected $signature = 'send:payouts';

    protected $description = 'Send payouts to connected accounts of merchants';

    public function handle() {

        Stripe::setApiKey(env('STRIPE_SECRET'));

        self::log('=== START ===');
        self::log('Fetching all events happened yesterday...');

        $events = Event::query()
            ->whereDoesntHave('bookings.payout')
            ->where('date', '=', now()->subDay())
            ->where('status', Event::STATUS_APPROVED)
            ->get();

        self::log('Received the events:', $events->toArray());

        try {

            /** @var Event $event */
            foreach ($events as $event) {
                self::log("Reviewing event with ID=$event->id...");
                $bookings = $event->bookings;

                $this->createPayoutsForBooking($bookings);
            }

            self::log("Fetching bookings (events) with failed payouts...");

            $bookings = Booking::query()
                ->whereHas('event', function (Builder $q) {
                    $q->where('date', '<', now()->subDay()->toDateString())
                        ->where('status', Event::STATUS_APPROVED);
                })
                ->whereDoesntHave('payout')
                ->get();

            self::log("Received the bookings:", $bookings->toArray());

            $this->createPayoutsForBooking($bookings);

        } catch (Throwable $e) {
            self::log("Exception:", $e);
        }

        self::log('=== END ===');
    }

    protected function createPayoutsForBooking(Collection $bookings): void {
        /** @var Booking $booking */
        foreach ($bookings as $booking) {

            $merchant = $booking->event->service->venue->merchant;

            $stripePayout = Payout::create([
                'amount' => ($booking->amount - $booking->fee) * 100,
                'currency' => 'usd',
            ], [
                'stripe_account' => $merchant->stripe_connect_id,
            ]);
            self::log("Payout created for contact {$booking->contact->first_name} {$booking->contact->last_name} with amount $booking->amount and fee $booking->fee");

            $payout = new \App\Models\Payout();
            $payout->booking = $booking->id;
            $payout->payout_id = $stripePayout->id;
            $payout->stripe_account = $merchant->stripe_connect_id;
            $payout->saveOrFail();

            self::log("Payout record created with ID $payout->id");
        }
    }

    protected static function log(string $message, $object = null): void {
        echo $message . PHP_EOL;
        if ($object) {
            echo json_encode($object) . PHP_EOL;
        }
    }
}
