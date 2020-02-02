<?php
namespace App\Http\Controllers\Api;

trait Response{
    protected $code=null;
    protected $data=[
        "page"=>[],
        "data"=>[],
        "error"=>[]
    ];

    public function code($code){
        $this->code = $code;
        return $this;
    }

    public function data($data){
        if(is_array($data)){
            $this->data["data"] = $data;
        }else{
            $this->data["data"][]= $data;
        }
        return $this;
    }

    public function page(){
        $this->data["page"] = app("page")->info();
        return $this;
    }

    public function error($error="操作失败"){
        $this->code($this->code?:422);
        if($error instanceof \Illuminate\Validation\Validator){
            $error = $error->errors()->toArray();
        }
        if(is_array($error)){
            $this->data["error"] = array_merge($this->data["error"],$error);
        }else{
            array_push($this->data["error"],$error);
        }
        return $this->go();
    }
    public function success($data=["success"=>true]){
        $this->code(200);
        $this->data($data);
        return $this->go();
    }

    public function result($res){
        if(!$res){
            return $this->error("操作失败");
        }
        return $this->success();
    }

    protected function go()
    {
        return response()->json($this->data,$this->code);
    }

}
