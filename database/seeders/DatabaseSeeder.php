<?php

namespace Database\Seeders;

use App\Http\Containers\UsersContainer\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
         User::factory()->create([
             'name' => 'Test User 1',
             'email' => 'test-1@example.com',
         ]);

         User::factory()->create([
             'name' => 'Test User 2',
             'email' => 'test-2@example.com',
         ]);

         User::factory()->create([
             'name' => 'Test User 3',
             'email' => 'test-3@example.com',
         ]);

         User::factory()->create([
             'name' => 'Test User 4',
             'email' => 'test-4@example.com',
         ]);
    }
}
