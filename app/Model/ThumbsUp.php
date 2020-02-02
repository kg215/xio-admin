<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ThumbsUp extends Model
{
    protected $table = "thumbs_up";
    protected $fillable = ["uid","obj_id","type"];
    static $TypeArticle=1;
    static $TypeComment=2;

    static function article(){
        return self::query()->where("type",self::$TypeArticle);
    }

    static function comment(){
        return self::query()->where("type",self::$TypeComment);
    }
}
