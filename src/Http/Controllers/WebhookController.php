<?php

namespace ReinVanOyen\CopiaMollie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class WebhookController extends Controller
{
    public function handle(Request $request)
    {
        return 'ok';
    }
}
