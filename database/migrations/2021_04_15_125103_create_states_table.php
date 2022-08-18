<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateStatesTable extends Migration {

    public function up() {
        Schema::create('states', function (Blueprint $table) {
            $table->string('abbreviation')->primary();
            $table->string('name');
        });
    }

    public function down() {
        Schema::dropIfExists('states');
    }
}
