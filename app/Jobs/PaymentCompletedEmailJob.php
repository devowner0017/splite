<?php

namespace App\Jobs;

use App\Exceptions\FailedToSendEmailException;
use App\Models\Invitation;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class PaymentCompletedEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Invitation $invitation;

    public function __construct(Invitation $invitation) {
        $this->invitation = $invitation;
    }

    public function handle() {

        $isSent = (new EmailService)->sendPaymentCompletedEmailContact([
            'first_name' => $this->invitation->contact->first_name,
            'email' => $this->invitation->contact->email,
        ], $this->invitation->contact->first_name, $this->invitation->event->service->name);

        $isSent &= (new EmailService)->sendPaymentCompletedEmailMerchant([
            'first_name' => $this->invitation->event->service->venue->merchant->user->first_name,
            'email' => $this->invitation->event->service->venue->merchant->user->email,
        ],
            $this->invitation->event->service->venue->merchant->user->first_name,
            $this->invitation->contact->first_name,
            $this->invitation->contact->email,
            $this->invitation->event->service->name
        );

        $isSent &= (new EmailService)->sendPaymentCompletedEmailPlanner([
            'first_name' => $this->invitation->event->planner->user->first_name,
            'email' => $this->invitation->event->planner->user->email,
        ],
            $this->invitation->event->planner->user->first_name,
            $this->invitation->contact->first_name,
            $this->invitation->contact->email,
            $this->invitation->event->service->name
        );

        if (!$isSent) {
            throw new FailedToSendEmailException();
        }
    }
}
