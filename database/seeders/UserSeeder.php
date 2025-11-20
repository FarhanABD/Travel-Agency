<?php

namespace Database\Seeders;

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
                'name'      => 'Admin User',
                'email'     => 'admin@example.com',
                'photo'     => null,
                'password'  => Hash::make('password123'),
                'phone'     => '081234567890',
                'country'   => 'Indonesia',
                'address'   => 'Jl. Raya No. 123',
                'state'     => 'Jawa Timur',
                'city'      => 'Surabaya',
                'zip'       => '60123',
                'token'     => Str::random(32),
                'status'    => 1, // active
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
            [
                'name'      => 'Test User',
                'email'     => 'user@example.com',
                'photo'     => null,
                'password'  => Hash::make('user12345'),
                'phone'     => '081298765432',
                'country'   => 'Indonesia',
                'address'   => 'Jl. Melati No. 45',
                'state'     => 'Jawa Tengah',
                'city'      => 'Semarang',
                'zip'       => '50123',
                'token'     => Str::random(32),
                'status'    => 0, // pending
                'created_at'=> now(),
                'updated_at'=> now(),
            ],
        ]);
    }
}