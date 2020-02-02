<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\ApiController;
use App\Model\Article;
use App\Model\ArticleContent;
use Illuminate\Validation\Rule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use voku\helper\HtmlDomParser;

class UserArticleApi extends ApiController
{

    public function index(){
        $data = Article::query()->where("uid",$this->user->uid)->with("content")->get();
        $list = [];
        foreach($data as $item){
            $list[$item["group_id"]]??$list[$item["group_id"]]=[];
            $list[$item["group_id"]][]=$item;
        }
        return $this->success($list);
    }

    public function store(Request $request){
        $v = Validator::make($request->all(),[
            "title"=>"nullable|max:50",
            "content"=>"nullable",
            "group_id"=>"integer",
            "disabled"=>[Rule::in([0,1])],
        ]);

        if($v->fails()){
            return $this->error($v);
        }


        DB::transaction(function() use($request){
            $content = $request->input("content");
            //截取第一张图片
            $dom = HtmlDomParser::str_get_html($content);
            $element = $dom->findOne('img');
            $src="";
            if ($element->hasAttribute('src')) {
                $src = $element->getAttribute('src');
            }
            $article = Article::create([
                "title"=>$request->input("title")?:"(无标题)",
                "group_id"=>$request->input("group_id",0),
                "disabled"=>$request->input("disabled",0),
                "uid"=>$this->user->uid,
                "nickname"=>$this->user->nickname,
                "intro"=>mb_substr(strip_tags($content),0,255),
                "intro_img"=>$src
            ]);
            if($content){
                ArticleContent::create([
                    "article_id"=>$article->id,
                    "content"=>$content
                ]);
            }
        });

        return $this->success();
    }

    public function update(Request $request,$id){
        $v = Validator::make($request->all(),[
            "title"=>"nullable|max:50",
            "content"=>"nullable",
            "group_id"=>"integer",
            "disabled"=>[Rule::in([0,1])],
        ]);
        if($v->fails()){
            return $this->error($v);
        }
        DB::transaction(function() use($request,$id){
            $content = $request->input("content");
            //截取第一张图片
            $dom = HtmlDomParser::str_get_html($content);
            $element = $dom->findOne('img');
            $src="";
            if ($element->hasAttribute('src')) {
                $src = $element->getAttribute('src');
            }

            $article = Article::find($id)->update([
                "title"=>$request->input("title")??"(无标题)",
                "group_id"=>$request->input("group_id",0),
                "disabled"=>$request->input("disabled",0),
                "intro"=>mb_substr(strip_tags($content),0,255),
                "intro_img"=>$src
            ]);
            if($article&&$content){
                ArticleContent::updateOrCreate(
                    ["article_id"=>$id],
                    ["content"=>$content]
                );
            }
        });
        return $this->success();
    }


    public function destroy(Request $request,$id){
        $res = Article::find($id)->delete();
        return $this->result($res);
    }

    public function move(Request $request,$id){
        $request->validate([
            "group_id"=>"required|integer"
        ]);

        $res = Article::find($id)->update([
            "group_id"=>$request->input("group_id")
        ]);

        $this->result($res);
    }

}
