<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Cache;

class PostsController extends Controller
{
    public function index(){
        return view('admin.posts.index');
    }
    
    public function datatable(){
        
        /*metoda za kreiranje posts tabele u admin delu*/
        $query = Post::query();
        
        $datatable = DataTables::of($query);
        $datatable->addColumn('picture',function($row){
            return '<img src="'.$row->getImageUrl().'"style="height : 100px">';
        })->addColumn('category',function($row){
            return optional($row->category)->name;
        })->addColumn('tags',function($row){
            return optional($row->tags->pluck('name'))->join(', ');
        })->editColumn('created_at',function($row){
            return date_format($row->created_at, 'd.m.Y H:i:s');
        })->editColumn('ban',function($row){
            if($row->ban){
                return 'ban';
            }
            return 'active';
        })->addColumn('actions',function($row){
            return view('admin.posts.partials.actions',[
                'post' => $row
            ]);
        })->rawColumns(['picture','actions']);
                
        
        return $datatable->toJson();
        
    }
    /*metoda za dodavanje novog blog posta*/
    public function addPost(){
        $categories = Category::get();
        $tags = Tag::get();
        
        return view('admin.posts.add_post',[
            'categories' => $categories,
            'tags' => $tags
        ]);
    }
    
    /*metoda za cuvanje blog posta*/
    public function store(){
        $data = request()->validate([
            'heading' => ['required','string','min:5','max:60'],
            'post_description' => ['required','string','min:5','max:200'],
            'category_id' => ['required','numeric','exists:categories,id'],
            'tags' => ['required','array','min:3'],
            'tags.*' => ['nullable','numeric','exists:tags,id'],
            'text' => ['required','string'],
            'photo' => ['nullable','file','max:10000','mimes:jpg,png,jpeg']
        ]);
        $data['ban'] = 0;
        $data['created_at'] = now();
        
        $new_post = new Post();
        $new_post->fill($data);
        $new_post->save();
        
        $new_post->tags()->sync($data['tags']);
        
        //cuvanje slike
        if(request()->hasFile('photo')){
            $photo = request()->file('photo');
            $this->savePhoto($photo,$new_post);
        }
        
        session()->put('system_message','Post je uspesno sacuvan!');
        
        return redirect()->route('admin.post.index');
    }
    
    /*metoda za brisanje blog posta*/
    public function delete(){
        $data = request()->validate([
            'id' => ['required','numeric','exists:posts,id']
        ]);
        
        $post_for_delete = Post::findOrFail($data['id']);
        $post_for_delete->delete();
        
        $post_for_delete->tags()->sync([]);
        
        return response()->json(['status' => 'ok']);
    }
    
    /*metoda za menjanje ban statusa posta; banovani postovi se ne prikazuju ni na jednom page-u*/
    public function changeBanStatus(){
        
        $data = request()->validate([
            'id' => ['required','numeric','exists:posts,id']
        ]);
        
        $post = Post::findOrFail($data['id']);
        
        if($post->ban){
            $post->ban = 0;
        }else{
            $post->ban = 1;
        }
        
        $post ->save();
        
        return response()->json(['status' => 'ok']);
    }
    
    /*menjanje important statusa posta; ovo smo koristili za dinamicko popunjavanje intro section-a
     postovima za koje odredimo important = 1*/
    public function toggleImportant(Request $request){
    $data = $request->validate([
        'id' => ['required', 'numeric', 'exists:posts,id']
    ]);

    $post = Post::findOrFail($data['id']);
    $post->important = !$post->important;
    $post->save();

    return response()->json(['status' => 'ok', 'important' => $post->important]);
    }
    
   /*metoda kojom menjamo hero order hero marked postova; */
   public function updateHeroOrder(Request $request) {
    $data = $request->validate([
        'id' => 'required|exists:posts,id',
        'hero_order' => 'required|integer|min:1',
    ]);
    //post za koji zelimo da promenimo hero order
    $post = Post::find($data['id']);

    // trazimo da li postoji hero marked post sa hero orderom koji je jednak hero orderu iz request-a
    $existing_post = Post::where('hero_order', $data['hero_order'])
                        ->where('is_hero', 1)
                        ->where('id', '!=', $data['id'])
                        ->first();

    if ($existing_post) {
        // Setujemo hero order postojeceg posta da bude jednaka hero order-u posta kojem menjamo hero order
        $existing_post->hero_order = $post->hero_order;
        $existing_post->save();
    }

    /*Update hero order-a za post(za koji smo inicijalno zeleli da promenimo hero order)*/
    $post->hero_order = $data['hero_order'];
    $post->save();

    return response()->json(['status' => 'ok']);
}
    
