<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ArticleGroup extends Model
{
    protected $table = "article_group";
    protected $fillable=["uid","title","path","pid"];

}
