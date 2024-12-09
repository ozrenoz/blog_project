<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;


class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        
        DB::table('users')->truncate();

        DB::table('users')->insert([
            'name' => 'Ozren',
            'email' => 'ozrenop@gmail.com',
            'password' => Hash::make('cubes123'),
            'created_at' => now()
        ]);
      
    }
}
