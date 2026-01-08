<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $roles = array(
            [
                'id' => 1,
                'name' => 'Super Admin',
            ],
            [
                'id' => 2,
                'name' => 'Hostel Admin'
            ],
            [
                'id' => 3,
                'name' => 'Hostel Warden'
            ],
            [
                'id' => 4,
                'name' => 'Student'
            ],
        );

        foreach ($roles as $value) {
            $role = Role::where('name', $value['name'])->first();
            if (!$role) {
                Role::create(['name' => $value['name']]);
            }
        }
    }
}
