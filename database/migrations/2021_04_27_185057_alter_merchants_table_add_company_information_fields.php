<?php

use App\Models\Industry;
use App\Models\State;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlterMerchantsTableAddCompanyInformationFields extends Migration {

    public function up() {
        Schema::table('merchants', function (Blueprint $table) {
            $table->string('company_address_2')->nullable()->after('user_id');
            $table->string('company_address_1')->nullable()->after('user_id');
            $table->string('company_zipcode')->nullable()->after('user_id');
            $table->string('company_city')->nullable()->after('user_id');
            $table->string('company_website')->nullable()->after('user_id');
            $table->string('company_name')->nullable()->after('user_id');
            $table->string('company_state_abbreviation')->nullable()->after('user_id');


            $table->foreign('company_state_abbreviation')
                ->references('abbreviation')
                ->on('states')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            $table->foreignIdFor(Industry::class, 'company_industry_id')
                ->nullable()
                ->after('user_id')
                ->constrained('industries')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
        });
    }

    public function down() {
        Schema::table('merchants', function (Blueprint $table) {
            $table->dropForeign('merchants_company_state_abbreviation_foreign');
            $table->dropForeign('merchants_company_industry_id_foreign');
            $table->dropColumn([
                'company_industry_id',
                'company_name',
                'company_website',
                'company_address_1',
                'company_address_2',
                'company_city',
                'company_zipcode',
                'company_state_abbreviation',
            ]);
        });
    }
}
