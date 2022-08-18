<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableChangeProfileImageFieldType extends Migration {

    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->text('profile_image')->nullable()->change();
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->string('profile_image')->nullable()->change();
        });
    }
}
