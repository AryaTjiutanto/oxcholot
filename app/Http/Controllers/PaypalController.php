<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Services\PaypalService;
use Illuminate\Http\Request;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class PaypalController extends Controller
{
    protected PaypalService $paypalService;

    public function __construct(PaypalService $paypalService) {
        $this->paypalService = $paypalService;
    }

    public function handlePayment(ProductRequest $request)
    {
        $price = (float) $request->validated()['price'];
        $redirect_url = $this->paypalService->createOrder($price);

        return $redirect_url ? redirect($redirect_url) : redirect()->back()->with('error', 'Something went wrong');
    }

    public function success(Request $request)
    {
        $response = $this->paypalService->captureOrder($request->input('token'));

        if ($response['status'] === "COMPLETED") {
            return "Payment completed successfully.";
        }

        return "Payment not completed.";
    }

    public function cancel()
    {
        return "Payment was cancelled.";
    }
}
