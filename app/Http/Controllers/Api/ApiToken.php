<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserPost;
use App\Model\User;

class ApiToken extends Controller
{
    use Response;
    public function get(UserPost $request){
        $args = $request->validated();
        $user = User::check($args);
        if(!$user){
            return $this->error("账号或密码错误");
        }

        return $this->success(["api_token"=>$user->api_token]);
    }

}
