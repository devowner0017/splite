<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddPrivacyPolicyField extends Migration {

    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->text('privacy_policy')->nullable()->after('password');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('privacy_policy');
        });
    }
}
