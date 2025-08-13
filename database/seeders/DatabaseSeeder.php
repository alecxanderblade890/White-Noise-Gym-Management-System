<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\DailyLog;
use App\Models\User;
use Database\Factories\DailyLogFactory;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'username' => 'staff_access',
            'password' => 'cobol16',
            'role' => 'staff',
        ]);
        User::factory()->create([
            'username' => 'admin_access',
            'password' => 'qwerty789',
            'role' => 'admin',
        ]);
        // Member::factory(300)->create();
        // DailyLog::factory(25)->create();
    }
}
