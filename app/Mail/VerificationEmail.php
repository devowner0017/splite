<?php

namespace App\Mail;

use App\Models\User;
use App\Models\VerificationCode;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable {
    use Queueable, SerializesModels;

    protected string $email;

    protected string $code;

    public function __construct(string $email, string $code) {
        $this->email = $email;
        $this->code = $code;
    }

    public function build() {
        return $this->view('emails.verification', [
            'code' => $this->code,
        ])
            ->from(env('MAIL_FROM_ADDRESS'), $this->email);
    }
}
