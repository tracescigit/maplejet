<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class CreateSuperadminUser extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // Check if the user with the given email already exists
        $email = 'admin@tracesci.in';
        $userExists = DB::table('users')->where('email', $email)->exists();

        if (!$userExists) {
            // Insert the new user into the users table
            DB::table('users')->insert([
                'name' => 'superadmin',
                'email' => $email,
                'password' => Hash::make('Admin#123'), // Hash the password
                'status' => 1,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Optionally, you can define how to rollback this migration
        $email = 'admin@tracesci.in';
        DB::table('users')->where('email', $email)->delete();
    }
}
