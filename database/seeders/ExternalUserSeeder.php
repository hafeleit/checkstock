<?php

namespace Database\Seeders;

use App\Models\External\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ExternalUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::updateOrCreate([
            'username' => 'admin',
            'email' => 'admin@admin.com',
            'password'=> bcrypt('12345678'),
            'first_name' => 'Admin',
            'last_name' => 'Tester',
        ]);
    }
}
