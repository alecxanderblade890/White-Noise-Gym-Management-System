<?php

namespace Database\Seeders;

use App\Models\Member;
use App\Models\DailyLog;
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
        //Member::factory(3)->create();
        DailyLog::factory(10)->create();
    }
}
