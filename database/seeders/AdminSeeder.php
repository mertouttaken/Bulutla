<?php

namespace Database\Seeders;

use App\Models\Plan;
use App\Models\Subscription;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

/**
 * Local admin account.
 * php artisan db:seed --class=AdminSeeder
 *
 * The password comes from ADMIN_SEED_PASSWORD in .env. When it is not set,
 * a random one is generated and printed once, so no password lives in git.
 */
class AdminSeeder extends Seeder
{
    public function run(): void
    {
        $password = env('ADMIN_SEED_PASSWORD');
        if (! $password) {
            $password = Str::password(16, symbols: false);
            $this->command?->warn("ADMIN_SEED_PASSWORD is not set. Generated password: {$password}");
        }

        $admin = User::firstOrNew(['email' => env('ADMIN_SEED_EMAIL', 'yonetici@bulutla.test')]);
        $admin->name = 'Bulutla Yönetici';
        $admin->password = bcrypt($password);
        $admin->is_admin = true;
        $admin->save();

        // Same as registration: every account needs an active subscription,
        // or it has no plan and cannot create projects. The admin gets the
        // unlimited plan when one exists, otherwise the default plan.
        $plan = Plan::where('project_limit', -1)->first()
            ?? Plan::where('is_default', true)->first();

        if ($plan && ! $admin->subscription()->exists()) {
            Subscription::create([
                'user_id' => $admin->id,
                'plan_id' => $plan->id,
                'status' => 'active',
            ]);
        }
    }
}
