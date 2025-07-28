<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class SubscriptionController extends Controller
{
    public function checkout(Request $request) {
        $user = Auth::user();

        $request->validate([
            'price_id' => 'string|min:0|max:100',
            'trial_days' => 'nullable',
        ]);

        $price_id = $request->input('price_id');
        $trial_days = $request->input('trial_days');

        if(!$user->subscribed('default')) {
            $subscription = $user->newSubscription('default', $price_id);
            
            if(!isNull($trial_days) && $trial_days > 0) {
                $subscription = $subscription->trialDays($trial_days);
            }
            
            return $subscription->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('subscription.checkout.cancel')
            ]);
        }
    }

    public function cancelCheckout() {

    }
}
