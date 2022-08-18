<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePaymentMethodsTable extends Migration {

    public function up() {
        Schema::create('payment_methods', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(User::class)
                ->constrained()
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->string('stripe_id');
            $table->string('type');
            $table->boolean('primary')->default(false);

            $table->timestamps();
        });
    }

    public function down() {
        Schema::dropIfExists('payment_methods');
    }
}
