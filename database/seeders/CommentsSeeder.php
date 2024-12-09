<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use Illuminate\Support\Facades\DB;

class CommentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('post_comments')->truncate();
        
        $faker = Faker::create();
        $posts = DB::table('posts')->pluck('id');

        foreach ($posts as $post_id) {
            $commentsCount = rand(1, 5); // ovo da svaki post ima izmedju jednog i pet komentara sam stavio proizvoljno

            for ($i = 0; $i < $commentsCount; $i++) {
                DB::table('post_comments')->insert([
                    'post_id' => $post_id,
                    'name' => substr($faker->name, 0, 30), //morao sam ovako jer mi je u nekim slucajevima davao imena duza od 30 karaktera sto se kosi sa ogranicenjem iz migracije
                    'email' => $faker->safeEmail,
                    'message' => $faker->words(50, true), //i ovo da svaki komentar ima do 50 reci sam stavio proizvoljno
                    'allowed' => 0,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
