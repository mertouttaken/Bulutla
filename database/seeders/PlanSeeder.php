<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Plan;

class PlanSeeder extends Seeder
{
    public function run(): void
    {
        Plan::firstOrCreate(
            ['slug' => 'free'],
            [
                'name' => 'Free',
                'description' => 'Free plan',
                'price' => 0,
                'storage_limit' => '100 MB',
                'project_limit' => 1,
                'features' => json_encode(['1 proje', '100 MB depolama', 'Topluluk desteği']),
            ]
        );

        Plan::firstOrCreate(
            ['slug' => 'pro'],
            [
                'name' => 'Pro',
                'description' => 'Pro plan',
                'price' => 199.00,
                'storage_limit' => '10 GB',
                'project_limit' => 10,
                'features' => json_encode(['10 proje', '10 GB depolama', 'E-posta desteği', 'Gelişmiş raporlar']),
            ]
        );

        Plan::firstOrCreate(
            ['slug' => 'enterprise'],
            [
                'name' => 'Enterprise',
                'description' => 'Enterprise plan',
                'price' => 999.00,
                'storage_limit' => '100 GB',
                'project_limit' => -1,
                'features' => json_encode(['Sınırsız proje', '100 GB depolama', 'Öncelikli destek', 'Özel entegrasyonlar']),
            ]
        );
    }
}