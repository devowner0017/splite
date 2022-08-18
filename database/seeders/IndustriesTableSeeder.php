<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class IndustriesTableSeeder extends Seeder {

    public function run() {
        if (DB::table('industries')->count() === 0) {
            DB::table('industries')->insert([
                [
                    'name' => 'Bars & Restaurants',
                ],
                [
                    'name' => 'Casinos/ Gambling',
                ],
                [
                    'name' => 'Chiropractors',
                ],
                [
                    'name' => 'Clergy & Religious Organizations',
                ],
                [
                    'name' => 'Colleges, Universities & Schools',
                ],
                [
                    'name' => 'Cruise Lines',
                ],
                [
                    'name' => 'Education',
                ],
                [
                    'name' => 'Entertainment Industry',
                ],
                [
                    'name' => 'Food & Beverage',
                ],
                [
                    'name' => 'Foundations, Philanthropies & Non-Profit',
                ],
                [
                    'name' => 'Funeral Services',
                ],
                [
                    'name' => 'Gambling & Casinos',
                ],
                [
                    'name' => 'Hotels, Motels, & Tourism',
                ],
                [
                    'name' => 'Indian Gaming',
                ],
                [
                    'name' => 'Lodging / Tourism',
                ],
                [
                    'name' => 'Misc Business',
                ],
                [
                    'name' => 'Miscellaneous Services',
                ],
                [
                    'name' => 'Music Production',
                ],
                [
                    'name' => 'Real Estate',
                ],
                [
                    'name' => 'Restaurants & Drinking Establishments',
                ],
                [
                    'name' => 'Sports',
                ],
                [
                    'name' => 'Vineyards & Winery',
                ],
                [
                    'name' => 'Other',
                ],
            ]);
        }
    }
}


