<?php

use \ReinVanOyen\CopiaMollie\Http\Controllers\WebhookController;

Route::post('copia-mollie-webhook/', [WebhookController::class, 'handle']);
