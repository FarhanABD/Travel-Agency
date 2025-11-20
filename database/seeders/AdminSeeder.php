<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $obj = new \App\Models\Admin();
        $obj->name = "Admin";
        $obj->email = "admin@gmail.com";
        $obj->photo = "";
        $obj->password = Hash::make('1234');
        $obj->token = "";
        $obj->save();
    }
}