<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Author;

class AdminSearchController extends Controller
{
    /*metoda za pretragu po autorima i postovima*/
   public function search(Request $request){
    $query = $request->input('query');

    if (!$query) {
        return redirect()->back()->with('error', 'Please enter a search term.');
    }

    $posts = Post::where('heading', 'LIKE', "%{$query}%")->get();
    $authors = Author::where('name', 'LIKE', "%{$query}%")->get();

    return view('admin.search_results.search_results', [
        'query' => $query,
        'posts' => $posts,
        'authors' => $authors,
    ]);
    }
}
