<?php

namespace App\Payments\Gateways;

use App\Payments\Contracts\PaymentGatewayInterface;

class CreditCardGateway implements PaymentGatewayInterface
{
    public function process(float $amount): array
    {
        return [
            'status' => 'successful',
            'reference' => uniqid('cc_'),
        ];
    }
}
