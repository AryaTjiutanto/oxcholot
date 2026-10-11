<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PaypalWebhookController extends Controller
{
    public function handleWebhook(Request $request) {
        Log::info("Paypal webhook :", $request->all());
        if($request->event_type === "CHECKOUT.ORDER.APPROVED") {
            $orderId = $request->resource['id'];

            Log::info("order id : ", $orderId);
        }

        return response()->json(['status', 'received']);
    }
}
