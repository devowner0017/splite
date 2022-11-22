<?php

namespace App\Jobs;

use App\Exceptions\FailedToSendEmailException;
use App\Models\Event;
use App\Services\EmailService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class CreateEventEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    protected Event $event;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event) {
        $this->event = $event;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle() {
        $isSent = (new EmailService)->sendCreateEventEmail([
            'first_name' => $this->event->service->venue->merchant->user->first_name,
            'email' => $this->event->service->venue->merchant->user->email,
        ], $this->event->planner->user->first_name, $this->event->planner->user->email, $this->event->service->description, $this->event->service->venue->name, $this->event->date, $this->event->start_time);

        if (!$isSent) {
            throw new FailedToSendEmailException();
        }
    }
}
