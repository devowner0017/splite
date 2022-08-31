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

class EventInvitationEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected Invitation $invitation;

    public function __construct(Invitation $invitation) {
        $this->invitation = $invitation;
    }

    public function handle() {
        $isSent = (new EmailService)->sendEventInvitation([
            'first_name' => $this->invitation->contact->first_name,
            'email' => $this->invitation->contact->email,
        ], $this->invitation->contact->first_name, env('APP_URL') . "/{$this->invitation->hash}");

        if (!$isSent) {
            throw new FailedToSendEmailException();
        }
    }
}
