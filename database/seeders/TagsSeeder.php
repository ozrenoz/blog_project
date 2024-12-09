<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;


class TagsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('tags')->truncate();
        
        /*vidim po html fajlovima da su tagovi slicni kategorijama pa popunjavam preko niza a ne pomocu fejkera*/
        $tag_names = ['Biznis', 'Kultura', 'Sport', 'Politika', 'Putovanja', 'Film', 'Muzika', 'Istorija', 'Tehnologija', 'Moda'];
        
        
        
        for($i=0; $i < count($tag_names); $i++){
            DB::table('tags')->insert([
                'name' => $tag_names[$i],
                'created_at' => now()
            ]);
            
        }
        
    }
}
