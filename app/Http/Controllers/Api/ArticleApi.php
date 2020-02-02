<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AppException;
use App\Model\Article;
use App\Model\ArticleContent;
use App\Model\Star;
use App\Model\ThumbsUp;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class ArticleApi extends ApiController
{

    public function __construct()
    {
        parent::__construct();
        $this->middleware("auth:web")->except("index","show");
        $this->user = Auth::guard('web')->user();
    }

    public function index(Request $request){

        $request->validate([
            "sort" => [
                Rule::in(["desc","asc"])
            ],
            "field" => [
                Rule::in(["footstep","created_at"])
            ],
            "pageIndex" => "integer",
            "uid"=>"integer"
        ]);
        $article = Article::query()->where("disabled",1);
        if($request->filled("uid")){
            $article = $article->where("uid",$request->input("uid"));

        }
        if($request->filled(["sort","field"])){
            $article = $article->orderBy($request->input("field"),$request->input("sort"));
        }

        $page = app("page");
        $data = $article->offset($page->offset($article->count()))->limit($page->limit())->with("user")->with("group")->withCount([
            "comment"=>function(Builder $query){
                $query->where("pid",0);
            }
        ])->get()->toArray();

        return $this->page()->success($data);
    }

    public function show($id){
        $article = Article::query()->where("id",$id)->where("disabled",1)->first();

        if($article){
            $article->update([
                "footstep"=>$article->footstep+1
            ]);
        }else{
            return $this->error("文章不存在");
        }
        $data = $article->toArray();
        $data["content"] = "";
        $content = ArticleContent::query()->where("article_id",$id)->first();
        if($content){
            $data["content"] = $content->content;
        }
        $data["has_thumbs_up"]=false;
        $data["has_star"]=false;
        //登陆的情况下，我是否点赞了
        if($this->user){
            $uid = $this->user->uid;
            $m1 = ThumbsUp::article()->where("uid",$uid)->where("obj_id",$id)->first();
            $data["has_thumbs_up"] = !!$m1;
            $m2 = Star::query()->where("uid",$uid)->where("article_id",$id)->first();
            $data["has_star"] = !!$m2;
        }
        return $this->success($data);
    }

    public function thumbsUp($id){
        $uid = $this->user->uid;
        $article = Article::find($id);
        if(!$article){
            throw new AppException("文章不存在");
        }
        $hasThumbsUp = false;
        DB::transaction(function () use($id,$uid,$article,&$hasThumbsUp) {
            $m = ThumbsUp::article()->where("uid",$uid)->where("obj_id",$id)->first();
            if($m){
                //如果m存在就取消点赞
                $m->delete();
                $article->update([
                    "thumbs_up"=>max($article->thumbs_up-1,0)
                ]);
                $hasThumbsUp = false;
            }else{
                ThumbsUp::create([
                    "uid"=>$uid,
                    "obj_id"=>$id,
                    "type"=>ThumbsUp::$TypeArticle
                ]);
                $article->update([
                    "thumbs_up"=>$article->thumbs_up+1
                ]);
                $hasThumbsUp = true;
            }
        });

        $data = $article->toArray();
        $data["has_thumbs_up"] = $hasThumbsUp;

        return $this->success($data);
    }

    public function star($id){
        $uid = $this->user->uid;
        $article = Article::find($id);
        if(!$article){
            throw new AppException("文章不存在");
        }
        $hasStar = false;
        DB::transaction(function () use($id,$uid,$article,&$hasStar) {
            $m = Star::query()->where("uid",$uid)->where("article_id",$id)->first();
            if($m){
                //如果m存在就取消收藏
                $m->delete();
                $article->update([
                    "star"=>max($article->star-1,0)
                ]);
                $hasStar = false;
            }else{
                Star::create([
                    "uid"=>$uid,
                    "article_id"=>$id,
                ]);
                $article->update([
                    "star"=>$article->star+1
                ]);
                $hasStar = true;
            }
        });

        $data = $article->toArray();
        $data["has_star"] = $hasStar;

        return $this->success($data);
    }

}
