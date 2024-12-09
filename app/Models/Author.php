<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * model povezan sa authors tabelom iz blog_project baze
 */
class Author extends Model
{
    use HasFactory;
    
    //tabela sa kojom je model povezan
    protected $table = 'authors';
    
     //Atributi koje je moguće dodati ili izmeniti.
    protected $fillable = ['name', 'email', 'phone', 'photo'];

     /**
     * Fetch-uje sve postove ovog autora.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function posts(){
        return $this->hasMany(Post::class);
    }
    
    /**
     * Generiše URL za specifičnu instancu autora
     * 
     * @return string URL za autora
     */
    public function url(){
        
        // Generiše URL koristeći rutu imenovanu 'author' sa ID-em autora kao parametrom
        return route('author',['author' => $this->id]);
    }
    
     /**
     * Vraća URL do slike autora ako postoji, inače vraća placeholder.
     *
     * @return string URL|placeholder
     */
    public function getImageUrl(){
         if ($this->photo) {
            return $this->photo;
        }

        
        return 'https://via.placeholder.com/150'; 
    }
}
