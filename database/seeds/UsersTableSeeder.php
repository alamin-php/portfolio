<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
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
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin@blog.com',
            'password' => Hash::make('rootadmin'),
            'type' => 'admin',
        ]);
        DB::table('users')->insert([
            'name' => 'User',
            'email' => 'user@blog.com',
            'password' => Hash::make('rootuser'),
            'type' => 'user',
        ]);
        DB::table('users')->insert([
            'name' => 'Author',
            'email' => 'author@blog.com',
            'password' => Hash::make('rootauthor'),
            'type' => 'author',
        ]);
    }
}
