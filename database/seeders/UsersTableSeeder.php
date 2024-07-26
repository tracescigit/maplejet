<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        // Insert a new user with the specified details
        DB::table('users')->insert([
            'name' => 'superadmin',
            'email' => 'admin@tracesci.in',
            'password' => Hash::make('Admin@tracesci123'),
            'status' => true, // Assuming true for active status
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
