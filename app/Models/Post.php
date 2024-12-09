<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Category;
use App\Models\Tag;
use App\Models\PostComment;
use App\Models\Author;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * model povezan sa posts tabelom iz blog_project baze
 */
class Post extends Model {

    use HasFactory;

    //tabela sa kojom je model povezan
    protected $table = 'posts';
    
    //Atributi koje je moguće dodati ili izmeniti.
    protected $fillable = [
        'heading',
        'post_description',
        'text',
        'category_id',
        'ban',
        'created_at',
        'is_hero',
        'hero_order'
        
    ];
    
     /**
     * Vraća URL do slike posta ako postoji, inače vraća sliku iz storage-a.
     *
     * @return string URL|storage photo
     */
    public function getImageUrl(){
        if(!is_null($this->photo)){
            return $this->photo;
        }
        return url('/themes/front/img/cube_1test.jpg');
    }
    
    /**
     * Generiše URL za specifičnu instancu posta
     * 
     * @return string URL za post
     */
    public function url() {
        
        // Generiše URL koristeći rutu imenovanu 'post' sa ID-em posta kao parametrom
        return route('post', ['post' => $this->id]);
    }
    
    /**
    * Vraća kategoriju kojoj post pripada.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function category() {

        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    /**
    * Vraća sve tagove koji su povezani sa postom.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
    */
    public function tags() {
        return $this->belongsToMany(Tag::class, 'post_tag', 'post_id', 'tag_id');
    }
    
    /**
     * Fetch-uje sve komentare datog posta.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments() {
        return $this->hasMany(PostComment::class, 'post_id', 'id');
    }
    
    /**
    * Scope koji filtrira postove koji nisu zabranjeni (banned).
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeNotBanned($query) {
        $query->where('ban', 0);
    }
    
    /**
    * Scope koji isključuje postove koji su Uncategorised.
    *
    * @param \Illuminate\Database\Eloquent\Builder $query
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeExcludeUncategorised($query)
    {
        return $query->whereHas('category', function($query) {
            $query->where('name', '!=', 'Uncategorised');
        });
    }
    
    /**
    * Vraća autora posta.
    *
    * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
    */
    public function author(){
        return $this->belongsTo(Author::class, 'author_id');
    }
    
    /**
    * Proverava da li je post označen kao hero.
    *
    * @return bool
    */
    public function isHero()
    {
        return $this->is_hero == 1;
    }

    /**
    * Postavlja ili update-uje hero order broj za post.
    *
    * @param int|null $order Redni broj hero posta.
    */
    public function setHeroOrder($order)
    {
        $this->hero_order = $order;
        $this->save();
    }
}
