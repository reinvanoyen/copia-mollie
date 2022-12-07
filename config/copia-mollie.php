<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Mollie API key
    |--------------------------------------------------------------------------
    |
    | The Mollie API key that let's us communicate with the Mollie service.
    | This can be found in your Mollie dashboard.
    |
    */

    'mollie_api_key' => env('MOLLIE_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | Redirect path
    |--------------------------------------------------------------------------
    |
    | The redirect path where we'll redirect the use after making a payment.
    | In the get request params we'll automatically provide the order id
    |
    */

    'redirect_path' => 'redirect',
];
