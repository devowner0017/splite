<?php

namespace App\Mail;

use App\Models\Contact;
use App\Models\Event;
use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class EventInvitationEmail extends Mailable {
    use Queueable, SerializesModels;

    protected Invitation $invitation;

    public function __construct(Invitation $invitation) {
        $this->invitation = $invitation;
    }

    public function build() {
        return $this->view('emails.invitation', [
            'invitation' => $this->invitation,
            'contact' => $this->invitation->contact,
        ]);
    }
}
