<?php

namespace App\Services;

use Srmklive\PayPal\Services\PayPal;

class PaypalService {
    public $provider;

    public function __construct() {
        $this->provider = new PayPal;
        $this->provider->setApiCredentials(config('paypal'));
        $token = $this->provider->getAccessToken();
        $this->provider->setAccessToken($token);
    }

    public function createOrder(float $price) {
        $order = $this->provider->createOrder([
            "intent" => "CAPTURE",
            "application_context" => [
                "return_url" => route('paypal.success'),
                "cancel_url" => route('paypal.cancel'),
            ],
            "purchase_units" => [
                [
                    "amount" => [
                        "currency_code" => "USD",
                        "value" => $price,
                    ]
                ]
            ]
        ]);

        foreach ($order['links'] as $link) {
            if ($link['rel'] === 'approve') {
                return $link['href'];
            }
        }

        return null;
    }

    public function captureOrder(String $token) {
        $response = $this->provider->capturePaymentOrder($token);
        return $response;
    }
}