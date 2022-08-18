<?php

echo json_encode([
    'data' => [
        'venues' => [
            [
                'id' => 1,
                'merchant_id' => 1,
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
            [
                'id' => 2,
                'merchant_id' => 1,
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
        ]
    ],
]);
