<?php

namespace ReinVanOyen\CopiaMollie\Payment;

use Mollie\Api\MollieApiClient;
use ReinVanOyen\Copia\Contracts\Orderable;
use ReinVanOyen\Copia\Contracts\Payment;
use ReinVanOyen\Copia\Payment\PaymentStatus;
use ReinVanOyen\CopiaMollie\Contracts\OrderDescriber;

class MolliePayment implements Payment
{
    /**
     * @var MollieApiClient $mollie
     */
    private MollieApiClient $mollie;

    /**
     * @var OrderDescriber $orderDescriber
     */
    private OrderDescriber $orderDescriber;

    /**
     * @var string $webhookPath
     */
    private string $webhookPath;

    /**
     * @param MollieApiClient $mollie
     * @param OrderDescriber $orderDescriber
     * @param string $webhookPath
     */
    public function __construct(MollieApiClient $mollie, OrderDescriber $orderDescriber, string $webhookPath)
    {
        $this->mollie = $mollie;
        $this->orderDescriber = $orderDescriber;
        $this->webhookPath = $webhookPath;
    }

    /**
     * @param Orderable $order
     * @return mixed|string|null
     * @throws \Mollie\Api\Exceptions\ApiException
     */
    public function pay(Orderable $order)
    {
        $total = $order->getTotal();
        // Format total price as a string (needed for Mollie)
        $formattedTotal = number_format($total, 2, '.', '');

        if (! $total > 0) {
            $order->setPaymentStatus(PaymentStatus::PAID);
            return null;
        }

        // Create the Mollie payment
        $payment = $this->mollie->payments->create([
            'amount' => [
                'currency' => 'EUR',
                'value' => $formattedTotal,
            ],
            'description' => $this->orderDescriber->describe($order),
            'redirectUrl' => url(config('copia-mollie.redirect_path').'?order='.$order->getOrderId()),
            'webhookUrl'  => url($this->webhookPath),
        ]);

        // Store the Mollie payment id in the order
        $order->setPaymentId($payment->id);

        // Redirect to Mollie
        return $payment->getCheckoutUrl();
    }
}
