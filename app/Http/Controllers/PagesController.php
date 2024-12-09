<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Tag;
use App\Models\Author;
use Illuminate\Support\Facades\Cache;

class PagesController extends Controller
{
    
        
    public function blog(){
        
        
        /*za dinamicko popunjavanje blog blade-a*/
        $latest_twelve_posts = Post::orderBy('created_at','desc')
                ->with('category', 'author')
                ->excludeUncategorised()
                ->notBanned()
                ->paginate(12);
        
        
        return view('front.pages.blog',[
            
            'latest_twelve_posts' => $latest_twelve_posts
                
        ]);
        }
        
    public function category(Category $category){
        
        
        /*za dinamicko popunjavanje category blade-a fetchujemo postove koji pripadaju istoj kategoriji*/
        $posts = $category->posts()
                ->excludeUncategorised()
                ->notBanned()
                ->orderBy('created_at','desc')
                ->paginate(12);
        
        return view('front.category.category',[
            'category' => $category,
            'posts' => $posts
        ]);
    }
    
    public function tag(Tag $tag){
        
        
        /*za dinamicko popunjavanje tag blade-a fetchujemo postove koji pripadaju istom tagu*/
        $posts = $tag->posts()
                ->excludeUncategorised()
                ->notBanned()
                ->orderBy('created_at','desc')
                ->paginate(12);
        
        return view('front.tag.tag',[
            'tag' => $tag,
            'posts' => $posts
        ]);
    }
    
    /*metoda za pretrazivanje bloga*/
    public function search(Request $request){
        
    $query = $request->input('query');
    
    if (!empty($query)) {
        $posts = Post::where('heading', 'like', '%' . $query . '%')
            ->orWhere('post_description', 'like', '%' . $query . '%')
            ->orWhere('text', 'like', '%' . $query . '%')
            ->excludeUncategorised()
            ->notBanned()
            ->paginate(12);
    } else {
        $posts = collect();
    }

    return view('front.search.search', ['posts' => $posts, 'query' => $query]);
    }
    
    /*za dinamicko popunjavanje author blade-a fetchujemo postove koji pripadaju istom autoru*/
    public function author(Author $author){
        
        $posts = $author->posts()
            ->notBanned()
            ->excludeUncategorised()
            ->paginate(10);

        return view('front.author.author', [
            'author' => $author,
            'posts' => $posts,
           
        ]);
    }
}
