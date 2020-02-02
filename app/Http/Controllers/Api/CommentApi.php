<?php

namespace App\Http\Controllers\Api;

use App\Exceptions\AppException;
use App\Model\Comment;
use App\Model\ThumbsUp;
use App\Model\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class CommentApi extends ApiController
{
    public function show(Request $request){
        $request->validate([
            "article_id"=>"integer|nullable"
        ]);

        $page = app("page");
        $comment = Comment::query();
        if($request->has("article_id")){
            $comment = $comment->where("pid",0)->where("article_id",$request->input("article_id"))->with("reply");
        }
        $count = $comment->count();
        $list = $comment->orderBy("created_at","desc")
            ->offset($page->offset($count))
            ->limit($page->limit())
            ->with("article")
            ->with("user")
            ->get()
            ->toArray();

        return $this->success([
            "list"=>$list,
            "total"=>$count,
            "total_page"=>$page->totalPage()
        ]);
    }

    public function send(Request $request){
        $v = Validator::make($request->all(),[
            "article_id"=>"required|integer",
            "comment"=>"required|string|max:65533",
            "pid"=>"nullable|integer",
            "reply_to"=>"nullable|integer"
        ],[
            "comment.required"=>"你没有填写评论，憨批！",
            "comment.max"=>"写这么多想干哈啊",
        ]);

        if($v->fails()){
            return $this->error($v);
        }

        $data = array_merge(
            $request->only("comment","pid","article_id"),
            [
                "uid"=>$this->user->uid,
            ]
        );

        if($request->has("reply_to")){
            $replyTo = $request->input("reply_to");
            $user = User::find($replyTo);
            $data["reply_to"] = $user->uid;
        }

        $comment = Comment::create($data);
        if(!$comment){
            return $this->error("评论失败");
        }
        $data = Comment::with("user")->with("replyUser")->find($comment->id)->toArray();
        return $this->success($data);
    }

    public function update(Request $request){
        $args = $request->all();
        $valid = Validator::make($args,[
            "id"=>"required|integer",
            "disabled"=>"integer"
        ]);

        if($valid->fails()){
            return $this->error($valid->errors());
        }
        $res = Comment::query()->find($args['id'])->update($args);
        if(!$res){
            return $this->error("更新失败");
        }
        return $this->success();
    }

    public function thumbsUp(Request $request,$id){
        $request->validate([
            "up"=>"required|integer"
        ]);
        $up = $request->input("up");
        $uid = $this->user->uid;
        $comment = Comment::find($id);
        if(!$comment){
            throw new AppException("评论已删除");
        }

        DB::transaction(function () use($id,$uid,$comment,$up) {

            $m = ThumbsUp::comment()->where("uid",$uid)->where("obj_id",$id)->first();
            $num = null;
            if(!$up&&$m){
                //如果m存在就取消点赞
                $m->delete();
                $num = max($comment->thumbs_up-1,0);
            }
            if($up&&!$m){
                ThumbsUp::create([
                    "uid"=>$uid,
                    "obj_id"=>$id,
                    "type"=>ThumbsUp::$TypeComment
                ]);
                $num = $comment->thumbs_up+1;
            }
            if($num!==null){
                $comment->update([
                    "thumbs_up"=>$num
                ]);
            }
        });

        return $this->success();
    }

    public function complaint($id){
        $comment = Comment::find($id);
        if(!$comment){
            throw new AppException("评论已删除");
        }
        $comment->update([
            "complaint"=>$comment->complaint+1
        ]);

        return $this->success();
    }

    public function destroy($id){
        $comment = Comment::query()->where("id",$id)->where("uid",$this->user->uid)->first();
        if(!$comment){
            return $this->error("评论不存在");
        }
        try{
            DB::transaction(function () use($comment) {
                Comment::query()->where("pid",$comment->id)->delete();
                $comment->delete();
            });
        }catch(Exception $e){
            return $this->error("删除失败");
        }
        return $this->success();
    }


}
