<?php

namespace Database\Seeders;

use App\Models\Bill;
use App\Models\Plan;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class BillSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::with(['subscription.plan', 'plan'])->get();
        $plans = Plan::all();

        if ($users->isEmpty() || $plans->isEmpty()) {
            return;
        }

        $paidPlans = $plans->where('price', '>', 0);
        $paymentMethods = ['credit_card', 'iyzico', 'bank_transfer'];

        foreach ($users as $user) {
            $userPlan = $user->subscription?->plan ?? $user->plan;

            if (!$userPlan || (float) $userPlan->price <= 0) {
                $userPlan = $paidPlans->isNotEmpty() ? $paidPlans->random() : $plans->random();
            }

            $amount = (float) $userPlan->price > 0 ? $userPlan->price : 99.90;
            $paymentMethod = $paymentMethods[array_rand($paymentMethods)];

            for ($i = 2; $i >= 0; $i--) {
                $billingDate = now()->subMonths($i)->subDays(rand(0, 5));

                Bill::create([
                    'user_id' => $user->id,
                    'plan_id' => $userPlan->id,
                    'amount' => $amount,
                    'status' => 'paid',
                    'payment_method' => $paymentMethod,
                    'transaction_id' => 'TXN-' . strtoupper(Str::random(12)),
                    'paid_at' => $billingDate->copy()->addMinutes(rand(1, 10)),
                    'created_at' => $billingDate,
                    'updated_at' => $billingDate,
                ]);
            }
        }
    }
}