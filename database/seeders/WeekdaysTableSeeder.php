<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class WeekdaysTableSeeder extends Seeder {

    public function run() {
        if (DB::table('weekdays')->count() === 0) {
            DB::table('weekdays')->insert([
                [
                    'name' => 'Sunday',
                ],
                [
                    'name' => 'Monday',
                ],
                [
                    'name' => 'Tuesday',
                ],
                [
                    'name' => 'Wednesday',
                ],
                [
                    'name' => 'Thursday',
                ],
                [
                    'name' => 'Friday',
                ],
                [
                    'name' => 'Saturday',
                ],
            ]);
        }
    }
}
