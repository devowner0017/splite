<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder {

    public function run() {
        $this->call([
            RolesTableSeeder::class,
            IndustriesTableSeeder::class,
            StatesTableSeeder::class,
            NotificationsTableSeeder::class,
            GendersTableSeeder::class,
            WeekdaysTableSeeder::class,
            EventTypesTableSeeder::class,
        ]);
    }
}
