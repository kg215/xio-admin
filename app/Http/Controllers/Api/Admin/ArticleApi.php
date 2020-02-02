<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ArticleRules;
use App\Model\Article;
use App\Model\ArticleContent;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ArticleApi extends ApiController
{
    public function index(Request $request){
        $args = $request->all();
        $validator = Validator::make($args,[
            "id"=>"array"
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->toArray());
        }
        $article = Article::query();
        if(!empty($args["id"])){
            $article = $article->whereIn("id",$args["id"]);
            if(sizeof($args["id"])===1){
                $article = $article->with("content");
            }
        }
        $count = $article->count();

        $page = app("page");
        $list = $article->with("user")->with("module")
            ->orderByDesc("id")
            ->offset($page->offset())
            ->limit($page->limit())
            ->get()
            ->toArray();

        return $this->success([
            "list"=>$list,
            "total"=>$count
        ]);
    }

    public function store(ArticleRules $request){
        $args = $request->validated();
        DB::transaction(function () use($args){
            $content = $args["content"];
            $args["uid"] = $this->admin->uid;
            unset($args["content"]);
            $id = Article::query()->insertGetId($args);
            if(!$id){
                throw new \ErrorException("article插入失败",500);
            }
            $articleContent = new ArticleContent([
                "content"=>$content,
                "article_id"=>$id
            ]);
            if(!$articleContent->save()){
                throw new \ErrorException("article content 插入失败",500);
            }
        });

        return $this->success();
    }

    public function destroy(Request $request,$id){
        DB::transaction(function () use($id){
            $article = Article::query()->find($id);
            if(!$article->content->delete()){
                throw new \ErrorException("删除失败",500);
            };
            if(!$article->delete()){
                throw new \ErrorException("删除失败",500);
            }
        });
        return $this->success();
    }


    public function update(Request $request){
        $args = $request->all();
        $validator = Validator::make($args,[
            "id"=>"required|integer",
            "disabled"=>"nullable|integer",
            'title' => 'nullable|string|max:45',
            'module_id' => 'nullable|integer',
            'content' => 'nullable|string'
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->toArray());
        }

        $article = Article::find($args["id"]);
        if(isset($args["content"])){
            $articleContentArgs = [
                "content"=>$args["content"],
                "article_id"=>$args["id"]
            ];
            if(!$article->content->update($articleContentArgs)){
                return $this->error("修改content失败");
            }
            unset($args["content"]);
        }

        $args["uid"] = $this->admin->uid;
        if(!$article->update($args)){
            return $this->error("修改失败");
        }
        return $this->success();
    }

}
