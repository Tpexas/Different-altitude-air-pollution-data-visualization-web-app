<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\Report;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        Report::factory(10)->create();

        // \App\Models\User::factory(10)->create();

    // Report::factory()->create([
    //         'time' => 'Test User',
    //         'sensor1' => 'test@example.com',

    //     // \App\Models\User::factory()->create([
    //     //     'name' => 'Test User',
    //     //     'email' => 'test@example.com',
    //     ]);
    }
}
