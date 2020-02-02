<?php

namespace App\Model;


class Article extends ModelProto
{
    protected $table="article";
    protected $fillable=["id","intro_img","intro","disabled","group_id","title","module_id","uid","nickname","footstep","thumbs_up","star"];

    /**
     * @var $content ArticleContent
     */
    protected $content;

    public function content(){
        return $this->hasOne(ArticleContent::class,'article_id');
    }

    public function group(){
        return $this->belongsTo(ArticleGroup::class,'group_id');
    }

    public function comment(){
        return $this->hasMany(Comment::class,'article_id');
    }

    public function user(){
        return $this->belongsTo(User::class,'uid');
    }

    public function module(){
        return $this->belongsTo(ArticleModule::class,"module_id","id");
    }

    public function thumbsup(){
        return $this->hasMany(ThumbsUp::class,'uid');
    }

}
