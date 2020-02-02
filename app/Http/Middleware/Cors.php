<?php

namespace App\Http\Middleware;

use Closure;

class Cors
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
        //当前请求客户端
        $origin = $request->server('HTTP_ORIGIN') ? $request->server('HTTP_ORIGIN') : $request->server('REMOTE_ADDR');
        //允许跨域客户端
        $allow_origin = [
            'http://localhost:8080',
            'http://localhost:80',
            'http://www.ooo.test',
            '127.0.0.1'
        ];

        if(!in_array($origin,$allow_origin))
            return $response;

        return $this->setHeaders($response,$origin);
    }

    protected function setHeaders($response,$origin){

        $headers = [
            'Access-Control-Allow-Origin' => $origin,
            'Access-Control-Allow-Headers' => 'Origin, Content-Type, Cookie, X-CSRF-TOKEN, Accept, Authorization, X-XSRF-TOKEN',
            'Access-Control-Expose-Headers' => 'Authorization, authenticated',
            'Access-Control-Allow-Methods' => 'GET, DELETE, POST, PATCH, PUT, OPTIONS',
            'Access-Control-Allow-Credentials' => 'true',
        ];
        //通过跨域设置请求头

        $IlluminateResponse = 'Illuminate\Http\Response'; //我们业务里面一般用这个
        $SymfonyResopnse = 'Symfony\Component\HttpFoundation\Response';
        /************ 因为 response 可能是两个不同的类 设置header 方式不一样 ************/
        if ($response instanceof $IlluminateResponse) {
            foreach ($headers as $key => $value) {
                $response->header($key, $value);
            }
            return $response;
        }
        if ($response instanceof $SymfonyResopnse) {
            foreach ($headers as $key => $value) {
                $response->headers->set($key, $value);
            }
            return $response;
        }
    }
}
