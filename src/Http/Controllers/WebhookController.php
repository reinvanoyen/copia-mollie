<?php

namespace ReinVanOyen\CopiaMollie\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Mollie\Api\MollieApiClient;
use ReinVanOyen\Copia\Models\Order;
use ReinVanOyen\Copia\Payment\PaymentStatus;

class WebhookController extends Controller
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
     * @param Request $request
     * @return string
     */
    public function handle(Request $request)
    {
        $payment = $this->mollie->payments->get($request->get('id'));
        $paymentId = $payment->id;

        $order = Order::where('payment_id', $paymentId)->firstOrFail();

        if ($payment->isPaid()) {
            if ($payment->hasRefunds()) {
                $order->setPaymentStatus(PaymentStatus::REFUNDED);
            } else {
                $order->setPaymentStatus(PaymentStatus::PAID);
            }
        } elseif (! $payment->isOpen()) {
            if ($payment->isExpired()) {
                $order->setPaymentStatus(PaymentStatus::EXPIRED);
            } elseif ($payment->isCanceled()) {
                $order->setPaymentStatus(PaymentStatus::CANCELLED);
            }
        } else {
            // Not sure what happened, but it failed
            $order->setPaymentStatus(PaymentStatus::FAILED);
        }

        return 'ok';
    }
}
