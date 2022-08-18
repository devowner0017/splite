<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class GendersTableSeeder extends Seeder {

    public function run() {
        if (DB::table('genders')->count() === 0) {
            DB::table('genders')->insert([
                [
                    'name' => 'Male',
                ],
                [
                    'name' => 'Female',
                ],
                [
                    'name' => 'Other',
                ],
            ]);
        }
    }
}
