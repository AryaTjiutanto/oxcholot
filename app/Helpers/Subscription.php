<?php

namespace App\Helpers;

use App\Models\Plan;
use Illuminate\Support\Facades\Cookie;

class Subscription {
    public static function getSubscriptions() {
        $subscriptionCookie = Cookie::get('subscriptions_data');

        if (!$subscriptionCookie) {
            $subscription = Plan::orderBy('price')->get();
            Cookie::queue('subscriptions_data', $subscription->toJson(), 60); // 60 menit
        } else {
            $subscription = collect(json_decode($subscriptionCookie));
        }

        return $subscription;
    }
}