<?php

namespace App\Http\Controllers\Api\Web;

use App\Http\Controllers\Api\ApiController;
use Illuminate\Http\Request;

class UploadApi extends ApiController
{

    public function store(Request $request){
        $path = $request->file("picture")->store('web/user');
        $fullPath = $request->getScheme()."://".$request->getHost()."/storage/app/".$path;
        return $this->success($fullPath);
    }
}
