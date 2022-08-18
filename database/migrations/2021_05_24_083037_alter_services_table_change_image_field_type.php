<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServicesTableChangeImageFieldType extends Migration {

    public function up() {
        Schema::table('services', function (Blueprint $table) {
            $table->text('image_url')->nullable()->change();
        });
    }

    public function down() {
        Schema::table('services', function (Blueprint $table) {
            $table->string('image_url')->nullable()->change();
        });
    }
}
