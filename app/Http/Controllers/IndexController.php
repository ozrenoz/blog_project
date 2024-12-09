<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;


class IndexController extends Controller
{
    
    public function index(){
        
        $categories = Category::orderBy('priority', 'asc')->get();
        
        /*za dinamicko popunjavanje latest post parcijala index-a*/
        $latest_12_posts = Post::orderBy('created_at', 'desc')
                              ->excludeUncategorised()
                              ->notBanned()
                              ->limit(12)
                              ->get();
        
        /*za dinamicko popunjavanje intro section parcijala index-a*/
        $important_posts = Post::where('important', 1)
                          ->notBanned()
                          ->excludeUncategorised()
                          ->orderBy('created_at', 'desc')
                          ->limit(3)
                          ->get();
        
        /*za dinamicko popunjavanje gallery parcijala index-a*/
        $four_gallery_posts = Post::where('views', '>', 100000)
                              ->notBanned()
                              ->excludeUncategorised()
                              ->orderBy('created_at', 'desc')
                              ->limit(4)
                              ->get();
        
        /*za dinamicko popunjavanje hero section parcijala index-a*/
        $hero_posts = Post::where('is_hero', true)
                     ->notBanned()
                     ->excludeUncategorised()
                     ->orderBy('hero_order')
                     ->limit(10) //ovo sam proizvoljno stavio
                     ->get();
        
        
        return view('front.index.index',[
            'categories' => $categories,
            'latest_12_posts' => $latest_12_posts,
            'important_posts' => $important_posts,
            'four_gallery_posts' => $four_gallery_posts,
            'hero_posts' => $hero_posts
                
        ]);
    }
}
