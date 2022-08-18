<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class EventTypesTableSeeder extends Seeder {

    public function run() {
        if (DB::table('event_types')->count() === 0) {
            DB::table('event_types')->insert([
                [
                    'name' => 'Wedding',
                ],
                [
                    'name' => 'Birthday',
                ],
                [
                    'name' => 'Dance',
                ],
                [
                    'name' => 'Vacation',
                ],
                [
                    'name' => 'Events',
                ],
                [
                    'name' => 'Coffee',
                ],
            ]);
        }
    }
}
