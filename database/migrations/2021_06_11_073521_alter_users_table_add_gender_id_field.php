<?php

use App\Models\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterUsersTableAddGenderIdField extends Migration {

    public function up() {
        Schema::table('users', function (Blueprint $table) {
            $table->foreignIdFor(Gender::class)
                ->nullable()
                ->after('id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('zipcode')->nullable()->after('password');
            $table->string('city')->nullable()->after('password');
            $table->date('birth_date')->nullable()->after('password');
        });
    }

    public function down() {
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
            $table->dropColumn([
                'gender_id',
                'birth_date',
                'city',
                'zipcode',
            ]);
        });
    }
}
