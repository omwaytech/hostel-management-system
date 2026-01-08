<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $users = array(
            [
                'name' => 'Super Admin',
                'email' => 'superadmin@email.com',
                'password' => Hash::make('superadmin@email.com'),
                'slug' => 'super-admin',
                'role' => 1,
            ],
        );

        foreach ($users as $key => $value) {
            $user = User::where('email', $value['email'])->first();
            if (!$user) {
                $user = User::create([
                    'name' => $value['name'],
                    'email' => $value['email'],
                    'password' => $value['password'],
                    'role_id' => $value['role'],
                    'slug' => $value['slug'],
                ]);
            }
        }
    }
}
