<?php

namespace ReinVanOyen\CopiaMollie\Payment;

use Mollie\Api\MollieApiClient;
use ReinVanOyen\Copia\Contracts\Orderable;
use ReinVanOyen\Copia\Contracts\Payment;
use ReinVanOyen\Copia\Payment\PaymentStatus;

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
     * @return mixed|string|void|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function pay(Orderable $order)
    {
        // Format total price as a string (needed for Mollie)
        $total = number_format($order->getTotal(), 2, '.', '');

        if (! $total > 0) {
            $order->setPaymentStatus(PaymentStatus::PAID);
            return;
        }

        // Create the Mollie payment
        $payment = $this->mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $total,
            ],
            'description' => $order->getOrderId(),
            'redirectUrl' => url(config('copia-mollie.redirect_path').'?order='.$order->getOrderId()),
            'webhookUrl'  => url('copia-mollie-webhook'),
        ]);

        // Store the Mollie payment id in the order
        $order->setPaymentId($payment->id);

        // Redirect to Mollie
        return $payment->getCheckoutUrl();
    }
}
