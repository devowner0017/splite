<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolesTableSeeder extends Seeder {

    public function run() {
        if (DB::table('roles')->count() === 0) {
            DB::table('roles')->insert([
                [
                    'name' => 'Admin',
                ],
                [
                    'name' => 'Merchant',
                ],
                [
                    'name' => 'Planner',
                ],
            ]);
        }
    }
}
