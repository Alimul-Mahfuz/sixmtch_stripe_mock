<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class StripUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('PRAGMA foreign_keys = OFF;');
        DB::table('strip_users')->delete();
        DB::statement('PRAGMA foreign_keys = ON;');
        DB::table('strip_users')->insert(
            [
                'name' => 'Laravel Stripe Demo Application',
                'access_token' => 'dierei4543234323432',
                'expires_at' => now()->addDays(30),
            ]
        );
    }
}
