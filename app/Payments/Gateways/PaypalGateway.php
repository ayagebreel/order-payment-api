<?php

namespace App\Payments\Gateways;

use App\Payments\Contracts\PaymentGatewayInterface;

class PaypalGateway implements PaymentGatewayInterface
{
    public function process(float $amount): array
    {
        return [
            'status' => 'successful',
            'reference' => uniqid('pp_'),
        ];
    }
}
+
