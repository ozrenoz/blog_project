<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Carbon\Carbon;
use Illuminate\Support\Facades\Cache;

class ComposerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
      
        //categories_for_display za widget-e
      View::composer([
        'front._layout._footer',
        'front.pages.blog',
        'front.post.post',
        'front.search.search',
        'front.tag.tag',
        'front.category.category',
        'front.author.author'
    ], function ($view) {
        $categoriesKey = 'categories_for_display';
        $categories = Cache::remember($categoriesKey, 60, function () {
        return Category::where('name', '!=', 'Uncategorised')
            ->orderBy('priority', 'asc')
            ->get();
        });

        $view->with('categories_for_display', $categories);
        });
        
    
        //3 najnovija posta za footer
        View::composer('front._layout._footer', function ($view) {
            $latest_posts = Post::orderBy('created_at', 'desc')
                              ->limit(3)
                              ->excludeUncategorised()
                              ->notBanned()
                              ->get();
            $view->with('latest_posts', $latest_posts);
        });
        
        
        //tagovi za widget-e
         View::composer(['front.pages.blog', 'front.category.category', 'front.post.post', 'front.tag.tag','front.search.search','front.author.author'], function ($view) {
            $tagsKey = 'all_tags';
            $tags = Cache::remember($tagsKey, 60, function () {
                   return Tag::all();
            });

            $view->with('all_tags', $tags);
            
         });
        
        /*mvlm -> most viewd last month*/
        View::composer(
        ['front.pages.blog', 'front.post.post', 'front.category.category', 'front.pages.contact_us', 'front.tag.tag','front.search.search','front.author.author'],
        function ($view) {
            $mvlm_posts = Post::orderBy('views', 'desc')
                ->where('created_at', '>=', Carbon::now()->subMonth(2))
                ->excludeUncategorised()
                ->notBanned()
                ->limit(3)
                ->get();

            $view->with('mvlm_posts', $mvlm_posts);
        }
    );
    }
}
