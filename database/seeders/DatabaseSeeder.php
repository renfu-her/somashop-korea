<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => '管理員',
            'email' => 'renfu.her@gmail.com',
            'password' => Hash::make('Qq123456'),
            'is_admin' => true,
        ]);
        User::factory()->create([
            'name' => '小編',
            'email' => 'zivhsiao@gmail.com',
            'password' => Hash::make('Qq123456'),
        ]);
    }
}
