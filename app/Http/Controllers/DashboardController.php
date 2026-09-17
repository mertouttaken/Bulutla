<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;

class DashboardController extends Controller
{
    public function index()
    {
        $mostPopularPlan = $this->getMostPopularPlan();
        $plans = Plan::orderBy('sort_order', 'asc')->get();
        return view('home', compact('mostPopularPlan', 'plans'));
    }
    public function getMostPopularPlan()
    {
        return Plan::withCount('subscriptions')
            ->orderByDesc('subscriptions_count')
            ->first();
    }
}
