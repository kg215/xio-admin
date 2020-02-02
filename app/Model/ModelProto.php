<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class ModelProto extends Model
{

    static $instance=null;

    static function getInstance($args=[]){
        if(!self::$instance){
            self::$instance = new static($args);
        }

        return self::$instance;
    }

}
