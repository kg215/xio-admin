<?php

namespace App\Http\Controllers\Api;
use App\Http\Controllers\Controller;
use App\Http\Requests\ModifyPassword;
use App\Http\Requests\UserPost;
use App\Model\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    use Response;
    use Login;
    public function register(UserPost $request){
        $args = $request->validated();
        if(User::query()->where("name",$args['name'])->first()){
            return $this->error("用户已存在");
        }
        $res =  User::newOne($args);
        if(!$res){
            return $this->error("创建失败");
        }
        $this->attempt($request);
        return $this->data(["api_token"=>User::getInstance()->api_token]);
    }

    public function login(UserPost $request){
        $request->validated();
        if($this->attempt($request)){
            return $this->success("登陆成功");
        }else{
            return $this->error("账号或密码错误");
        }
    }

    public function modify(ModifyPassword $request){
        $args = $request->validated();
        if($args["newPassword"]!=$args["rePassword"]){
            return response("两次密码输入不一致",422);
        }
        $user = User::check($args);
        if(!$user){
            return response("账号或密码错误",422);
        }
        $res = $user->update([
            "password"=>Hash::make($args['newPassword'])
        ]);
        if(!$res){
            return response("修改失败",503);
        }
        Auth::logout();
        return response("修改成功",200);
    }

    public function logout(){
        Auth::logout();
        return $this->success("已注销");
    }

    public function username()
    {
        return 'username';
    }

}
