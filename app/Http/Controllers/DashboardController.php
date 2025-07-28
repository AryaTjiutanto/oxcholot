<?php

namespace App\Http\Controllers;

use App\Helpers\Subscription;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index() {
        $subscriptions = Subscription::getSubscriptions();
        return view('dashboard', compact(['subscriptions']));
    }
}
