<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\Author;

class IndexController extends Controller
{
    public function index()
{
    // Post sa najvise pregleda
    $top_post = Post::with('author')->orderByDesc('views')->first();

    // Kategorija sa najvise pregleda
    $top_category= Category::withCount('posts')
        ->withSum('posts as total_views', 'views')
        ->orderByDesc('total_views')
        ->first();

    // Autor sa najvise pregleda
    $top_author = Author::with('posts')
        ->withSum('posts as total_views', 'views')
        ->orderByDesc('total_views')
        ->first();

    return view('admin.index', compact('top_post', 'top_category', 'top_author'));
}
    /*metoda koja nam vraca podatke o ulogovanom korisniku/adminu*/
    public function profile(){
        
        $user = auth()->user();
        
        return view('admin.profile',[
            "user" => $user
        ]);
    }
}
