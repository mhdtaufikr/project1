<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Taufik',
                'email' => 'taufik@gmail.com',
                'password' => '$2y$10$5g78QbOiTrOc7AvBe2IRJeiTF3oVdLUrZUaKO6VOifaXbL9nkhFVq', // Hashed password
                'login_counter' => 0,
                'is_active' => 1,
            ],
        ];

        foreach ($data as $user) {
            DB::table('users')->insert($user);
        }
    }
}

