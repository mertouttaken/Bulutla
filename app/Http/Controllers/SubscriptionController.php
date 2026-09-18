<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Plan;
use App\Models\Subscription;

class SubscriptionController extends Controller
{
    public function updateSubscription(Request $request, $subscriptionId)
    {
        request()->validate([
            'plan_id' => 'required|exists:plans,id',
            'status'  => 'required|in:active,cancelled',
            'ends_at' => 'nullable|date',
        ]);
        $subscription = Subscription::findOrFail($subscriptionId);

        $subscription->update([
            'plan_id' => $request->input('plan_id'),
            'status'  => $request->input('status'),
            'ends_at' => $request->input('ends_at'),
        ]);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Abonelik başarıyla güncellendi.');
    }

    public function showSubscription($subscriptionId)
    {
        $subscription = Subscription::with('user', 'plan')->findOrFail($subscriptionId);
        $plans = Plan::orderBy('sort_order', 'asc')->get();

        return view('admin.subscriptions.show', compact('subscription', 'plans'));
    }

    public function cancelSubscription($subscriptionId)
    {
        $subscription = Subscription::findOrFail($subscriptionId);
        $subscription->update([
            'status'  => 'cancelled',
            'ends_at' => now(),
        ]);

        return redirect()->back()->with('success', 'Abonelik iptal edildi.');
    }
}