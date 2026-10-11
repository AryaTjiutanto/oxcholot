<?php

namespace App\Http\Controllers;

use App\Http\Requests\SubscriptionRequest;
use App\Models\Product;
use App\Services\StripeService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use function PHPUnit\Framework\isNull;

class SubscriptionController extends Controller
{
    protected StripeService $stripeService;

    public function __construct(StripeService $stripeService)
    {
        $this->stripeService = $stripeService;
    }

    public function checkout(SubscriptionRequest $request)
    {
        $price_id = $request->validated()['price_id'];
        $trial_days = $request->validated()['trial_days'];

        $subscription = $this->stripeService->createSubscription($price_id, $trial_days);

        return $subscription->checkout([
            'success_url' => route('dashboard'),
            'cancel_url' => route('subscription.checkout.cancel')
        ]);
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

    public function show(Product $product)
    {
        return view('product.show', compact(['product']));
    }
}
