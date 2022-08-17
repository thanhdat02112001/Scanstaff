<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
         // Check if table is empty
         if (Role::count() == 0) {
            $roles = [
                [
                    'name' => 'Admin',
                ],
                [
                    'name' => 'Interviewer',
                ]
            ];

            foreach ($roles as $role) {
                Role::create($role);
            }
        }
    }
}
