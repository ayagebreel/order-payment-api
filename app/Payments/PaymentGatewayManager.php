<?php

namespace App\Payments;

use App\Payments\Gateways\CreditCardGateway;
use App\Payments\Gateways\PaypalGateway;
use App\Payments\Contracts\PaymentGatewayInterface;

class PaymentGatewayManager
{
    public function resolve(string $method): PaymentGatewayInterface
    {
        return match ($method) {
            'credit_card' => new CreditCardGateway(),
            'paypal' => new PaypalGateway(),
            default => throw new \Exception('Unsupported payment method'),
        };
    }
}
