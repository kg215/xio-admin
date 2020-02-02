<?php
/*
 * @Author: kaxio
 * @Date: 2020-01-21 16:27:11
 * @Last Modified by: kaxio
 * @Last Modified time: 2020-01-26 17:32:37
 */
namespace App\Http\Controllers\Api\Web;

use App\Exceptions\AppException;
use App\Http\Controllers\Api\ApiController;
use App\Model\Article;
use App\Model\User;
use Illuminate\Cache\RateLimiter;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class UserApi extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware("auth:web")->except("login","register");
    }

    static function user(){
        return Auth::guard('web')->user();
    }

    /**
     * 用户登陆接口
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-20
     */
    public function login(Request $request){
        $v = Validator::make($request->all(),[
            'username' => 'required|string',
            'password' => 'required|string'
        ],[
            'username.required'=>'用户名未填写',
            'password.required'=>'密码未填写'
        ]);

        if($v->fails()){
            return $this->error($v->errors()->toArray());
        }
        if ($this->usernameLogin($request) || $this->phoneLogin($request)) {
            return $this->success();
        }

        app(RateLimiter::class)->hit(
            Str::lower($request->input("username")).'|'.$request->ip(), 24*60
        );

        return $this->error("用户名或密码错误");
    }

    protected function attemptLogin(array $credentials)
    {
        return Auth::guard('web')->attempt(
            $credentials, true
        );
    }
    protected function usernameLogin(Request $request){
        return $this->attemptLogin($request->only("username", "password"));
    }
    protected function phoneLogin(Request $request){

        return $this->attemptLogin([
            "phone"=>$request->input("username"),
            "password"=>$request->input("password")
        ]);
    }

    /**
     *用户注册
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-21
     */
    public function register(Request $request)
    {
        $v = Validator::make($request->all(),[
            'username' => 'required|regex:/^[\w\d_!@#%&]*$/|min:6|max:30',
            'phone' => 'required|regex:/^1[3-9]\d{9}/',
            'password' => 'required|regex:/^[\w\d_!@#%&]*$/|min:6|max:16'
        ],[
            'username.required'=>'用户名未填写',
            'username.regex'=>'用户名可填写：数字、字母或 _ ! @ # % & ',
            'username.min'=>'用户名太短了(6)',
            'username.max'=>'用户名太长了(30)',
            'phone.required' => '手机号未填写',
            'phone.regex' => '手机号格式错误',
            'password.required'=>'密码未填写',
            'password.regex' => '用户名可填写：数字、字母或 _ ! @ # % &',
            'password.min'=>'密码太短了(6)',
            'password.max'=>'密码太长了(16)',
        ]);


        if(User::query()->where("username",$request->username)->first()){
            return $this->error("用户名已存在");
        }
        if(User::query()->where("phone",$request->phone)->first()){
            return $this->error("手机已注册");
        }

        if($v->fails()){
            return $this->error($v);
        }

        event(new Registered($user = User::create([
            'username' => $request->username,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
        ])));

        $user->update([
            "nickname"=>"用户".substr(md5($user->id),4,6)
        ]);

        Auth::guard("web")->login($user);

        return $this->success();
    }

    /**
     * 用户登出
     *
     * @return void
     * @author kaxio
     * @date 2020-01-21
     */
    public function logout(){
        Auth::guard('web')->logout();
        return $this->success();
    }

    /**
     * 登陆用户信息
     *
     * @return void
     * @author kaxio
     * @date 2020-01-21
     */
    public function info(){
        /**
         * @var App\Model\User $user
         */
        $this->user->makeVisible(["phone","username","birthday"]);
        return $this->success($this->user->toArray());
    }

    /**
     * 某个用户信息
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-21
     */
    public function show($id){
        $data = User::query()->where("uid",$id)->withCount([
            "articles"
        ])->first()->toArray();
        $thumbsUp["article"] = Article::query()->where("uid",$id)->sum("thumbs_up");
        $data["thumbs_up"] = $thumbsUp;
        return $this->success($data);
    }

    /**
     * 用户设置
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-22
     */
    public function setting(Request $request){
        $v = Validator::make($request->all(),[
            "nickname" => [
                "required",
                "string",
                "max:18",
                Rule::unique("user")->ignore($this->user->uid,"uid"),
            ],
            "sex" => [Rule::in([1,0])],
            "birthday" => "nullable|date_format:Y-m-d",
            "desc"=>"nullable|string"
        ],[
            "nickname.required"=>"昵称必须的老铁！",
            "nickname.unique"=>"昵称已存在"
        ]);

        if($v->fails()){
            return $this->error($v);
        }

        $res = $this->user->update($request->only(["nickname","sex","birthday","desc"]));

        if(!$res){
            throw new AppException("更新失败");
        }

        return $this->success($this->user->toArray());
    }

    /**
     * avatar
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-24
     */
    public function avatar(Request $request){
        $path = $request->file("picture")->store('avatars');
        $fullPath = $request->getScheme()."://".$request->getHost()."/storage/app/".$path;
        $res = $this->user->update([
            "avatar"=>$fullPath
        ]);
        if(!$res){
            return $this->error("上传失败");
        }
        return $this->success($fullPath);
    }

}
