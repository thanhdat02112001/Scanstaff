<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Check if table is empty
        if (User::count() == 0) {
            // Create user
            User::create([
                'name' => 'Admin',
                'email' => 'dat.dt@zinza.com.vn',
                'password' => Hash::make(12345678),
                'email_verified_at' => now(),
                'banned' => 0,
                'approved_at' => now()
            ]);
        }
    }
}
