<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class PostTagSeeder extends Seeder {

    /**
     * Run the database seeds.
     */
    public function run(): void {
        
    DB::table('post_tag')->truncate();

    $postsIds = Post::pluck('id')->all();
    $tagsIds = Tag::pluck('id')->all();

    foreach ($postsIds as $postId) {
        /*ovo radim da mi se ne bi desilo da mi se kod blog posta jedan tag javi vise puta*/
        $shuffledTags = $tagsIds;
        shuffle($shuffledTags);
        $assignedTags = array_slice($shuffledTags, 0, rand(1, 5));

        foreach ($assignedTags as $tagId) {
            DB::table('post_tag')->insert([
                'post_id' => $postId,
                'tag_id' => $tagId
            ]);
        }
    }
  }
}
