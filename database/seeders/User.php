<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class User extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert([
            [
                "nik"=> "0000000000000000",
                "name" => "admin",
                "email" => "admin@desaciasmara.com",
                "password" => bcrypt("user1234"),
                "role" => "admin",
                "address" => "Jl. Raya No. 1",
                "phone" => "081234567890",
                "ktp" => "ktp.jpg",
                "kk" => "kk.jpg",
                "is_active" => true,
            ]
        ]);
    }
}
