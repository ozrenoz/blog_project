<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Post;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * model povezan sa tags tabelom iz blog_project baze
 */
class Tag extends Model
{
    use HasFactory;
    
    //tabela sa kojom je model povezan
    protected $table = 'tags';
    
    //Atributi koje je moguće dodati ili izmeniti.
    protected $fillable = ['name','created_at'];
    
    /**
     * Generiše URL za specifičnu instancu taga
     * 
     * @return string URL za tag
     */
    public function url(){
        
        // Generiše URL koristeći rutu imenovanu 'tag' sa ID-em taga kao parametrom
        return route('tag',['tag' => $this->id]);
    }
    
    /**
     * Fetch-uje sve postove datog taga.
     *
     * @return \Illuminate\Database\Eloquent\Relations\belongsToMany
     */
    public function posts(){
        
        return $this->belongsToMany(Post::class, 'post_tag', 'tag_id', 'post_id');
    }
}
