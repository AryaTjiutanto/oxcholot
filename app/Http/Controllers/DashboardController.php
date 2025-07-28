<?php

namespace App\Http\Controllers;

use App\Helpers\Subscription;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index() {
        $subscriptions = null;
        $subscription = null;
        $stripe_subscription = null;
        $price_id = null;

        if(Auth::user()->subscribed('default')) {
            $subscription = Auth::user()->subscription('default');
            $stripe_subscription = $subscription->asStripeSubscription();

            $subscriptions = Subscription::getSubscriptions();
            $price_id = $subscription->stripe_price;
    
            $active_subscription = $subscriptions->firstWhere('price_id', $price_id);
        }

        return view('dashboard', compact(['subscriptions', 'subscription', 'active_subscription', 'stripe_subscription']));
    }
}
