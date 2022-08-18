<?php

use App\Models\Gender;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterPlannersTableAddGenderId extends Migration {

    public function up() {
        Schema::table('planners', function (Blueprint $table) {
            $table->foreignIdFor(Gender::class)
                ->after('user_id')
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down() {
        Schema::table('planners', function (Blueprint $table) {
            $table->dropForeign(['gender_id']);
            $table->dropColumn('gender_id');
        });
    }
}
