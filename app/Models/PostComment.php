<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * model povezan sa post_comments tabelom iz blog_project baze
 */
class PostComment extends Model
{
    use HasFactory;
    
    //tabela sa kojom je model povezan
    protected $table = 'post_comments';
    
    //atributi koje je moguce dodeliti prilikom kreiranja novog komentara
    protected $fillable = ['name','email','message','post_id','created_at','updated_at'];
}
