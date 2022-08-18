<?php

namespace App\Providers;

use App\Contracts\EmailContract;
use App\Models\Event;
use App\Models\Service;
use App\Models\Contact;
use App\Models\Venue;
use App\Services\EmailService;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider {

    public function register() {

        Route::bind('venue', function (int $id) {
            return Venue::query()->with(['services', 'merchant'])->findOrFail($id);
        });

        Route::bind('contact', function (int $id) {
            return Contact::query()->findOrFail($id);
        });

        Route::bind('venue_id', function (int $id) {
            return Venue::query()->with(['services', 'merchant'])->findOrFail($id);
        });

        Route::bind('service_id', function (int $id) {
            return Service::query()->findOrFail($id);
        });

        Route::bind('event', function (int $id) {
            return Event::query()->with(['service', 'eventType'])->findOrFail($id);
        });

        Route::bind('event_id', function (int $id) {
            return Event::query()->with(['service', 'eventType'])->findOrFail($id);
        });

        $this->app->bind(EmailContract::class, EmailService::class);
    }

    public function boot() {
        //
    }
}