    /*metoda koja vraca postojeci hero order za postove koji su marked hero*/
    public function getExistingHeroOrders() {
    $taken_orders = Post::where('is_hero', 1)
                       ->whereNotNull('hero_order')
                       ->pluck('hero_order')
                       ->toArray();

    return response()->json([
        'taken_orders' => $taken_orders,
        /*izracunavamo prvi sledeci slobodan hero order broj, ukoliko je takenOrders empty onda ce prvi
         prvi slobodan hero order broj biti 1*/
        'first_available' => $taken_orders ? max(min($taken_orders) + 1, 1) : 1,
    ]);
    }
    
    /*metoda kojom menjamo hero status posta*/
   public function toggleHeroStatus(Request $request) {
    $data = $request->validate([
        'id' => 'required|exists:posts,id',
    ]);

    $post = Post::find($data['id']);
    
    if ($post->is_hero) {
        // Ako je post imao hero status 1 setujemo na 0 i hero order mu setujemo null
        $post->is_hero = 0;
        $post->hero_order = null;
    } else {
        // ukoliko post nije imao hero status, setujemo ga na 1
        $post->is_hero = 1;

        /* Trazimo prvi raspolozivi hero order broj(u index controller-u sam proizvoljno stavio
        da u hero section-u imamo 10 hero postova) */
        $taken_orders = Post::where('is_hero', 1)->pluck('hero_order')->toArray();
        $available_order = 1;
        while (in_array($available_order, $taken_orders) && $available_order <= 10) {
            $available_order++;
        }

        // Dodeljujemo raspolozivi hero order broj postu(do broja 10), u supretnom setujemo hero order null
        $post->hero_order = $available_order <= 10 ? $available_order : null;
    }

    $post->save();

    return response()->json([
        'status' => 'ok', 
        'is_hero' => $post->is_hero, 
        'hero_order' => $post->hero_order
    ]);
}   
    
    /*metoda za editovanje posta*/
    public function edit(Post $post){
        $categories = Category::get();
        $tags = Tag::get();
        
        return view('admin.posts.edit_post',[
            'categories' => $categories,
            'tags' => $tags,
            'post' => $post
        ]);
    }


    /*metoda za update posta*/
    public function update(Post $post){
        $data = request()->validate([
            'heading' => ['required','string','min:5','max:60'],
            'post_description' => ['required','string','min:5','max:200'],
            'category_id' => ['required','numeric','exists:categories,id'],
            'tags' => ['required','array','min:3'],
            'tags.*' => ['nullable','numeric','exists:tags,id'],
            'text' => ['required','string'],
            'photo' => ['nullable','file','max:10000','mimes:jpg,png,jpeg']
        ]);
        
        $post->fill($data);
        $post->save();
        
        $post->tags()->sync($data['tags']);
        
        //cuvanje slike
        if(request()->hasFile('photo')){
            $this->deletePhoto($post);
            $photo = request()->file('photo');
            $this->savePhoto($photo,$post);
            
        }
        
        session()->put('system_message','Post je uspesno izmenjen!');
        
        return redirect()->route('admin.post.index');
    }
    
    /*metoda za cuvanje fotografije/vizuala*/
    public function savePhoto($photo,$post){
        $photo_name = $post->id.'_'.$photo->getClientOriginalName();
            $photo->move(public_path('/storage/photos'),$photo_name);
            
            $post->photo = $photo_name;
            $post->save();
    }
    
    /*metoda za brisanje fotografije/vizuala povezane sa postom*/
    public function deletePhoto($post){
        $path = public_path('/storage/photos/').$post->photo;
        if(is_file($path)){
            unlink($path);
        }
    }
    
    /*metoda koja poziva metodu deletePhoto(), setuje photo atribut postna na null i vraca response*/
    public function editDeletePhoto(Post $post){
        $this->deletePhoto($post);
        $post->photo = null;
        $post->save();
        
        return response()->json([
            'status' => 'ok',
            'photoUrl' => $post->getImageUrl()
            ]);
    }
}
