<?php

namespace App\Payments\Contracts;

interface PaymentGatewayInterface
{
    public function process(float $amount): array;
}
