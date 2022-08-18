<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterInvitationsTableAddNoteField extends Migration {

    public function up() {
        Schema::table('invitations', function (Blueprint $table) {
            $table->text('note')->nullable()->after('status');
        });
    }

    public function down() {
        Schema::table('invitations', function (Blueprint $table) {
            $table->dropColumn('note');
        });
    }
}
