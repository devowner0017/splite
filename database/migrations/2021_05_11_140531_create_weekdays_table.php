<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeekdaysTable extends Migration {

    public function up() {
        Schema::create('weekdays', function (Blueprint $table) {
            $table->id();
            $table->string('name');
        });
    }

    public function down() {
        Schema::dropIfExists('weekdays');
    }
}
