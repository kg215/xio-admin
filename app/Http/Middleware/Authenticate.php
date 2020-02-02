<?php
namespace App\Http\Middleware;
use App\Http\Controllers\Api\Response;
use Closure;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    use Response;
    public function handle($request, Closure $next,...$guards)
    {
        if(in_array("web",$guards)&&!Auth::guard("web")->check()){
            return $this->code(401)->error("登录已过期");
        }

        if(in_array("admin",$guards)&&!Auth::guard("admin")->check()){
            return $this->code(401)->error("登录已过期");
        }

        if(in_array("api",$guards)&&!Auth::guard("api")->check()){
            return $this->code(401)->error("token已失效");
        }

        if(in_array("anyone",$guards)){
            if(!Auth::guard("web")->check()&&!Auth::guard("admin")->check()&&!Auth::guard("api")->check()){
                return $this->code(401)->error("身份验证失败");
            }
        }
        return $next($request);
    }
}
