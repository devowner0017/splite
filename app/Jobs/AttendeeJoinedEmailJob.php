<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Http\Models\Event;
use App\Services\EmailService;
use App\Exceptions\FailedToSendEmailException;

class AttendeeJoinedEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected Event $event;
    protected string $first_name;
    protected string $email_address;

    public function __construct(Event $event,string $first_name, string $email_address)
    {
        //
        $this->event = $event;
        $this->$first_name = $first_name;
        $this->$email_address = $email_address;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //
        $isSent = (new EmailService)->sendAttendeeJoinedEmail(
            [
                'first_name' => $this->event->planner->user->first_name,
                'email' => $this->event->planner->user->email,
            ], $this->first_name, $this->email_address
        );
        $isSent &= (new EmailService)->sendAttendeeJoinedEmail(
            [
                'first_name' => $this->event->service->venue->merchant->first_name,
                'email' => $this->event->service->venue->merchant->email
            ], $this->first_name, $this->email_address
        );

        if (!$isSent) {
            throw new FailedToSendEmailException;
        }
    }
}
