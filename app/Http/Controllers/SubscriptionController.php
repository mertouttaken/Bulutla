<?php

namespace App\Http\Controllers;

use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

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
            'plan_id' => 'required|integer|exists:plans,id',
        ]);

        $plan = Plan::findOrFail($request->integer('plan_id'));

        // There is no payment provider yet, so a user may only switch
        // themselves to a free plan. Paid plans are assigned by an admin
        // (or by a payment flow once one exists), never by this request.
        if ((float) $plan->price > 0) {
            return back()->with('error', 'Ücretli planlara geçiş için ödeme gerekiyor. Ödeme altyapısı hazır olana kadar yöneticiyle iletişime geçin.');
        }

        $user = $request->user();

        DB::transaction(function () use ($user, $plan) {
            $user->subscriptions()->updateOrCreate(
                ['user_id' => $user->id],
                [
                    'plan_id' => $plan->id,
                    'status'  => 'active',
                    'ends_at' => null,
                ]
            );
        });

        return back()->with('success', "Planınız {$plan->name} olarak güncellendi.");
    }
    public function getBills(Request $request)
    {
        $bills = $request->user()->bills()->with('plan')->get();
        return response()->json($bills);
    }
}