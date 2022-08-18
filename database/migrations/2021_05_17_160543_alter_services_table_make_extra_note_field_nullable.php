<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterServicesTableMakeExtraNoteFieldNullable extends Migration {

    public function up() {
        Schema::table('services', function (Blueprint $table) {
            $table->string('extra_note')->nullable()->change();
        });
    }
}
