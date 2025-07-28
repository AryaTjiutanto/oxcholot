<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class SubscriptionController extends Controller
{
    public function checkout(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'price_id' => 'string|min:0|max:100',
            'trial_days' => 'nullable',
        ]);

        $price_id = $request->input('price_id');
        $trial_days = $request->input('trial_days');

        if (!$user->subscribed('default')) {
            $subscription = $user->newSubscription('default', $price_id);

            if (!isNull($trial_days) && $trial_days > 0) {
                $subscription = $subscription->trialDays($trial_days);
            }

            return $subscription->checkout([
                'success_url' => route('dashboard'),
                'cancel_url' => route('subscription.checkout.cancel')
            ]);
        }
    }

    public function cancelCheckout()
    {
        return redirect()->route('homepage');
    }

    public function cancel()
    {
        try {
            $subscription = Auth::user()->subscription('default');

            if ($subscription) {
                $subscription->cancel();
                return redirect()->route('dashboard')->with("success_message", "You've successfully canceled the subscription");
            }

            return redirect()->route('dashboard')->with("error_message", "You have not subscribed to any plan yet.");
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with("error_message", "Something went wrong, please try again later");
        }
    }

    public function resume()
    {
        try {
            $subscription = Auth::user()->subscription('default');

            if (!$subscription) {
                return redirect()->route('dashboard')->with('error_message', "You have not subscribe to any plan yet");
            }

            if ($subscription->onGracePeriod()) {
                $subscription->resume();

                return redirect()->route('dashboard')->with("success_message", "You have successfully continue your subscription");
            }

            return redirect()->route('dashboard')->with("error_message", "Something went wrong, please try again later.");
        } catch (Exception $e) {
            return redirect()->route('dashboard')->with("error_message", "Something went wrong, please try again later");
        }
    }

    public function swap(Request $request)
    {
        $user = Auth::user();
        $price_id = $request->input('price_id');

        try {
            $subscription = $user->subscription('default');

            if ($subscription) {
                $subscription->swap($price_id);

                return redirect()->route('dashboard')->with("success_message", "You have successfully change your plan");
            } else {
                $subscription = $user->newSubscription('default', $price_id);

                return $subscription->checkout([
                    'success_url' => route('dashboard'),
                    'cancel_url' => route('subscription.checkout.cancel')
                ]);
            }
        } catch (Exception $err) {
            return redirect()->route('dashboard')->with("error_message", "Something went wrong, please try again later");
        }
    }
}
