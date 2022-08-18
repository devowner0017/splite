<?php

namespace App\Jobs;

use App\Exceptions\FailedToSendEmailException;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class RegisterEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected User $user;

    public function __construct(User $user) {
        $this->user = $user;
    }

    public function handle() {
        $isSent = (new EmailService)->sendRegisterEmail([
            'first_name' => $this->user->first_name,
            'email' => $this->user->email,
        ], $this->user->first_name);

        if (!$isSent) {
            throw new FailedToSendEmailException();
        }
    }
}
