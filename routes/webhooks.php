<?php

use \ReinVanOyen\CopiaMollie\Http\Controllers\WebhookController;

Route::get('copia-mollie-webhook/', [WebhookController::class, 'handle']);
