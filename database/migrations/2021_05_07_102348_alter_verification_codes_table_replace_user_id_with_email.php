<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterVerificationCodesTableReplaceUserIdWithEmail extends Migration {

    public function up() {
        Schema::table('verification_codes', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
            $table->string('email')->unique()->after('id');
        });
    }

    public function down() {
        Schema::table('verification_codes', function (Blueprint $table) {
            $table->dropColumn('email');
            $table->foreignIdFor(User::class)
                ->nullable()
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }
}
