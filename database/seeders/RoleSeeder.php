<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\UserRole;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Role::create([
        //     'name' => 'admin',
        // ]);
        UserRole::create([
            'user_id' => 1,
            'role_id' => 2,
        ]);
    }
}
