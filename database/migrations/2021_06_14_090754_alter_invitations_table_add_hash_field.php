<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvitationsTableAddHashField extends Migration {

    public function up() {
        Schema::table('invitations', function (Blueprint $table) {
            $table->string('hash')->unique()->after('contact_id');
        });
    }

    public function down() {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('hash');
        });
    }
}
