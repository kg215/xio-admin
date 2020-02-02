<?php

namespace App\Model;

use Illuminate\Support\Facades\Hash;

use Illuminate\Auth\Authenticatable;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Foundation\Auth\Access\Authorizable;

use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Contracts\Auth\Access\Authorizable as AuthorizableContract;
use Illuminate\Contracts\Auth\CanResetPassword as CanResetPasswordContract;
use Illuminate\Database\Eloquent\Builder;

class User extends ModelProto implements AuthenticatableContract,  AuthorizableContract,  CanResetPasswordContract
{
    use Authenticatable, Authorizable, CanResetPassword;
    protected $table="user";
    protected $primaryKey="uid";
    protected $fillable = ['nickname','desc','sex','avatar','phone','email','birthday','username','password', 'api_token', 'remember_token'];
    protected $hidden = [
        'password', 'api_token', 'remember_token','phone','email','birthday','username'
    ];
    protected $apiTokenName = "api_token";

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);
        $this->password =  Hash::make($this->password);
    }


    static function newOne($args){
        return self::getInstance($args)->makeToken()->save();
    }

    public function makeToken(){
        $this->api_token = hash("sha256",$this->name.$this->password);
        return $this;
    }

    static function check($args){
        $user = self::query()->where("name",$args['name'])->first();
        if(!$user || !Hash::check($args["password"],$user->password)){
            return false;
        }
        return $user;
    }

    public function articles(){
        return $this->hasMany(Article::class,"uid","uid");
    }

}
