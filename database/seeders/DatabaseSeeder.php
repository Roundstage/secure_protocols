<?php

namespace Database\Seeders;

use App\Models\Protocol;
use App\Models\Role;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        //User::factory(10)->create();


        Role::factory()->create([
            'description' => 'Gerente de TI',
            'level' =>'Manager'
        ]);
        Role::factory()->create([
            'description' => 'Programador',
            'level' =>'Staff'
        ]);
        Protocol::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 1,
        ]);
        User::factory()->create([
            'name' => 'Test Programador',
            'email' => 'Programador@example.com',
            'password' => bcrypt('password'),
            'email_verified_at' => now(),
            'role_id' => 2,
        ]);
    }
}
