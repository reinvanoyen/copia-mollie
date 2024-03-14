<?php

namespace ReinVanOyen\CopiaMollie;

use Illuminate\Support\ServiceProvider;
use Mollie\Api\MollieApiClient;
use ReinVanOyen\CopiaMollie\Contracts\OrderDescriber;
use ReinVanOyen\CopiaMollie\Payment\MolliePayment;

class CopiaMollieServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrderDescriber::class, config('copia-mollie.order_describer'));

        $this->app->bind(MollieApiClient::class, function () {
            $mollie = new MollieApiClient();
            $mollie->setApiKey(config('copia-mollie.mollie_api_key'));
            return $mollie;
        });

        $this->app->when(MolliePayment::class)
            ->needs('$webhookPath')
            ->give(config('copia-mollie.webhook_path'));
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
