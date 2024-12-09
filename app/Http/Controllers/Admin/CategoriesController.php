<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class CategoriesController extends Controller
{

public function index(){
        $categories = Category::orderBy('priority','asc')->get();
        return view('admin.categories.index',[
            'categories' => $categories
        ]);
    }
    
     /*metoda za dodavanje nove kategorije(forma na add category blade-u)*/
    public function addCategory(){
        
        return view('admin.categories.add_category');
        
    }
    
     /*metoda za cuvanje nove kategorije*/
    public function store(){
        $data = request()->validate([
            'name' => ['required','string','min:3','max:30','unique:categories,name'],
            'description' => ['required','string','min:5','max:60'],
            'show_on_index' => ['nullable','in:1']
        ]);
        
        if(!isset($data['show_on_index']) && empty($data['show_on_index'])){
            $data['show_on_index'] = 0;
        }
        
        /*setujemo priority nove kategorije; fetch-ujemo sve kategorije i ukoliko kategorije postoje u bazi,
          novoj kategoriji setujemo priority + 1 od kategorije sa najvecim priority-jem; ukoliko nema kategorija u 
         bazi, znaci da je novododata kategorija ujedno i prva i setujemo joj priority 1*/
        $highest_priority_category = Category::orderBy('priority','desc')->first();
        if(isset($highest_priority_category) && !empty($highest_priority_category)){
            $new_category_priority = $highest_priority_category->priority + 1;
        }else{
            $new_category_priority = 1;
        }
        
        $data['priority'] = $new_category_priority;
        $data['created_at'] = now();
        
        $new_category = new Category();
        $new_category->fill($data);
        $new_category->save();
        
        //ciscnjenje categories cache
        Cache::forget('categories_for_display');
        
        session()->put('system_message','Kategorija je uspesno dodata!');
        
        return redirect()->route('admin.category.index');
        
    }
    
    /*metoda koja nas vodi na edit category blade*/
    public function edit(Category $category){
        return view('admin.categories.edit_category',[
            'category' => $category
        ]);
    }
    
    /*metoda za izmenu odredjene kategorije(forma za edit je na edit category blade-u)*/
    public function update(Category $category){
        $data = request()->validate([
            'name' => ['required','string','min:3','max:30','unique:categories,name'],
            'description' => ['required','string','min:5','max:60'],
            'show_on_index' => ['nullable','in:1']
        ]);
        
        if(!isset($data['show_on_index']) && empty($data['show_on_index'])){
            $data['show_on_index'] = 0;
        }
        
        $category->fill($data);
        $category->save();
        
        //ciscnjenje categories cache
        Cache::forget('categories_for_display');
        
        session()->put('system_message','Kategorija je uspesno izmenjena!');
        
        return redirect()->route('admin.category.index');
    }
    
     /*metoda za brisanje kategorije*/
    public function delete(){
        $data = request()->validate([
            'category_for_delete_id' => ['required','numeric','exists:categories,id']
        ]);
        
        $category = Category::findOrFail($data['category_for_delete_id']);
        $category->delete();
        
        /*izmena prioriteta preostalih kategorija(svim kategorijama koje su imale priority veci od 
          priority-ja izbrisane kategorije, isti se smanjuje za 1)*/
        $categories_for_priority_update = Category::where('priority','>',$category->priority)->get();
        foreach ($categories_for_priority_update as $category_for_update){
            $category_for_update->priority = $category_for_update->priority-1;
            $category_for_update->save();
        }
        
        
        //ciscnjenje categories cache
        Cache::forget('categories_for_display');
        
        session()->put('system_message','Kategorija je uspesno obrisana!');
        
        return redirect()->route('admin.category.index');
        
    }
    
     /*metoda za izmenu redosleda kategorija*/
    public function reorder(){
        $data = request()->validate([
            'order' => ['required','string']
        ]);
        
        $ids = $data['order'];
        $idsArray = explode(',', $ids);
        
        foreach ($idsArray as $key => $id){
            $category = Category::findOrFail($id);
            $category->priority = $key+1;
            $category->save();
        }
        
        //ciscnjenje categories cache
        Cache::forget('categories_for_display');
        
        session()->put('system_message','Redosled kategorija je uspesno promenjen!');
        
        return redirect()->route('admin.category.index');
    }    

}
