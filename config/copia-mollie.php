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
    /*
    |--------------------------------------------------------------------------
    | Webhook path
    |--------------------------------------------------------------------------
    |
    | The webhook path Mollie will request when the status of the payment
    | changes
    |
    */
    'webhook_path' => 'copia-mollie-webhook',

    /*
    |--------------------------------------------------------------------------
    | Order describer class
    |--------------------------------------------------------------------------
    |
    | The class responsible for generating the description for an order.
    | This description will be visible on the Mollie dashboard.
    |
    */
    'order_describer' => \ReinVanOyen\CopiaMollie\Order\DefaultOrderDescriber::class,
];
