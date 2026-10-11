<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class StripeService {
    public $user;

    public function __construct() {
        $this->user = Auth::user();
    }

    public function createSubscription(string $price_id, $trial_days) {
        if (!$this->user->subscribed('default')) {
            $subscription = $this->user->newSubscription('default', $price_id);

            if (!isNull($trial_days) && $trial_days > 0) {
                $subscription = $subscription->trialDays($trial_days);
            }

            return $subscription;
        }

        return null;
    }
}