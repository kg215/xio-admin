<?php

namespace App\Model;


class ArticleModule extends ModelProto
{
    protected $table="article_module";
    protected $fillable=["id","title","desc"];

    public function toStruct()
    {
        $pStruct = parent::toStruct();
        $struct = array_merge($pStruct,[

        ]);
        return $struct;
    }

}
