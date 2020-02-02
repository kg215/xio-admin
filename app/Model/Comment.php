<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table="comment";
    protected $fillable=["uid","reply_to","complaint","thumbs_up","pid","comment","article_id","content","disabled"];


    public function article(){
        return $this->belongsTo('App\Model\Article','article_id','id');
    }


    public function user(){
        return $this->belongsTo(User::class,'uid','uid');
    }

    public function replyUser()
    {
        return $this->hasOne(User::class,'uid','uid');
    }

    public function reply(){
        return $this->hasMany(self::class,'pid','id')->orderBy("created_at","desc")->with("user")->with("replyUser");
    }

}
