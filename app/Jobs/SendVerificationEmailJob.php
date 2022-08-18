<?php

namespace App\Jobs;

use App\Exceptions\FailedToSendEmailException;
use App\Models\User;
use App\Models\VerificationCode;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;

class SendVerificationEmailJob implements ShouldQueue {
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected string $email;

    public function __construct(string $email) {
        $this->email = $email;
    }

    public function handle() {

        $code = substr(str_shuffle('0123456789'), 0, 5);

        $verificationCode = new VerificationCode();
        $verificationCode->email = $this->email;
        $verificationCode->code = Hash::make($code);

        $verificationCode->saveOrFail();

        /** @var User $user */
        $user = User::query()
            ->where('email', $this->email)
            ->firstOrFail();

        $isSent = (new EmailService())->sendVerificationCode([
            'first_name' => $user->first_name,
            'email' => $user->email,
        ], $user->first_name, $code);

        if (!$isSent) {
            throw new FailedToSendEmailException();
        }
    }
}
