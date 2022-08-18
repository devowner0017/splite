<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingsTableRemoveChargeIdField extends Migration {

    public function up() {
        Schema::table('bookings', function (Blueprint $table) {
            $table->dropColumn('charge_id');
            $table->float('fee')->nullable()->after('amount');
        });
    }

    public function down() {
        Schema::table('bookings', function (Blueprint $table) {
            $table->string('charge_id')->nullable()->after('event_id');
            $table->dropColumn('fee');
        });
    }
}
