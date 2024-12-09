<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;

/**
 * model povezan sa cateogories tabelom iz blog_project baze
 */
class Category extends Model
{
    use HasFactory;
    
    //tabela sa kojom je model povezan
    protected $table = 'categories';
    
    //Atributi koje je moguće dodati ili izmeniti.
    protected  $fillable = [
        'name',
        'description',
        'show_on_index',
        'priority',
        'created_at'
    ];
    
    /**
     * Generiše URL za specifičnu instancu kategorije
     * 
     * @return string URL za kategoriju
     */
    public function url(){
        
        // Generiše URL koristeći rutu imenovanu 'category' sa ID-em kategorije kao parametrom
        return route('category',['category' => $this->id]);
    }
    
     /**
     * metoda koja broji koliko postova ima u datoj kategoriji.
     *
     * @return int broj postova u datoj kategoriji
     */
    public function count(){
        $posts = Post::where('category_id', $this->id)
                            ->get();
        $posts_count = $posts->count();
        return $posts_count;
    }
    
    /**
     * Fetch-uje sve postove date kategorije.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany(Post::class, 'category_id', 'id');
    }
}
