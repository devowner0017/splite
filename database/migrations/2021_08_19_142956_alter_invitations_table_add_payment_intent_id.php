<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvitationsTableAddPaymentIntentId extends Migration {

    public function up() {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('payment_intent_id')->nullable()->after('hash');
        });
    }

    public function down() {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('payment_intent_id');
        });
    }
}
