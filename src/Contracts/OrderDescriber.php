<?php

namespace ReinVanOyen\CopiaMollie\Contracts;

use ReinVanOyen\Copia\Contracts\Orderable;

interface OrderDescriber
{
    /**
     * @param Orderable $orderable
     * @return string
     */
    public function describe(Orderable $orderable): string;
}
