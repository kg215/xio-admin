<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Star extends Model
{
    protected $table = "star";
    protected $fillable = ["uid","article_id"];
}
