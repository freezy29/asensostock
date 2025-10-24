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
                'first_name' => 'Maam',
                'last_name' => 'Nawe',
                'email' => 'nawe@gmail.com',
                'phone' => '09696969696',
                'role' => 'admin',
                'password' => Hash::make('admin123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'sir',
                'last_name' => 'balboa',
                'email' => 'balboa@gmail.com',
                'phone' => '09696969696',
                'role' => 'staff',
                'password' => Hash::make('staff123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'first_name' => 'sir',
                'last_name' => 'delgado',
                'email' => 'delgafo@gmail.com',
                'phone' => '09696969696',
                'role' => 'staff',
                'password' => Hash::make('staff123'),
                'remember_token' => Str::random(10),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
