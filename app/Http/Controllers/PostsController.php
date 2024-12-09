<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Category;
use App\Models\PostComment;
use App\Models\Author;

class PostsController extends Controller
{
    public function post(Post $post){
    
    /*inkrementacija broja pregleda prilikom svake posete postu*/
    $post->increment('views');
    
    /*ucitavamo komentare za post*/
    $post->load('comments');
    
    $category = Category::findOrFail($post->category_id);
    $author = Author::findOrFail($post->author_id);
    
    // varijable za prethodni i naredni post
    $previous = Post::where('id', '<', $post->id)->orderBy('id', 'desc')->first();
    $next = Post::where('id', '>', $post->id)->orderBy('id', 'asc')->first();
        
    /*ovde mi je bila ideja da od svakog teksta dobijem 5 delova koje cu iskoristiti da popunim paragrafe u post.blade-u
    tako da ne poremetim dizajn stranice, tj da ne zalepim bzvz ceo tekst iz jednog komada*/
        
    // prvo ceo tekst smestam u varijablu
    $text = $post->text;

    // deljenje teksta u recenice
    $sentences = preg_split('/(?<=[.?!])\s+/', $text);

    // Delimo ukupan broj recenica zadatim brojem delova
    $totalSentences = count($sentences);
    $partsCount = 5;
    $sentencesPerPart = ceil($totalSentences / $partsCount);

    // Raspodela recenica u delove
    $textParts = array_chunk($sentences, $sentencesPerPart);

    // Spajanje recenica u svakom delu da bi se formirao tekst
    $finalParts = array_map(function ($part) {
        return implode(' ', $part);
    }, $textParts);

    // Ukoliko imamo vise od 5 delova, obezbedjujemo da se visak merge-uje u poslednji part
    if (count($finalParts) > 5) {
        $finalParts = array_merge(
            array_slice($finalParts, 0, 4),
            [implode(' ', array_slice($finalParts, 4))]
        );
    }
    
    /*ovde sam napravio jedan niz sa imenima(odradio random) i prosledio ga na post.blade jer sam tabelu popunio pomocu fejkera
     pa nemam imena u naslovu blog posta, kapiram da ce posle svakog refresha biti drugo ime ali ok*/
    $source_names = ['Richard Feynman', 'Srinivasa Ramanujan', 'John Nash', 'Steve Jobs', 'Bill Gates', 'Jeff Bezos', 'Mark Zuckerberg', 'Jensen Huang', 'Gabe Logan Newell', 'Hideo Kojima'];
     
    $randomName = $source_names[array_rand($source_names)];
        
    
    return view('front.post.post',[
            'post' => $post,
            'category' => $category,
            'textParts' => $finalParts,
            'randomName' => $randomName,
            'previous' => $previous,
            'next' => $next,
            'comments' => $post->comments,
            'author' => $author
        ]);
    }
    
    /*metoda za cuvanje komentara*/
    public function storeComment(){
        $data = request()->validate([
            'name' => ['required','string','min:2','max:50'],
            'email' => ['required','email'],
            'message' => ['required','string','min:10','max:250'],
            'post_id' => ['required','integer','exists:posts,id',]
        ]);
        
        $data['created_at'] = now();
        $data['updated_at'] = now();
        
        $comment = new PostComment();
        $comment->fill($data);
        $comment->save();
        
        return response()->json(['status' => 'ok', 'message' => 'Comment posted successfully!']);
        
    }
}
