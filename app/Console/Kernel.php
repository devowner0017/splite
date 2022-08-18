<?php

namespace App\Console;

use App\Console\Commands\SendPayouts;
use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel {

    protected $commands = [
        SendPayouts::class,
    ];

    protected function schedule(Schedule $schedule) {
        $now = now();
        $logFileName = 'send-payouts-' . $now->year . '-' . $now->month . '-' . $now->day . '-' . $now->timestamp . '.log';
        $schedule
            ->command('send:payouts')
            ->daily()
            ->sendOutputTo(env('COMMAND_LOG_DIRECTORY') . $logFileName);
    }

    protected function commands() {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }
}
