<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\Member;
use App\Models\Setting;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        
        User::firstOrCreate(
            ['email' => 'admin@admin.com'],
            [
                'name' => '管理員',
                'password' => Hash::make('Qq123456'),
                'is_admin' => true,
            ]
        );

        Member::firstOrCreate(
            ['email' => 'renfu.her@gmail.com'],
            [
                'name' => '小編',
                'password' => Hash::make('Qq123456'),
                'is_active' => true,
                'gender' => 1,
                'agree' => 1
            ]
        );

        Setting::firstOrCreate(
            ['key' => 'shipping_fee'],
            [
                'value' => 100,
                'description' => 'Home Delivery Shipping Fee'
            ]
        );

        Setting::firstOrCreate(
            ['key' => '711_shipping_fee'],
            [
                'value' => 80,
                'description' => '7-11 Pickup Shipping Fee'
            ]
        );

        Setting::firstOrCreate(
            ['key' => 'family_shipping_fee'],
            [
                'value' => 80,
                'description' => 'FamilyMart pickup shipping fee'
            ]
        );
    }
}
