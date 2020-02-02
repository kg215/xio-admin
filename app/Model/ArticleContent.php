<?php

namespace App\Model;

class ArticleContent extends ModelProto
{
    protected $table="article_content";
    protected $fillable=["id","article_id","content"];

    public function article(){
        return $this->belongsTo('App\Model\Article','article_id','id');
    }

    public function toStruct()
    {
        $pStruct = parent::toStruct();
        $struct = array_merge($pStruct,[

        ]);
        return $struct;
    }

}
