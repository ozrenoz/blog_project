<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;


class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->truncate();
        //ovo sam stavio u niz, nisam hteo preko fejkera
        $category_names = ['Biznis', 'Kultura', 'Sport', 'Politika', 'Putovanja', 'Film', 'Muzika', 'Istorija'];
        
        $faker = Faker::create();
        
        /*Uncategorised kategoriju sam dodao preko admina*/
        
        for($i=0; $i < count($category_names); $i++){
            DB::table('categories')->insert([
                'name' => $category_names[$i],
                'description' => $faker->text(50),
                'show_on_index' => 1,
                'priority' => $i+1,
                'created_at' => now()
            ]);
            
        }
    }
}
