<?php

return [
    /*
    |--------------------------------------------------------------------------
    | Admin demo login (Filament sign-in page)
    |--------------------------------------------------------------------------
    | Disable in production unless you intentionally want a one-click fill.
    */
    'enabled' => (bool) env('DEMO_LOGIN_ENABLED', true),

    'email' => env('DEMO_LOGIN_EMAIL', 'admin@example.com'),

    'password' => env('DEMO_LOGIN_PASSWORD', 'password'),
];
