<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'admin',
            'email' => 'admin@admin.com',
            'email_verified_at' => now(),
            'password' => bcrypt('password'),
            'is_admin' => true,
            'remember_token' => Str::random(10),
            'api_token' => Str::random(32)
        ]);

        DB::table('users')->insert([
            'name' => 'denis',
            'email' => 'denis@gmail.com',
            'email_verified_at' => now(),
            'password' => bcrypt('denis1234'),
            'is_admin' => false,
            'remember_token' => Str::random(10),
            'api_token' => Str::random(32)
        ]);
    }
}
