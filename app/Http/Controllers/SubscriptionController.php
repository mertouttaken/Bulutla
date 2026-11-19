<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    public function cancel(Request $request)
    {
        $subscription = $request->user()->subscription;
        if ($subscription) {
            $subscription->update([
                'status'  => 'cancelled',
                'ends_at' => now(),
            ]);
        }

        return back()->with('success', 'Aboneliğiniz iptal edildi.');
    }

    public function changeUserPlan(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:plans,id',
        ]);

        $request->user()->subscriptions()->updateOrCreate(
            ['user_id' => $request->user()->id],
            [
                'plan_id' => $request->plan_id,
                'status'  => 'active',
                'ends_at' => now()->addMonth(),
            ]
        );
        $request->user()->bills()->create([
            'user_id' => $request->user()->id,
            'plan_id' => $request->plan_id,
            'amount' => $request->plan()->price,
            'status' => 'paid',
            'payment_method' => null,
            'transaction_id' => null,
        ]);

        return back()->with('success', 'Planınız başarıyla güncellendi.');
    }
    public function getBills(Request $request)
    {
        $bills = $request->user()->bills()->with('plan')->get();
        return response()->json($bills);
    }
}