<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ForgotPasswordEmail extends Mailable {
    use Queueable, SerializesModels;

    protected string $code;

    public function __construct(string $code) {
        $this->code = $code;
    }

    public function build() {
        return $this->view('emails.password_reset', ['code' => $this->code]);
    }
}
