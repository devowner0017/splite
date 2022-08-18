<?php

return [
    'key' => env('MANDRILL_API_KEY'),
    'forgot' => env('MANDRILL_FORGOT_PASSWORD_TEMPLATE'),
    'register' => env('MANDRILL_REGISTER_TEMPLATE'),
    'verification' => env('MANDRILL_VERIFICATION_TEMPLATE'),
    'event_invitation' => env('MANDRILL_EVENT_INVITATION_TEMPLATE'),
    'invitation_accepted' => env('MANDRILL_INVITATION_ACCEPTED_TEMPLATE'),
    'invitation_declined' => env('MANDRILL_INVITATION_DECLINED_TEMPLATE'),
    'payment_completed_contact' => env('MANDRILL_PAYMENT_COMPLETED_CONTACT_EMAIL'),
    'payment_completed_merchant' => env('MANDRILL_PAYMENT_COMPLETED_MERCHANT_EMAIL'),
    'payment_completed_planner' => env('MANDRILL_PAYMENT_COMPLETED_PLANNER_EMAIL'),
];
