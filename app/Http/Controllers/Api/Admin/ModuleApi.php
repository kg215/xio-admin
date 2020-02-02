<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Api\ApiController;
use App\Model\ArticleModule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ModuleApi extends ApiController
{
    /**
     * 分类列表
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-16
     */
    public function index(Request $request){
        $args = $request->all();
        $validator = Validator::make($args,[
            "id"=>"array"
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->toArray());
        }
        $articleModule = ArticleModule::query();
        if(!empty($args["id"])){
            $articleModule = $articleModule->whereIn("id",$args["id"]);
        }
        $count = $articleModule->count();

        $page = app("page");
        $list = $articleModule->orderByDesc("id")->offset($page->offset())
            ->limit($page->limit())
            ->get()
            ->toArray();

        return $this->success([
            "list"=>$list,
            "total"=>$count
        ]);
    }

    /**
     * 增加分类
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-16
     */
    public function store(Request $request){
        $args = $request->all();
        $validator = Validator::make($args,[
            "title"=>"required|string",
            "desc"=>"nullable",
        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->toArray());
        }
        if(ArticleModule::query()->where("title",$args["title"])->count()>0){
            return $this->error("分类已存在");
        }
        $articleModule = new ArticleModule($args);
        if(!$articleModule->save()){
            return $this->error("添加失败");
        }

        return $this->success();
    }

    /**
     * 删除分类
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-16
     */
    public function destroy(Request $request,$id){
        $articleModule = ArticleModule::query()->find($id);
        try{
            if(!$articleModule->delete()){
                return $this->error("删除失败");
            }
            return $this->success();
        }catch (\Exception $e){
            return $this->error($e->getMessage());
        }
    }

    /**
     * 修改分类
     *
     * @param Request $request
     * @return void
     * @author kaxio
     * @date 2020-01-16
     */
    public function update(Request $request){
        $args = $request->all();
        $validator = Validator::make($args,[
            "id"=>"required|integer",
            "desc"=>"nullable",
            'title' => 'nullable|string|max:50',

        ]);
        if($validator->fails()){
            return $this->error($validator->errors()->toArray());
        }
        if(ArticleModule::query()->where("id","!=",$args["id"])->where("title",$args["title"])->count()>0){
            return $this->error("分类已存在");
        }

        $articleModule = ArticleModule::query()->find($args["id"]);
        if(!$articleModule->update($args)){
            return $this->error("修改失败");
        }
        return $this->success();
    }

}
