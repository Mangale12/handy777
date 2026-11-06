<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

return new class extends Migration
{
    public function up()
    {
        // Do not overwrite an existing account or its password.
        if (DB::table('users')->where('email', 'admin@admin.com')->exists()) {
            return;
        }

        $admin = [
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => Hash::make('nepal@123'),
            'role' => 'admin',
            'status' => 1,
            'email_verified_at' => now(),
            'created_at' => now(),
            'updated_at' => now(),
        ];

        DB::table('users')->insert($admin);
    }

    public function down()
    {
        // Only remove the account created by this migration. The account may
        // have been edited after deployment, so leave it in place on rollback.
    }
};
