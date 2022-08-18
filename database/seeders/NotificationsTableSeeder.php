<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class NotificationsTableSeeder extends Seeder {

    public function run() {
        if (DB::table('notifications')->count() === 0) {
            DB::table('notifications')->insert([
                [
                    'name' => 'email',
                ],
                [
                    'name' => 'phone',
                ],
            ]);
        }
    }
}
