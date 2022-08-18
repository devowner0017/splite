<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterEventsTableAddStatusField extends Migration {

    public function up() {
        Schema::table('events', function (Blueprint $table) {
            $table->string('status')->default('new')->after('event_type_id');
        });
    }

    public function down() {
        Schema::table('events', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}
