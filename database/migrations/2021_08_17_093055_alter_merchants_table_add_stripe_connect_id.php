<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMerchantsTableAddStripeConnectId extends Migration {

    public function up() {
        Schema::table('merchants', function (Blueprint $table) {
            $table->string('stripe_connect_id')->nullable()->after('user_id');
        });
    }

    public function down() {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropColumn('stripe_connect_id');
        });
    }
}
