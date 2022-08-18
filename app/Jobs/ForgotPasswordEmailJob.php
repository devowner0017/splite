<?php

namespace App\Jobs;

use App\Exceptions\FailedToSendEmailException;
use App\Models\PasswordReset;
use App\Models\User;
use App\Services\EmailService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Bus\Queueable;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;

class ForgotPasswordEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;

    public function __construct(string $email) {
        $this->email = $email;
    }

    public function handle() {

        $code = substr(str_shuffle('0123456789'), 0, 5);

        PasswordReset::query()
            ->where('email', $this->email)
            ->delete();

        $passwordReset = new PasswordReset();
        $passwordReset->email = $this->email;
        $passwordReset->code = Hash::make($code);

        $passwordReset->saveOrFail();

        /** @var User $user */
        $user = User::query()
            ->where('email', $this->email)
            ->firstOrFail();

        $isSent = (new EmailService)->sendForgotPasswordCode([
            'first_name' => $user->first_name,
            'email' => $this->email,
        ], $user->first_name, $code);

        if (!$isSent) {
            throw new FailedToSendEmailException();
        }
    }
}
