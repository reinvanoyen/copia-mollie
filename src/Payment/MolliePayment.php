<?php

namespace ReinVanOyen\CopiaMollie\Payment;

use Mollie\Api\MollieApiClient;
use ReinVanOyen\Copia\Contracts\Orderable;
use ReinVanOyen\Copia\Contracts\Payment;

class MolliePayment implements Payment
{
    /**
     * @var MollieApiClient $mollie
     */
    private MollieApiClient $mollie;

    /**
     * @param MollieApiClient $mollie
     */
    public function __construct(MollieApiClient $mollie)
    {
        $this->mollie = $mollie;
    }

    /**
     * @param Orderable $order
     * @return mixed|void
     */
    public function pay(Orderable $order)
    {
        dd(url('copia-mollie-webhook'));

        // Format total price as a string (needed for Mollie)
        $total = number_format(100, 2, '.', '');

        // Create the Mollie payment
        $payment = $this->mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $total,
            ],
            'description' => $order->order_id,
            'redirectUrl' => url('copia-mollie-redirect'),
            'webhookUrl'  => url('copia-mollie-webhook'),
        ]);

        // Store the Mollie payment id in the order
        $order->payment_id = $payment->id;
        $order->save();

        // Redirect to Mollie
        redirect($payment->getCheckoutUrl());
    }
}
