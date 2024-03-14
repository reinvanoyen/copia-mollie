<?php

use \ReinVanOyen\CopiaMollie\Http\Controllers\WebhookController;

Route::post(config('copia-mollie.webhook_path'), [WebhookController::class, 'handle']);
