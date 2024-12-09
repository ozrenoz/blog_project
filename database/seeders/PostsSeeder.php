<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->truncate();
        
        $category_ids = DB::table('categories')->pluck('id')->all();
        $author_ids = DB::table('authors')->pluck('id')->all();
        
        $faker = Faker::create();
        
        for($i = 0;$i < 5000; $i++){
            DB::table('posts')->insert([
                'heading' => $faker->sentence(),
                'post_description' => $faker->sentence(),
                'text' => $faker->text(1000),
                'category_id' => $faker->randomElement($category_ids),
                'author_id' => $faker->randomElement($author_ids),
                'photo' => $faker->imageUrl(150, 150, 'nature', true),
                'views' => $faker->numberBetween(45000,135000),
                'ban' => $faker->randomElement([0,1]),
                'created_at' => $faker->dateTimeBetween('-6 weeks', 'now')
            ]);
    }
}

}
