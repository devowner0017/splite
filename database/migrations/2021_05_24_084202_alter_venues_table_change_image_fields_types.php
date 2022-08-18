<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVenuesTableChangeImageFieldsTypes extends Migration {

    public function up() {
        Schema::table('venues', function (Blueprint $table) {
            $table->text('logo')->nullable()->change();
            $table->text('background_image')->nullable()->change();
        });
    }

    public function down() {
        Schema::table('venues', function (Blueprint $table) {
            $table->string('logo')->nullable()->change();
            $table->string('background_image')->nullable()->change();
        });
    }
}
