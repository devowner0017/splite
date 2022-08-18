<?php

use App\Models\Planner;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContactsTable extends Migration {

    public function up() {
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Planner::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('contacts');
    }
}
