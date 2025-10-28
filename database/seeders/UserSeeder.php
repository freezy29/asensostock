<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'System',
                'last_name' => 'Owner',
                'email' => 'owner@gmail.com',
                'phone' => '09696969696',
                'role' => 'super_admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'System',
                'last_name' => 'Administrator',
                'email' => 'admin@gmail.com',
                'phone' => '09696969696',
                'role' => 'admin',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'Renejay',
                'last_name' => 'Barcase',
                'email' => 'renejay@gmail.com',
                'phone' => '09696969696',
                'role' => 'staff',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'H2',
                'last_name' => 'WO',
                'email' => 'h2wo@gmail.com',
                'phone' => '09696969696',
                'role' => 'staff',
                'password' => Hash::make('password'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
