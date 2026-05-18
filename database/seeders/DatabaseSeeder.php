<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Channel;
use App\Models\EpgProgram;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ─── Admin User ──────────────────────────────────────────────────────
        User::updateOrCreate(
            ['email' => 'admin@livetv.com'],
            [
                'name' => 'Admin',
                'phone' => '9876543210',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => true,
            ]
        );
    }
}
