<?php

namespace ReinVanOyen\CopiaMollie;

use Illuminate\Support\ServiceProvider;
use Mollie\Api\MollieApiClient;

class CopiaMollieServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(MollieApiClient::class, function () {
            $mollie = new MollieApiClient();
            $mollie->setApiKey(config('copia-mollie.mollie_api_key'));
            return $mollie;
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/copia-mollie.php', 'copia-mollie');
        $this->loadRoutesFrom(__DIR__.'/../routes/webhooks.php');

        if ($this->app->runningInConsole()) {
            $this->registerPublishes();
        }
    }

    /**
     * @return void
     */
    private function registerPublishes()
    {
        $this->publishes([
            __DIR__.'/../config/copia-mollie.php' => config_path('copia-mollie.php'),
        ], 'copia-mollie-config');
    }
}
