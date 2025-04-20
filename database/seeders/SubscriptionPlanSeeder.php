<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubscriptionPlanSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('subscription_plans')->insert([
            [
                'name' => 'One-Time Purchase',
                'description' => 'Pay once and get lifetime access with no recurring fees.',
                'price' => 49.00,
                'duration' => 0, // 0 for lifetime
                'is_auto_renewable' => false,
                'grace_period' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Monthly Plan',
                'description' => 'Subscribe monthly and enjoy flexibility.',
                'price' => 9.00,
                'duration' => 30,
                'is_auto_renewable' => true,
                'grace_period' => 5,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Yearly Plan',
                'description' => 'Best value plan with full access for a year.',
                'price' => 89.00,
                'duration' => 365,
                'is_auto_renewable' => true,
                'grace_period' => 10,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
