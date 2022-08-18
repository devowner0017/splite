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

class InvitationAcceptedEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Invitation $invitation;

    public function __construct(Invitation $invitation) {
        $this->invitation = $invitation;
    }

    public function handle() {
        $isSent = (new EmailService)->sendInvitationAcceptedEmail([
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
