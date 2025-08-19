<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TestUserSeeder extends Seeder
{
    public function run(): void
    {
        DB::table('users')->updateOrInsert(
            ['email' => 'test@gmail.com'],
            [
                'name' => 'Test User',
                'email' => 'test2@gmail.com',
                // 'password' => Hash::make('12345'),
                'password' => Hash('sha1', '12345'),
                'real_password' => '12345',
                'phone' => '0000000000',
                'lang_code' => 'ru',
            ]
        );
    }
}
