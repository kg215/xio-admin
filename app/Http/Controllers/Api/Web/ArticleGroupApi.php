<?php
/*
 * @Author: kaxio
 * @Date: 2020-01-26 17:32:12
 * @Last Modified by: kaxio
 * @Last Modified time: 2020-01-27 01:09:25
 */
namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\ApiController;
use App\Http\Requests\ArticleGroupStore;
use App\Model\Article;
use App\Model\ArticleGroup;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class ArticleGroupApi extends ApiController{

    public function index(){
        $data = ArticleGroup::query()->orderBy('path', 'desc')->where("uid",$this->user->uid)->get()->toArray();

        $list = [];
        foreach($data as $item){
            $list[$item["pid"]]??$list[$item["pid"]]=[];
            $list[$item["pid"]][]=$item;
        }

        return $this->success($list);
    }

    public function store(ArticleGroupStore $request){
        $request->validated();
        $pid = $request->input("pid",0);
        $uid = $this->user->uid;
        $path = "0";

        if($pid){
            $mo = ArticleGroup::query()->where("id",$pid)->first();
            $path = $mo->path;
        }

        try{
            $mo = ArticleGroup::create(array_merge($request->only(["title"]),compact("pid","uid")));
            $path = $path."-".$mo->id;
            $mo->fill(["path"=>$path]);
            $mo->save();
        }catch(Exception $e){
            return $this->error($e->getMessage());
        }

        return $this->success($mo->toArray());
    }

    /**
     * 更新标题
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     * @author kaxio
     * @date 2020-01-27
     */
    public function update(Request $request,$id){

        $v = Validator::make($request->all(),[
            "title"=>[
                "required",
                "max:45",
                Rule::unique('article_group')->where(function ($query) {
                    return $query->where('uid', $this->user->uid);
                })->ignore($id)
            ]
        ],[
            'title.required' => '标题未填写',
            'title.max' => '标题不能超过45个字',
            'title.unique' => '分组已存在',
        ]);

        if($v->fails()){
            return $this->error($v);
        }

        $res = ArticleGroup::find($id)->update($request->only("title"));

        if(!$res){
            return $this->error($res);
        }

        return $this->success();
    }

    /**
     * 更新pid
     *
     * @param Request $request
     * @param [type] $id
     * @return void
     * @author kaxio
     * @date 2020-01-27
     */
    public function pid(Request $request,$id){
        $request->validate([
            "pid"=>[
                "required",
                "integer"
            ]
        ]);
        $pid = $request->input("pid");
        if($pid!=0 && !ArticleGroup::find($pid)){
            return $this->error("父级不存在");
        }

        $res = ArticleGroup::find($id)->update($request->only("pid"));

        return $this->result($res);
    }

    /**
     * 删除
     *
     * @return void
     * @author kaxio
     * @date 2020-01-27
     */
    public function destroy(Request $request,$id){
        $g = ArticleGroup::query()->where("pid",$id)->first();
        $a = Article::query()->where("group_id",$id)->first();
        if($g || $a){
            return $this->error("分组下文件未删除");
        }

        $res = ArticleGroup::find($id)->delete();
        if(!$res){
            return $this->error("删除失败");
        }

        return $this->success();
    }

}

