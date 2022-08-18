<?php

namespace App\Mail;

use App\Models\Invitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PaymentCompletedMerchantEmail extends Mailable {
    use Queueable, SerializesModels;

    protected Invitation $invitation;

    public function __construct(Invitation $invitation) {
        $this->invitation = $invitation;
    }

    public function build() {
        return $this->view('emails.payment_completed_merchant', [
            'invitation' => $this->invitation,
        ]);
    }
}
