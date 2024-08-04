<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'adm@adm.com',
            'phone' => 0,
            'password' => Hash::make('123'),
            'is_admin' => true,
        ]);

        $this->call([
            UsersTableSeeder::class,
            ProductSeeder::class,
            ServiceSeeder::class,
            TransactionSeeder::class,
        ]);
    }
}
