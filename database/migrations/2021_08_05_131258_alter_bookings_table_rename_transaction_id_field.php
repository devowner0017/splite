<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterBookingsTableRenameTransactionIdField extends Migration {

    public function up() {
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('transaction_id', 'charge_id');
        });
    }

    public function down() {
        Schema::table('bookings', function (Blueprint $table) {
            $table->renameColumn('charge_id', 'transaction_id');
        });
    }
}
