<?php

namespace ReinVanOyen\CopiaMollie\Order;

use ReinVanOyen\Copia\Contracts\Orderable;
use ReinVanOyen\CopiaMollie\Contracts\OrderDescriber;

class DefaultOrderDescriber implements OrderDescriber
{
    /**
     * @param Orderable $orderable
     * @return string
     */
    public function describe(Orderable $orderable): string
    {
        return $orderable->getOrderId();
    }
}
