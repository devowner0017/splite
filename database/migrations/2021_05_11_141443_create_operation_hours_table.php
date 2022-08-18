<?php

use App\Models\Venue;
use App\Models\Weekday;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateOperationHoursTable extends Migration {

    public function up() {
        Schema::create('operation_hours', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Venue::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignIdFor(Weekday::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->time('start_time');
            $table->time('end_time');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('operation_hours');
    }
}
