<?php

namespace Tests\Feature;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Http\Controllers\SubscriptionController;

class ChangePlanTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_change_subscription_plan(): void
    {
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password123'),
        ]);

        $freePlan = Plan::create([
            'name' => 'Free',
            'slug' => 'free',
            'description' => 'Free plan',
            'price' => 0,
            'storage_limit' => '100 MB',
            'project_limit' => 1,
            'features' => json_encode(['1 proje', '100 MB depolama']),
        ]);

        $proPlan = Plan::create([
            'name' => 'Pro',
            'slug' => 'pro',
            'description' => 'Pro plan',
            'price' => 199.00,
            'storage_limit' => '10 GB',
            'project_limit' => 10,
            'features' => json_encode(['10 proje', '10 GB depolama']),
        ]);

        Subscription::create([
            'user_id' => $user->id,
            'plan_id' => $freePlan->id,
            'status' => 'active',
            'ends_at' => null,
        ]);

        $response = $this->actingAs($user)->post('/change-plan', [
            'plan' => 'pro',
            'ends_at' => 'null',
        ]);

        $response->assertSessionHasNoErrors();
        $response->assertRedirect();

        $this->assertDatabaseHas('subscriptions', [
            'user_id' => $user->id,
            'plan_id' => $proPlan->id,
            'status' => 'active',
        ]);
    }
}