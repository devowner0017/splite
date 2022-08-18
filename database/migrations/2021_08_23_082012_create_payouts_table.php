<?php

use App\Models\Booking;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePayoutsTable extends Migration {

    public function up() {
        Schema::create('payouts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Booking::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('payout_id');
            $table->string('stripe_account');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('payouts');
    }
}
