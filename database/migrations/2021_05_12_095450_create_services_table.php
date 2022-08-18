<?php

use App\Models\Venue;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateServicesTable extends Migration {

    public function up() {
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Venue::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->text('description')->nullable();
            $table->text('information_content')->nullable();
            $table->string('type');
            $table->float('price');
            $table->string('code');
            $table->unsignedInteger('min_participants')->nullable();
            $table->unsignedInteger('max_participants')->nullable();
            $table->unsignedInteger('quota')->nullable();
            $table->string('extra_note');
            $table->string('address_2')->nullable();
            $table->string('address_1')->nullable();
            $table->string('zipcode')->nullable();
            $table->string('city')->nullable();
            $table->string('state_abbreviation')->nullable();
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('image_url')->nullable();
            $table->date('launch_date');

            $table->timestamps();

            $table->foreign('state_abbreviation')
                ->references('abbreviation')
                ->on('states')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down() {
        Schema::dropIfExists('services');
    }
}
