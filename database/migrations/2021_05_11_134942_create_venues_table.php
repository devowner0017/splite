<?php

use App\Models\Merchant;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVenuesTable extends Migration {

    public function up() {
        Schema::create('venues', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Merchant::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('name');
            $table->string('address_2')->nullable();
            $table->string('address_1');
            $table->string('zipcode');
            $table->string('city');
            $table->string('state_abbreviation');
            $table->string('website')->nullable();
            $table->string('phone');
            $table->string('logo')->nullable();
            $table->string('background_image')->nullable();
            $table->string('facebook_link')->nullable();

            $table->foreign('state_abbreviation')
                ->references('abbreviation')
                ->on('states')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('venues');
    }
}
