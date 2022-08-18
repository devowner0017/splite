<?php

echo json_encode([
    [
        'id' => 1,
        'planner_id' => 1,
        'type' => 'Dance',
        'service' => [
            'id' => 1,
            'venue' => [
                'id' => 1,
                'name' => 'Test Plaza',
                'address' => '123 Main St',
                'address_2' => null,
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zipcode' => '91206',
                'phone' => '8182345678',
                'website' => 'https://google.com',
                'logo' => null,
                'background_image' => null,
                'facebook_link' => null,
                'operation_hours' => [
                    [
                        'weekday' => 'Monday',
                        'start_time' => '09:00',
                        'end_time' => '16:00',
                    ],
                    [
                        'weekday' => 'Tuesday',
                        'start_time' => '09:00',
                        'end_time' => '16:00',
                    ],
                    [
                        'weekday' => 'Wednesday',
                        'start_time' => '09:00',
                        'end_time' => '16:00',
                    ],
                    [
                        'weekday' => 'Thursday',
                        'start_time' => '09:00',
                        'end_time' => '16:00',
                    ],
                    [
                        'weekday' => 'Friday',
                        'start_time' => '09:00',
                        'end_time' => '16:00',
                    ],
                ],
            ],
            'type_id' => 1,
            'name' => 'Miami Watersports LCC',
            'description' => 'Courses teach learners how to become efficient project managers using various methodologies principles.',
            'information_content' => null,
            'price' => 15,
            'code' => null,
            'min_participants' => 0,
            'max_participants' => 100,
            'quota' => 100,
            'photo' => null,
            'extra' => 'Beverages included.',
            'street' => null,
            'state' => null,
            'city' => null,
            'zip' => null,
            'phone' => '81834567890',
            'website' => 'https://google.com',
            'launch_date' => '6/1/2021',
        ],
        'date' => [
            'day' => '06/01/2021',
            'start_time' => '12:00',
            'end_time' => '14:00',
        ],
        'invitees' => [
            [
                "id" => 1,
                "planner_id" => 1,
                "first_name" => "Gevorg",
                "last_name" => "Melkumyan",
                "email" => "gevorg.melkumyan@polymorphic.io",
            ],
            [
                "id" => 2,
                "planner_id" => 1,
                "first_name" => "Dmitriy",
                "last_name" => "Rozhnov",
                "email" => "dmitriy.rozhnov@polymorphic.io",
            ],
        ]
    ],
    [
        'id' => 1,
        'planner_id' => 1,
        'type' => 'Wedding',
        'service' => [
            'id' => 2,
            'venue' => [
                'id' => 2,
                'name' => 'Priveé Aussi',
                'address' => '123 Main St',
                'address_2' => null,
                'city' => 'Los Angeles',
                'state' => 'CA',
                'zipcode' => '91206',
                'phone' => '8182345678',
                'website' => 'https://google.com',
                'logo' => null,
                'background_image' => null,
                'facebook_link' => null,
                'operation_hours' => [
                    [
                        'weekday' => 'Monday',
                        'start_time' => '10:30',
                        'end_time' => '17:30',
                    ],
                    [
                        'weekday' => 'Tuesday',
                        'start_time' => '10:30',
                        'end_time' => '17:30',
                    ],
                    [
                        'weekday' => 'Wednesday',
                        'start_time' => '10:30',
                        'end_time' => '17:30',
                    ],
                    [
                        'weekday' => 'Thursday',
                        'start_time' => '10:30',
                        'end_time' => '17:30',
                    ],
                    [
                        'weekday' => 'Friday',
                        'start_time' => '10:30',
                        'end_time' => '12:30',
                    ],
                ],
            ],
            'type_id' => 1,
            'name' => 'BWell Spa',
            'description' => null,
            'information_content' => null,
            'price' => 50,
            'code' => null,
            'min_participants' => 10,
            'max_participants' => 50,
            'quota' => 50,
            'photo' => null,
            'extra' => null,
            'street' => null,
            'state' => null,
            'city' => null,
            'zip' => null,
            'phone' => '81834567890',
            'website' => 'https://google.com',
            'launch_date' => '6/10/2021',
        ],
        'date' => [
            'day' => '09/01/2021',
            'start_time' => '16:00',
            'end_time' => '18:00',
        ],
        'invitees' => [
            [
                "id" => 3,
                "planner_id" => 1,
                "first_name" => "Sargis",
                "last_name" => "Beglaryan",
                "email" => "sargis.beglaryan@polymorphic.io",
            ],
        ]
    ],
]);
