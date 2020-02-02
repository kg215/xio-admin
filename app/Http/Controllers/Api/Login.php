<?php
namespace App\Http\Controllers\Api;

use App\Exceptions\AppException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

trait Login{

    public function attempt(Request $request){
        $args = $request->all();
        Auth::attempt($args, true);
        Session::save();

        return Auth::check();
    }

    public function hashLogin(Request $request){
        $r = Auth::guard('web')->attempt($request->only(["name","password"]),true);
        if(!$r){
            throw new AppException("账号或密码错误");
        }
    }

}
